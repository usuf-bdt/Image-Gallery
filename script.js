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
        this.loopMode = 'continuous';
        this.loopCount = 0; // 0 means infinite
        this.loopDelay = 0;
        this.currentLoopCount = 0;
        this.showHoverEffects = true;
        this.tiltAngle = 15;
        
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
                transformOrigin: `50% 50% -${this.radius}px`,
                z: this.radius,
                x: 0,
                y: 0,
                opacity: 1
            });
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
        let repeat = 0;
        
        // Set repeat based on loop mode
        switch (this.loopMode) {
            case 'continuous':
                repeat = this.loopCount === 0 ? -1 : this.loopCount;
                break;
            case 'pingpong':
                repeat = this.loopCount === 0 ? -1 : this.loopCount * 2;
                break;
            case 'bounce':
                repeat = this.loopCount === 0 ? -1 : this.loopCount * 2;
                break;
            case 'reverse':
                repeat = this.loopCount === 0 ? -1 : this.loopCount;
                break;
            case 'none':
                repeat = 0;
                break;
        }
        
        const timeline = gsap.timeline({
            repeat: repeat,
            paused: this.rotationPaused,
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
                if (!this.rotationPaused && Math.abs(this.currentRotation % (360/this.totalItems)) < 1) {
                    this.updateCenterImage();
                }
            },
            onRepeat: () => {
                this.currentLoopCount++;
                if (this.loopDelay > 0) {
                    this.rotationTimeline.pause();
                    setTimeout(() => {
                        this.rotationTimeline.play();
                    }, this.loopDelay * 1000);
                }
            },
            onComplete: () => {
                if (this.loopMode === 'pingpong' || this.loopMode === 'bounce') {
                    this.handlePingPongComplete();
                }
            }
        });
        
        // Create the rotation animation based on loop mode
        switch (this.loopMode) {
            case 'pingpong':
            case 'bounce':
                timeline.to(this.slider, {
                    duration: 30,
                    rotationY: `+=${360 * direction}`,
                    ease: "none"
                }).to(this.slider, {
                    duration: 30,
                    rotationY: `-=${360 * direction}`,
                    ease: "none"
                });
                break;
            case 'reverse':
                timeline.to(this.slider, {
                    duration: 30,
                    rotationY: `-=${360 * direction}`,
                    ease: "none"
                });
                break;
            default:
                timeline.to(this.slider, {
                    duration: 30,
                    rotationY: `+=${360 * direction}`,
                    ease: "none"
                });
        }
        
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
        this.rotationTimeline.duration(duration);
    }

    setRotationDirection(direction) {
        this.rotationDirection = direction;
        this.recreateRotation();
    }

    setLoopMode(mode) {
        this.loopMode = mode;
        this.currentLoopCount = 0;
        this.recreateRotation();
    }

    setLoopCount(count) {
        this.loopCount = count;
        this.currentLoopCount = 0;
        this.recreateRotation();
    }

    setLoopDelay(delay) {
        this.loopDelay = delay;
    }

    handlePingPongComplete() {
        // Handle ping pong completion if needed
        console.log('Ping pong cycle completed');
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

    recreateRotation() {
        const wasPlaying = !this.rotationPaused;
        this.rotationTimeline.kill();
        this.rotationTimeline = this.createRotation();
        if (wasPlaying) {
            this.rotationTimeline.play();
            this.rotationPaused = false;
        }
    }

    goToImage(index) {
        const targetAngle = (index * 360) / this.totalItems;
        gsap.to(this.slider, {
            rotationY: targetAngle,
            duration: 1,
            ease: "power2.inOut",
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
            },
            onComplete: () => {
                this.updateCenterImage();
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

    setCenterImageSize(size) {
        const sizes = {
            small: { width: '160px', height: '240px' },
            medium: { width: '200px', height: '300px' },
            large: { width: '240px', height: '360px' }
        };
        
        const newSize = sizes[size];
        if (newSize) {
            gsap.to(this.centerImageContainer, {
                width: newSize.width,
                height: newSize.height,
                duration: 0.5,
                ease: "power2.out"
            });
        }
    }

    setItemSize(size) {
        const sizes = {
            small: { width: '80px', height: '120px' },
            medium: { width: '120px', height: '180px' },
            large: { width: '160px', height: '240px' }
        };
        
        const newSize = sizes[size];
        if (newSize) {
            gsap.to(this.items, {
                width: newSize.width,
                height: newSize.height,
                duration: 0.5,
                ease: "power2.out"
            });
        }
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

        // Play/Pause Button
        const playPauseBtn = document.getElementById('playPauseBtn');
        playPauseBtn.addEventListener('click', () => {
            if (this.gallery.rotationPaused) {
                this.gallery.play();
                playPauseBtn.textContent = '⏸️ Pause';
            } else {
                this.gallery.pause();
                playPauseBtn.textContent = '▶️ Play';
            }
        });

        // Reset Button
        const resetBtn = document.getElementById('resetBtn');
        resetBtn.addEventListener('click', () => {
            this.gallery.reset();
        });

        // Loop Mode
        const loopModeSelect = document.getElementById('loopMode');
        loopModeSelect.addEventListener('change', (e) => {
            this.gallery.setLoopMode(e.target.value);
        });

        // Loop Count
        const loopCountSlider = document.getElementById('loopCount');
        const loopCountValue = document.getElementById('loopCountValue');
        
        loopCountSlider.addEventListener('input', (e) => {
            const count = e.target.value;
            if (count === '0') {
                loopCountValue.textContent = '∞';
            } else {
                loopCountValue.textContent = count;
            }
            this.gallery.setLoopCount(parseInt(count));
        });

        // Loop Delay
        const loopDelaySlider = document.getElementById('loopDelay');
        const loopDelayValue = document.getElementById('loopDelayValue');
        
        loopDelaySlider.addEventListener('input', (e) => {
            const delay = e.target.value;
            loopDelayValue.textContent = `${delay}s`;
            this.gallery.setLoopDelay(parseFloat(delay));
        });

        // Navigation Buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        prevBtn.addEventListener('click', () => {
            this.gallery.previousImage();
        });
        
        nextBtn.addEventListener('click', () => {
            this.gallery.nextImage();
        });

        // Display Settings
        const centerImageSizeSelect = document.getElementById('centerImageSize');
        centerImageSizeSelect.addEventListener('change', (e) => {
            this.gallery.setCenterImageSize(e.target.value);
        });

        const itemSizeSelect = document.getElementById('itemSize');
        itemSizeSelect.addEventListener('change', (e) => {
            this.gallery.setItemSize(e.target.value);
        });

        const showHoverEffectsCheckbox = document.getElementById('showHoverEffects');
        showHoverEffectsCheckbox.addEventListener('change', (e) => {
            this.gallery.setHoverEffects(e.target.checked);
        });

        // Advanced Settings
        const rotationRadiusSlider = document.getElementById('rotationRadius');
        const radiusValue = document.getElementById('radiusValue');
        
        rotationRadiusSlider.addEventListener('input', (e) => {
            const radius = e.target.value;
            radiusValue.textContent = `${radius}px`;
            this.gallery.setRadius(parseInt(radius));
        });

        const tiltAngleSlider = document.getElementById('tiltAngle');
        const tiltValue = document.getElementById('tiltValue');
        
        tiltAngleSlider.addEventListener('input', (e) => {
            const angle = e.target.value;
            tiltValue.textContent = `${angle}°`;
            this.gallery.setTiltAngle(parseInt(angle));
        });

        // Randomize Button
        const randomizeBtn = document.getElementById('randomizeBtn');
        randomizeBtn.addEventListener('click', () => {
            this.gallery.randomize();
        });

        // Fullscreen Button
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        fullscreenBtn.addEventListener('click', () => {
            this.toggleFullscreen();
        });

        // Update current image index
        this.updateCurrentImageIndex();
        setInterval(() => {
            this.updateCurrentImageIndex();
        }, 100);
    }

    updateCurrentImageIndex() {
        const currentImageIndex = document.getElementById('currentImageIndex');
        const totalImages = document.getElementById('totalImages');
        
        if (currentImageIndex && totalImages) {
            currentImageIndex.textContent = this.gallery.getCurrentImageIndex() + 1;
            totalImages.textContent = this.gallery.totalItems;
        }
    }

    toggleFullscreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.log(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
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
});
