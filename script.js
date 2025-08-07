class RotatingGallery {
    constructor() {
        // DOM Elements
        this.slider = document.querySelector('.slider');
        this.items = document.querySelectorAll('.item');
        this.centerImageContainer = document.querySelector('.center-image');
        this.centerImage = this.centerImageContainer.querySelector('img');
        
        // Configuration
        this.totalItems = this.items.length;
        this.radius = this.getResponsiveRadius();
        this.rotationPaused = false;
        this.currentRotation = 0;
        this.isChanging = false;
        this.rotationDirection = 'clockwise';
        this.showHoverEffects = true;
        this.tiltAngle = 15;
        this.isManualMode = false;
        this.rotationSpeed = 30; // Default speed in seconds
        
        // Initialize
        this.init();
    }

    getResponsiveRadius() {
        const width = window.innerWidth;
        if (width <= 480) {
            return 180; // Small mobile
        } else if (width <= 768) {
            return 220; // Mobile
        } else if (width <= 1024) {
            return 300; // Tablet
        } else {
            return 420; // Desktop
        }
    }

    init() {
        this.setupInitialState();
        this.positionItems();
        this.rotationTimeline = this.createRotation();
        this.setupEventListeners();
        this.animateCenterImageFloat();
        this.setupResizeHandler();
    }

    setupInitialState() {
        gsap.set(this.slider, {
            transformPerspective: 1000,
            rotationY: 0,
            ease: "none"
        });
    }

    positionItems() {
        this.items.forEach((item, index) => {
            const angle = (index * 360) / this.totalItems;
            
            gsap.set(item, {
                rotationY: angle,
                rotationX: -this.tiltAngle,
                rotationZ: 0,
                transformOrigin: `50% 50% -${this.radius}px`,
                x: 0,
                y: 0,
                z: this.radius,
                opacity: 1
            });
        });
        
        // Ensure slider has proper 3D perspective
        gsap.set(this.slider, {
            transformPerspective: 1000,
            rotationY: 0,
            ease: "none"
        });
    }

    updateTiltAngle(newAngle) {
        this.tiltAngle = newAngle;
        // Use GSAP's to() method to smoothly animate only the rotationX
        this.items.forEach((item) => {
            gsap.to(item, {
                rotationX: -newAngle,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    }

    setupResizeHandler() {
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                this.handleResize();
            }, 250);
        });
    }

    handleResize() {
        const newRadius = this.getResponsiveRadius();
        if (newRadius !== this.radius) {
            this.radius = newRadius;
            this.positionItems();
        }
    }

    animateCenterImageFloat() {
        gsap.to(this.centerImageContainer, {
            y: 20,
            duration: 2,
            yoyo: true,
            repeat: -1,
            ease: "sine.inOut"
        });
    }

    updateCenterImage() {
        if (this.isChanging || this.rotationPaused) return;
        
        const rotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
        const currentIndex = Math.round(rotation / itemAngle) % this.totalItems;
        
        const frontItem = this.items[currentIndex];
        if (frontItem) {
            const frontImage = frontItem.querySelector('img');
            this.isChanging = true;
            
            // Start fade out
            this.centerImageContainer.classList.add('changing');
            
            // Change image after fade out
            setTimeout(() => {
                this.centerImage.src = frontImage.src;
                // Start fade in
                this.centerImageContainer.classList.remove('changing');
                setTimeout(() => {
                    this.isChanging = false;
                }, 500); // Wait for fade in to complete
            }, 500); // Wait for fade out to complete
        }
    }

    createRotation() {
        const direction = this.rotationDirection === 'clockwise' ? 1 : -1;
        
        const timeline = gsap.timeline({
            repeat: -1,
            paused: this.rotationPaused,
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
                if (!this.rotationPaused && Math.abs(this.currentRotation % (360/this.totalItems)) < 1) {
                    this.updateCenterImage();
                }
            }
        });
        
        timeline.to(this.slider, {
            duration: this.rotationSpeed,
            rotationY: `+=${360 * direction}`,
            ease: "none"
        });
        
        return timeline;
    }

    handleItemHover(item, isEnter) {
        if (!this.showHoverEffects) return;
        
        if (isEnter) {
            if (!this.rotationPaused) {
                this.rotationTimeline.pause();
                this.rotationPaused = true;
            }

            gsap.to(item, {
                duration: 0.3,
                scale: 1.2,
                ease: "power2.inOut"
            });
        } else {
            // Only resume if we're in auto mode (not manual mode)
            if (!this.isManualMode) {
                this.rotationTimeline.play();
                this.rotationPaused = false;
            }

            gsap.to(item, {
                duration: 0.3,
                scale: 1,
                ease: "power2.inOut"
            });
        }
    }

    setupEventListeners() {
        this.items.forEach(item => {
            item.addEventListener('mouseenter', () => this.handleItemHover(item, true));
            item.addEventListener('mouseleave', () => this.handleItemHover(item, false));
            item.addEventListener('click', () => this.handleItemClick(item));
        });

        // Add center image event listeners
        this.centerImageContainer.addEventListener('mouseenter', () => this.handleCenterImageHover(true));
        this.centerImageContainer.addEventListener('mouseleave', () => this.handleCenterImageHover(false));
        this.centerImageContainer.addEventListener('click', () => this.handleCenterImageClick());
    }

    handleCenterImageHover(isEnter) {
        if (isEnter) {
            // Pause rotation when hovering center image (only in auto mode)
            if (!this.isManualMode) {
                this.rotationTimeline.pause();
                this.rotationPaused = true;
            }
            
            // Add hover effect to center image
            gsap.to(this.centerImageContainer, {
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out"
            });
        } else {
            // Resume rotation when leaving center image (only in auto mode)
            if (!this.isManualMode) {
                this.rotationTimeline.play();
                this.rotationPaused = false;
            }
            
            // Remove hover effect
            gsap.to(this.centerImageContainer, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        }
    }

    handleCenterImageClick() {
        // Get the current front item (the one that matches center image)
        const rotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
        const currentIndex = Math.round(rotation / itemAngle) % this.totalItems;
        const frontItem = this.items[currentIndex];
        
        if (frontItem) {
            // Open modal with the front item
            showModal(frontItem);
        }
    }

    handleItemClick(item) {
        showModal(item);
    }

    // Public methods for controls
    pause() {
        this.rotationTimeline.pause();
        this.rotationPaused = true;
    }

    play() {
        this.rotationTimeline.play();
        this.rotationPaused = false;
    }

    setRotationSpeed(duration) {
        this.rotationSpeed = duration;
        if (this.rotationTimeline) {
            this.rotationTimeline.duration(duration);
        }
        console.log(`Rotation speed set to ${duration} seconds`);
    }

    setRotationDirection(direction) {
        this.rotationDirection = direction;
        // Don't reposition items - just recreate the rotation
        this.recreateRotation();
        console.log(`Rotation direction set to ${direction}`);
    }

    setHoverEffects(enabled) {
        this.showHoverEffects = enabled;
    }

    setTiltAngle(angle) {
        this.updateTiltAngle(angle);
    }

    setRadius(radius) {
        this.radius = radius;
        this.positionItems();
    }

    // Rotation control methods
    setRotationMode(mode) {
        if (mode === 'loop') {
            // Rotation On - Auto rotation with hidden controls
            this.isManualMode = false;
            this.hideNavigationControls();
            this.rotationPaused = false;
            // Recreate rotation timeline to ensure it's in a clean state
            this.recreateRotation();
        } else {
            // Rotation Off - Manual navigation with visible controls
            this.isManualMode = true;
            if (this.rotationTimeline) {
                this.rotationTimeline.pause();
            }
            this.rotationPaused = true;
            this.showNavigationControls();
        }
    }

    showNavigationControls() {
        const navigationButtons = document.getElementById('navigationButtons');
        const paginationContainer = document.getElementById('paginationContainer');
        
        if (navigationButtons) {
            navigationButtons.style.display = 'flex';
        }
        if (paginationContainer) {
            paginationContainer.style.display = 'flex';
        }
        
        // Create pagination dots if they don't exist
        this.createPaginationDots();
    }

    hideNavigationControls() {
        const navigationButtons = document.getElementById('navigationButtons');
        const paginationContainer = document.getElementById('paginationContainer');
        
        if (navigationButtons) {
            navigationButtons.style.display = 'none';
        }
        // Hide pagination dots in auto mode
        if (paginationContainer) {
            paginationContainer.style.display = 'none';
        }
    }

    createPaginationDots() {
        const paginationDots = document.getElementById('paginationDots');
        if (!paginationDots) return;
        
        // Clear existing dots
        paginationDots.innerHTML = '';
        
        // Create dots for each item
        for (let i = 0; i < this.totalItems; i++) {
            const dot = document.createElement('div');
            dot.className = 'pagination-dot';
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                this.goToImage(i);
            });
            paginationDots.appendChild(dot);
        }
        
        // Update active dot
        this.updatePaginationDots();
    }

    updatePaginationDots() {
        const dots = document.querySelectorAll('.pagination-dot');
        const currentIndex = this.getCurrentImageIndex();
        
        dots.forEach((dot, index) => {
            if (index === currentIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }

    recreateRotation() {
        const wasPlaying = !this.rotationPaused;
        const currentRotation = this.currentRotation;
        
        // Kill the existing timeline
        if (this.rotationTimeline) {
            this.rotationTimeline.kill();
        }
        
        // Create new timeline
        this.rotationTimeline = this.createRotation();
        
        // Set the current rotation position
        gsap.set(this.slider, { rotationY: currentRotation });
        
        // Start playing if it should be playing
        if (wasPlaying) {
            this.rotationTimeline.play();
            this.rotationPaused = false;
        } else {
            this.rotationTimeline.pause();
            this.rotationPaused = true;
        }
    }

    goToImage(index) {
        const currentRotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
    
        const currentIndex = Math.round(currentRotation / itemAngle) % this.totalItems;
    
        let targetIndex = index;
        let difference = targetIndex - currentIndex;
    
        // Handle shortest path rotation with wrapping
        if (difference > this.totalItems / 2) {
            difference -= this.totalItems;
        } else if (difference < -this.totalItems / 2) {
            difference += this.totalItems;
        }
    
        const targetRotation = this.currentRotation + difference * itemAngle;
    
        // Kill any ongoing rotation tweens
        gsap.killTweensOf(this.slider);
    
        gsap.to(this.slider, {
            rotationY: targetRotation,
            duration: 1,
            ease: "power2.inOut",
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
            },
            onComplete: () => {
                this.updateCenterImage();
                this.updatePaginationDots();
            }
        });
    }
    
    
    nextImage() {
        const rotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
        const currentIndex = Math.round(rotation / itemAngle) % this.totalItems;
        const nextIndex = (currentIndex + 1) % this.totalItems;
    
        this.goToImage(nextIndex);
    }
    
    previousImage() {
        const rotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
        const currentIndex = Math.round(rotation / itemAngle) % this.totalItems;
        const prevIndex = (currentIndex - 1 + this.totalItems) % this.totalItems;
    
        this.goToImage(prevIndex);
    }
    





    randomize() {
        const randomIndex = Math.floor(Math.random() * this.totalItems);
        this.goToImage(randomIndex);
    }

    reset() {
        gsap.to(this.slider, {
            rotationY: 0,
            duration: 1,
            ease: "power2.inOut",
            onComplete: () => {
                this.currentRotation = 0;
                this.updateCenterImage();
            }
        });
    }

    getCurrentImageIndex() {
        const rotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
        return Math.round(rotation / itemAngle) % this.totalItems;
    }


}

// Control Manager Class
class ControlManager {
    constructor(gallery) {
        this.gallery = gallery;
        this.setupControls();
    }

    setupControls() {
        // Rotation Speed
        const rotationSpeedSlider = document.getElementById('rotationSpeed');
        const speedValue = document.getElementById('speedValue');
        
        rotationSpeedSlider.addEventListener('input', (e) => {
            const speed = e.target.value;
            speedValue.textContent = `${speed}s`;
            this.gallery.setRotationSpeed(parseInt(speed));
        });

        // Rotation Direction
        const rotationDirectionSelect = document.getElementById('rotationDirection');
        rotationDirectionSelect.addEventListener('change', (e) => {
            this.gallery.setRotationDirection(e.target.value);
        });

        // Rotation Control
        const rotationControlSelect = document.getElementById('rotationControl');
        rotationControlSelect.addEventListener('change', (e) => {
            this.gallery.setRotationMode(e.target.value);
        });

        // Navigation Buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                this.gallery.previousImage();
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                this.gallery.nextImage();
            });
        }

        // Update current image index
        this.updateCurrentImageIndex();
        setInterval(() => {
            this.updateCurrentImageIndex();
        }, 100);
    }

    updateCurrentImageIndex() {
        // Update pagination dots
        this.gallery.updatePaginationDots();
    }
}

