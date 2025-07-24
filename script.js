document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.slider');
    const items = document.querySelectorAll('.item');
    const totalItems = items.length;
    const radius = 400; // Distance from center
    let rotationPaused = false;

    // Initial setup for the slider
    gsap.set(slider, {
        transformPerspective: 1000,
        rotationY: 0,
        ease: "none"
    });

    // Position items in 3D space
    function positionItems() {
        items.forEach((item, index) => {
            const angle = (index * 360) / totalItems;
            
            gsap.set(item, {
                rotationY: angle,
                rotationX: -15,
                transformOrigin: "50% 50% -400px", // Match radius for rotation
                z: radius,
                x: 0,
                y: 0,
                opacity: 1
            });
        });
    }

    // Create continuous rotation
    function createRotation() {
        const tl = gsap.timeline({
            repeat: -1,
            paused: rotationPaused
        });

        tl.to(slider, {
            duration: 30,
            rotationY: 360,
            ease: "none"
        });

        return tl;
    }

    // Handle hover effects
    function setupHoverEffects() {
        items.forEach((item) => {
            item.addEventListener('mouseenter', () => {
                if (!rotationPaused) {
                    rotationTimeline.pause();
                    rotationPaused = true;
                }

                gsap.to(item, {
                    duration: 0.3,
                    scale: 1.1,
                    z: radius + 50,
                    boxShadow: "0 15px 30px rgba(0,0,0,0.5)",
                    zIndex: 1,
                    ease: "power2.out"
                });
            });

            item.addEventListener('mouseleave', () => {
                rotationTimeline.play();
                rotationPaused = false;

                gsap.to(item, {
                    duration: 0.3,
                    scale: 1,
                    z: radius,
                    boxShadow: "0 5px 20px rgba(0,0,0,0.3)",
                    zIndex: 0,
                    ease: "power2.in"
                });
            });

            // Click handler
            item.addEventListener('click', () => {
                const title = item.getAttribute('data-title');
                const description = item.getAttribute('data-description');
                const url = item.getAttribute('data-url');
                console.log({ title, description, url });
            });
        });
    }

    // Initialize everything
    positionItems();
    const rotationTimeline = createRotation();
    setupHoverEffects();
});
