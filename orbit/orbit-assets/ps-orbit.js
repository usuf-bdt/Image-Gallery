class RotatingGallery {

    constructor(container) {

        this.container = container;
        this.widgetId = container.id;

        this.slider = container.querySelector('.ps-orbit-slider');
        this.items = container.querySelectorAll('.ps-orbit-item');

        const rotationSpeedFromData = container.getAttribute('data-rotation-speed');
        this.rotationSpeed = rotationSpeedFromData ? parseInt(rotationSpeedFromData) : 30;

        const rotationDirectionFromData = container.getAttribute('data-rotation-direction');
        this.rotationDirection = rotationDirectionFromData || 'clockwise';

        const rotationControlFromData = container.getAttribute('data-rotation-control');
        this.initialRotationMode = rotationControlFromData || 'loop';

        const normalScaleFromData = container.getAttribute('data-normal-scale');
        const hoverScaleFromData = container.getAttribute('data-hover-scale');
        this.normalScale = normalScaleFromData ? parseFloat(normalScaleFromData) : 1;
        this.hoverScale = hoverScaleFromData ? parseFloat(hoverScaleFromData) : 1;

        this.totalItems = this.items.length;
        this.radius = this.getResponsiveRadius();
        this.rotationPaused = false;
        this.currentRotation = 0;
        this.tiltAngle = 15;
        this.isManualMode = false;

        this.TRANSFORM_PERSPECTIVE = 1000;
        this.EASE_NONE = "none";

        this.init();
    }

    getResponsiveRadius() {
        const width = window.innerWidth;
        if (width <= 480) {
            return 180;
        } else if (width <= 768) {
            return 220;
        } else if (width <= 1024) {
            return 300;
        } else {
            return 420;
        }
    }

    init() {
        this.setupInitialState();
        this.positionItems();
        this.rotationTimeline = this.createRotation();
        this.setupEventListeners();
        this.setupResizeHandler();

        this.container.classList.add('initialized');
    }

    setupInitialState() {
        if (typeof gsap === 'undefined') return;

        gsap.set(this.slider, {
            transformPerspective: this.TRANSFORM_PERSPECTIVE,
            rotationY: 0,
            ease: this.EASE_NONE
        });
    }

    positionItems() {
        if (typeof gsap === 'undefined') return;

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
                opacity: 1,
                scale: this.normalScale
            });
        });

        gsap.set(this.slider, {
            transformPerspective: this.TRANSFORM_PERSPECTIVE,
            rotationY: 0,
            ease: this.EASE_NONE
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

    createRotation() {
        if (typeof gsap === 'undefined') return null;

        const direction = this.rotationDirection === 'clockwise' ? 1 : -1;

        const timeline = gsap.timeline({
            repeat: -1,
            paused: this.rotationPaused,
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
            }
        });

        timeline.to(this.slider, {
            duration: this.rotationSpeed,
            rotationY: `+=${360 * direction}`,
            ease: this.EASE_NONE
        });

        return timeline;
    }

    handleItemHover(item, isEnter) {
        if (typeof gsap === 'undefined') return;

        if (isEnter) {
            if (!this.rotationPaused && this.rotationTimeline) {
                this.rotationTimeline.pause();
                this.rotationPaused = true;
            }

            gsap.to(item, {
                duration: 0.3,
                scale: this.hoverScale,
                ease: "power2.inOut"
            });
        } else {
            if (!this.isManualMode && this.rotationTimeline) {
                this.rotationTimeline.play();
                this.rotationPaused = false;
            }

            gsap.to(item, {
                duration: 0.3,
                scale: this.normalScale,
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
    }

    handleItemClick(item) {
        showModal(item, this.widgetId);
    }

    pause() {
        if (this.rotationTimeline) {
            this.rotationTimeline.pause();
            this.rotationPaused = true;
        }
    }

    play() {
        if (this.rotationTimeline) {
            this.rotationTimeline.play();
            this.rotationPaused = false;
        }
    }

    setRotationSpeed(duration) {
        this.rotationSpeed = duration;
        if (this.rotationTimeline && typeof gsap !== 'undefined') {
            this.rotationTimeline.duration(duration);
        }
        console.log(`Rotation speed set to ${duration} seconds`);
    }

    setRotationDirection(direction) {
        this.rotationDirection = direction;
        this.recreateRotation();
        console.log(`Rotation direction set to ${direction}`);
    }

    setScaleValues(normalScale, hoverScale) {
        this.normalScale = normalScale ? parseFloat(normalScale) : 1;
        this.hoverScale = hoverScale ? parseFloat(hoverScale) : 1;

        if (typeof gsap !== 'undefined') {
            this.items.forEach(item => {
                gsap.set(item, { scale: this.normalScale });
            });
        }
    }

    setRotationMode(mode) {
        if (mode === 'loop') {
            this.isManualMode = false;
            this.showNavigationButtonsOnly();
            this.rotationPaused = false;
            this.recreateRotation();
        } else {
            this.isManualMode = true;
            if (this.rotationTimeline) {
                this.rotationTimeline.pause();
            }
            this.rotationPaused = true;
            this.showNavigationControls();
        }
    }

    showNavigationControls() {
        const navigationButtons = document.getElementById(`navigationButtons-${this.widgetId}`);
        const paginationContainer = document.getElementById(`paginationContainer-${this.widgetId}`);

        if (navigationButtons) {
            navigationButtons.style.display = 'flex';
        }
        if (paginationContainer) {
            paginationContainer.style.display = 'flex';
        }

        this.createPaginationDots();
    }

    showNavigationButtonsOnly() {
        const navigationButtons = document.getElementById(`navigationButtons-${this.widgetId}`);
        const paginationContainer = document.getElementById(`paginationContainer-${this.widgetId}`);

        if (navigationButtons) {
            navigationButtons.style.display = 'flex';
        }
        if (paginationContainer) {
            paginationContainer.style.display = 'none';
        }
    }

    hideNavigationControls() {
        const navigationButtons = document.getElementById(`navigationButtons-${this.widgetId}`);
        const paginationContainer = document.getElementById(`paginationContainer-${this.widgetId}`);

        if (navigationButtons) {
            navigationButtons.style.display = 'none';
        }
        if (paginationContainer) {
            paginationContainer.style.display = 'none';
        }
    }

    createPaginationDots() {
        const paginationDots = document.getElementById(`paginationDots-${this.widgetId}`);
        if (!paginationDots) return;

        paginationDots.innerHTML = '';

        for (let i = 0; i < this.totalItems; i++) {
            const dot = document.createElement('div');
            dot.className = 'ps-orbit-pagination-dot';
            dot.dataset.index = i;
            dot.addEventListener('click', () => {
                if (this.isManualMode) {
                    this.goToImage(i);
                }
            });
            paginationDots.appendChild(dot);
        }

        this.updatePaginationDots();
    }

    updatePaginationDots() {
        const paginationDots = document.getElementById(`paginationDots-${this.widgetId}`);
        if (!paginationDots) return;

        const dots = paginationDots.querySelectorAll('.ps-orbit-pagination-dot');
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
        if (typeof gsap === 'undefined') return;

        const wasPlaying = !this.rotationPaused;
        const currentRotation = this.currentRotation;

        if (this.rotationTimeline) {
            this.rotationTimeline.kill();
        }
        this.rotationTimeline = this.createRotation();

        gsap.set(this.slider, { rotationY: currentRotation });

        if (wasPlaying && this.rotationTimeline) {
            this.rotationTimeline.play();
            this.rotationPaused = false;
        } else if (this.rotationTimeline) {
            this.rotationTimeline.pause();
            this.rotationPaused = true;
        }
    }

    goToImage(index) {
        if (typeof gsap === 'undefined') return;

        const currentRotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;

        const currentIndex = Math.round(currentRotation / itemAngle) % this.totalItems;

        let targetIndex = index;
        let difference = targetIndex - currentIndex;

        if (difference > this.totalItems / 2) {
            difference -= this.totalItems;
        } else if (difference < -this.totalItems / 2) {
            difference += this.totalItems;
        }

        const targetRotation = this.currentRotation + difference * itemAngle;

        gsap.killTweensOf(this.slider);

        gsap.to(this.slider, {
            rotationY: targetRotation,
            duration: 1,
            ease: "power2.inOut",
            onUpdate: () => {
                this.currentRotation = gsap.getProperty(this.slider, "rotationY");
            },
            onComplete: () => {
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

    getCurrentImageIndex() {
        const rotation = (this.currentRotation % 360 + 360) % 360;
        const itemAngle = 360 / this.totalItems;
        return Math.round(rotation / itemAngle) % this.totalItems;
    }
}

class ControlManager {
    constructor(gallery) {
        this.gallery = gallery;
        this.setupControls();
    }

    setupControls() {
        const prevBtn = document.getElementById(`prevBtn-${this.gallery.widgetId}`);
        const nextBtn = document.getElementById(`nextBtn-${this.gallery.widgetId}`);

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (!this.gallery.isManualMode) {
                    this.gallery.previousImage();
                } else {
                    this.gallery.previousImage();
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                if (!this.gallery.isManualMode) {
                    this.gallery.nextImage();
                } else {
                    this.gallery.nextImage();
                }
            });
        }

        this.updateCurrentImageIndex();
        setInterval(() => {
            this.updateCurrentImageIndex();
        }, 100);
    }

    updateCurrentImageIndex() {
        this.gallery.updatePaginationDots();
    }
}

function showModal(item, widgetId) {
    const modal = document.getElementById(`modal-${widgetId}`);
    if (!modal) return console.warn('Modal not found for widget:', widgetId);

    // Cache modal elements
    const modalImg = modal.querySelector(`#modalImg-${widgetId}`);
    const modalTitle = modal.querySelector(`#modalTitle-${widgetId}`);
    const modalDescription = modal.querySelector(`#modalDescription-${widgetId}`);
    const modalBtn = modal.querySelector(`#modalBtn-${widgetId}`);
    const modalContent = modal.querySelector('.ps-orbit-modal-content');
    const modalLeft = modal.querySelector('.ps-orbit-modal-left');
    const modalRight = modal.querySelector('.ps-orbit-modal-right');
    const closeBtn = modal.querySelector('.ps-orbit-close-btn');

    if (!modalImg || !modalTitle || !modalDescription || !modalBtn || !modalContent) {
        return console.warn('Some modal elements are missing for widget:', widgetId);
    }

    // Set modal content
    const img = item.querySelector('img');
    modalImg.src = img?.src || '';
    modalImg.alt = img?.alt || '';
    modalTitle.textContent = item.getAttribute('data-title') || '';
    modalDescription.textContent = item.getAttribute('data-description') || '';
    modalBtn.onclick = () => window.open(item.getAttribute('data-url') || '#', '_blank');

    // Show modal
    modal.style.display = 'flex';
    modal.style.opacity = 1;

    // Animate with GSAP
    if (typeof gsap !== 'undefined') {
        gsap.set([modalContent, modalLeft, modalRight, closeBtn], { clearProps: "all" });
        gsap.set(modalContent, { scale: 0.8, opacity: 0 });
        gsap.set(modalLeft, { x: -50, opacity: 0 });
        gsap.set(modalRight, { x: 50, opacity: 0 });
        gsap.set(closeBtn, { scale: 0, opacity: 0 });

        const tl = gsap.timeline();
        tl.to(modalContent, {
            scale: 1,
            opacity: 1,
            duration: 0.3,
            ease: "back.out(1.2)"
        })
            .to([modalLeft, modalRight, closeBtn], {
                x: 0,
                scale: 1,
                opacity: 1,
                duration: 0.25,
                ease: "power2.out"
            }, "-=0.15");
    }

    // Pause gallery if exists
    const gallery = window.galleries?.[widgetId];
    if (gallery) gallery.pause();
}

function hideModal(widgetId) {
    const modal = document.getElementById(`modal-${widgetId}`);
    if (!modal) return;

    if (typeof gsap !== 'undefined') {
        const modalContent = modal.querySelector('.ps-orbit-modal-content');
        const closeBtn = modal.querySelector('.ps-orbit-close-btn');

        const tl = gsap.timeline();

        tl.to(closeBtn, {
            scale: 0,
            duration: 0.2,
            ease: "back.in(1.7)"
        })
            .to(modalContent, {
                scale: 0.5,
                opacity: 0,
                duration: 0.3,
                ease: "power2.in"
            }, "-=0.1")
            .call(() => {
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.style.display = 'none';

                    const modalLeft = modal.querySelector('.ps-orbit-modal-left');
                    const modalRight = modal.querySelector('.ps-orbit-modal-right');

                    if (modalContent) {
                        gsap.set(modalContent, { scale: 0.8, opacity: 0 });
                    }
                    if (modalLeft) {
                        gsap.set(modalLeft, { x: -50, opacity: 0 });
                    }
                    if (modalRight) {
                        gsap.set(modalRight, { x: 50, opacity: 0 });
                    }
                    if (closeBtn) {
                        gsap.set(closeBtn, { scale: 0, opacity: 0 });
                    }
                }, 300);
            });
    } else {
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    const gallery = window.galleries[widgetId];
    if (gallery) {
        gallery.play();
    }
}

(function ($, elementor) {

    'use strict';

    var widgetOrbit = function ($scope, $) {

        var $orbitContainer = $scope.find('.ps-orbit-container');
        if (!$orbitContainer.length) {
            return;
        }

        if (!window.galleries) {
            window.galleries = {};
        }
        $orbitContainer.each(function () {
            const container = this;
            const widgetId = container.id;

            const gallery = new RotatingGallery(container);

            window.galleries[widgetId] = gallery;

            const controlManager = new ControlManager(gallery);

            gallery.setRotationMode(gallery.initialRotationMode);

            setupModalEvents(widgetId);
        });

    };

    function setupModalEvents(widgetId) {
        const modal = document.getElementById(`modal-${widgetId}`);
        const closeBtn = document.getElementById(`closeBtn-${widgetId}`);

        if (closeBtn) {
            closeBtn.addEventListener('click', () => hideModal(widgetId));
        }

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    hideModal(widgetId);
                }
            });
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.ps-orbit-modal[style*="display: flex"]');
            openModals.forEach(modal => {
                const modalId = modal.id;
                const widgetId = modalId.replace('modal-', '');
                hideModal(widgetId);
            });
        }
    });

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/prime-slider-orbit.default', widgetOrbit);
    });

    jQuery(document).ready(function () {
        if (typeof elementorFrontend === 'undefined') {
            const orbitContainers = document.querySelectorAll('.ps-orbit-container');

            if (!window.galleries) {
                window.galleries = {};
            }

            orbitContainers.forEach(container => {
                const widgetId = container.id;

                const gallery = new RotatingGallery(container);

                window.galleries[widgetId] = gallery;

                const controlManager = new ControlManager(gallery);

                gallery.setRotationMode(gallery.initialRotationMode);

                setupModalEvents(widgetId);
            });
        }
    });

}(jQuery, window.elementorFrontend));