// Modal functionality
const modal = document.getElementById('modal');
const modalImg = document.getElementById('modalImg');
const modalTitle = document.getElementById('modalTitle');
const modalDescription = document.getElementById('modalDescription');
const modalBtn = document.getElementById('modalBtn');
const closeBtn = document.getElementById('closeBtn');

function showModal(item) {
    const img = item.querySelector('img');
    const title = item.getAttribute('data-title');
    const description = item.getAttribute('data-description');
    const url = item.getAttribute('data-url');

    // Set modal content
    modalImg.src = img.src;
    modalImg.alt = img.alt;
    modalTitle.textContent = title;
    modalDescription.textContent = description;
    modalBtn.onclick = () => window.open(url, '_blank');

    // Show modal with animation
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        modal.style.opacity = '1';
        gsap.fromTo(modal.querySelector('.modal-content'), 
            {
                scale: 0.5,
                rotateY: 10
            },
            {
                scale: 1,
                rotateY: 0,
                duration: 0.4,
                ease: "back.out(1.7)"
            }
        );
    });

    // Pause the rotation
    gallery.pause();
}

function hideModal() {
    gsap.to(modal.querySelector('.modal-content'), {
        scale: 0.5,
        rotateY: -10,
        duration: 0.3,
        ease: "power2.in",
        onComplete: () => {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    });

    // Resume the rotation
    gallery.play();
}

// Close modal events
closeBtn.addEventListener('click', hideModal);
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        hideModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.style.display === 'flex') {
        hideModal();
    }
});

// Initialize the gallery when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const gallery = new RotatingGallery();
    
    // Make gallery globally accessible
    window.gallery = gallery;
    
    // Initialize control manager
    const controlManager = new ControlManager(gallery);
    
    // Set initial rotation mode (default to 'loop' - Rotation On)
    gallery.setRotationMode('loop');
});