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
                rotationX: -15,
                transformOrigin: `50% 50% -${this.radius}px`,
                z: this.radius,
                x: 0,
                y: 0,
                opacity: 1
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
        return gsap.timeline({
            repeat: -1,
            paused: this.rotationPaused,
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
                if (!this.rotationPaused && Math.abs(this.currentRotation % (360/this.totalItems)) < 1) {
                    this.updateCenterImage();
                }
            }
        }).to(this.slider, {
            duration: 30,
            rotationY: "+=360",
            ease: "none"
        });
    }

    handleItemHover(item, isEnter) {
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
            this.rotationTimeline.play();
            this.rotationPaused = false;

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
            // Pause rotation when hovering center image
            this.rotationTimeline.pause();
            this.rotationPaused = true;
            
            // Add hover effect to center image
            gsap.to(this.centerImageContainer, {
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out"
            });
        } else {
            // Resume rotation when leaving center image
            this.rotationTimeline.play();
            this.rotationPaused = false;
            
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

    // Public methods
    pause() {
        this.rotationTimeline.pause();
        this.rotationPaused = true;
    }

    play() {
        this.rotationTimeline.play();
        this.rotationPaused = false;
    }

    setRotationSpeed(duration) {
        this.rotationTimeline.duration(duration);
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
});
