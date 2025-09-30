/**
 * Darvag Modern Navbar JavaScript
 * Controls navbar functionality and animations
 */
document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const navbarContainer = document.querySelector(".dnav-container");
    const menuButton = document.getElementById("dnav-toggle-button");
    const mobileMenu = document.querySelector(".dnav-mobile-menu");
    const desktopLinks = document.querySelectorAll(".dnav-links a");
    const mobileLinks = document.querySelectorAll(".dnav-mobile-links a");

    // Toggle Mobile Menu
    function toggleMenu() {
        menuButton.classList.toggle("active");
        mobileMenu.classList.toggle("active");
    }

    // Setup menu button click handler
    if (menuButton) {
        menuButton.addEventListener("click", toggleMenu);
    }

    // Active Link Based on Current URL
    function setActiveLinks() {
        const currentLocation = window.location.href;

        function setActive(links) {
            links.forEach((link) => {
                if (link.href === currentLocation) {
                    link.classList.add("active");
                } else if (
                    link.classList.contains("active") &&
                    link.href !== currentLocation
                ) {
                    link.classList.remove("active");
                }
            });
        }

        setActive(desktopLinks);
        setActive(mobileLinks);
    }

    // Run once on page load
    setActiveLinks();

    // Scroll Effect
    function handleScroll() {
        if (window.scrollY > 50) {
            navbarContainer.classList.add("scrolled");
        } else {
            navbarContainer.classList.remove("scrolled");
        }
    }

    // Add scroll event listener
    window.addEventListener("scroll", handleScroll);

    // Close mobile menu when clicking outside
    document.addEventListener("click", function (event) {
        if (
            mobileMenu &&
            mobileMenu.classList.contains("active") &&
            !mobileMenu.contains(event.target) &&
            !menuButton.contains(event.target)
        ) {
            mobileMenu.classList.remove("active");
            menuButton.classList.remove("active");
        }
    });

    // Optional: Close mobile menu when clicking on a mobile link
    mobileLinks.forEach((link) => {
        link.addEventListener("click", function () {
            mobileMenu.classList.remove("active");
            menuButton.classList.remove("active");
        });
    });

    // Optional: Add smooth scrolling for hash links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (event) {
            const targetId = this.getAttribute("href");
            if (targetId !== "#") {
                event.preventDefault();

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: "smooth",
                    });

                    // Optional: Close mobile menu after clicking
                    if (mobileMenu && mobileMenu.classList.contains("active")) {
                        mobileMenu.classList.remove("active");
                        menuButton.classList.remove("active");
                    }
                }
            }
        });
    });
});

/**
 * Darvag Projects Header JavaScript
 * Adds interactive effects and parallax scrolling
 */
document.addEventListener("DOMContentLoaded", function () {
    // Parallax effect on scroll
    window.addEventListener("scroll", function () {
        const scrollPosition = window.scrollY;
        const header = document.querySelector(".darvag-header");

        if (header) {
            // Get particles
            const particles = document.querySelectorAll(".particle");

            // Create parallax effect on particles
            particles.forEach((particle, index) => {
                const speed = 0.05 + index * 0.01;
                const yPos = scrollPosition * speed;
                particle.style.transform = `translate3d(0, ${yPos}px, 0)`;
            });

            // Fade out content on scroll
            const headerContent = document.querySelector(".darvag-header-content");
            if (headerContent && scrollPosition > 50) {
                const opacity = 1 - scrollPosition / 500;
                headerContent.style.opacity = opacity > 0 ? opacity : 0;
            }
        }
    });

    // Optional: Add interactive particle hover effect
    const header = document.querySelector(".darvag-header");
    if (header) {
        header.addEventListener("mousemove", function (e) {
            const particles = document.querySelectorAll(".particle");
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            particles.forEach((particle, index) => {
                // Calculate movement based on mouse position and particle index
                const offsetX = (mouseX - 0.5) * (index + 1) * 10;
                const offsetY = (mouseY - 0.5) * (index + 1) * 10;

                // Apply subtle movement to particles
                particle.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
            });
        });

        // Reset particle positions when mouse leaves
        header.addEventListener("mouseleave", function () {
            const particles = document.querySelectorAll(".particle");

            particles.forEach((particle) => {
                // Remove inline transform to restore original animation
                particle.style.transform = "";
            });
        });
    }

    // Scroll indicator functionality
    const scrollIndicator = document.querySelector(".darvag-scroll-indicator");
    if (scrollIndicator) {
        scrollIndicator.addEventListener("click", function () {
            // Calculate scroll target (height of header + a little extra)
            const header = document.querySelector(".darvag-header");
            const scrollTarget = header.offsetHeight;

            // Smooth scroll to content below header
            window.scrollTo({
                top: scrollTarget,
                behavior: "smooth",
            });
        });

        // Add cursor pointer to indicate it's clickable
        scrollIndicator.style.cursor = "pointer";
    }

    // Add text animation effect
    function animateHighlightedText() {
        const highlight = document.querySelector(".darvag-highlight");
        if (highlight) {
            // Add shimmer effect
            const shimmer = document.createElement("div");
            shimmer.classList.add("darvag-highlight-shimmer");
            shimmer.style.position = "absolute";
            shimmer.style.top = "0";
            shimmer.style.left = "-100%";
            shimmer.style.width = "100%";
            shimmer.style.height = "100%";
            shimmer.style.background =
                "linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent)";
            shimmer.style.animation = "shimmer 2s infinite";

            // Make highlight position relative for shimmer positioning
            highlight.style.position = "relative";
            highlight.style.overflow = "hidden";

            // Add shimmer to highlight
            highlight.appendChild(shimmer);

            // Add shimmer animation
            const style = document.createElement("style");
            style.textContent = `
          @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
          }
        `;
            document.head.appendChild(style);
        }
    }

    // Initialize animations
    setTimeout(animateHighlightedText, 1000);
});

// اسکریپت برای فعال‌سازی تعاملات
document.addEventListener("DOMContentLoaded", function () {
    // انیمیشن تاخیری برای آیتم‌های خدمات
    const serviceItems = document.querySelectorAll(".service-item");

    serviceItems.forEach((item, index) => {
        // افزودن تاخیر انیمیشن
        item.style.animationDelay = 0.1 * index + "s";

        // افزودن عملکرد کلیک در صورت نیاز
        item.addEventListener("click", function () {
            // هدایت به صفحه مربوطه یا نمایش اطلاعات بیشتر
            console.log("آیتم شماره " + (index + 1) + " کلیک شد");
        });
    });

    // عملکرد نقاط ناوبری
    const navDots = document.querySelectorAll(".slide-dots button");

    navDots.forEach((dot, index) => {
        dot.addEventListener("click", function () {
            // ریست کردن همه نقاط
            navDots.forEach((d) => {
                d.classList.remove("active");
                d.style.width = "10px";
                d.style.opacity = "0.4";
            });

            // فعال کردن نقطه کلیک شده
            this.classList.add("active");
            this.style.width = "20px";
            this.style.opacity = "1";

            // در اینجا می‌توانید منطق اسلاید را پیاده‌سازی کنید
            // مثلاً اسکرول به مجموعه خدمات بعدی یا قبلی
            scrollToSlide(index);
        });
    });

    // تابع اسکرول به اسلاید مورد نظر
    function scrollToSlide(index) {
        const servicesWrapper = document.querySelector(".services-wrapper");

        // اگر در حالت موبایل باشیم و نیاز به اسکرول افقی داشته باشیم
        if (window.innerWidth <= 992) {
            const serviceItems = document.querySelectorAll(".service-item");
            const itemWidth = serviceItems[0].offsetWidth + 20; // عرض آیتم + فاصله

            // محاسبه موقعیت اسکرول براساس تعداد آیتم‌ها در هر اسلاید
            // فرض: 3 آیتم در هر اسلاید در حالت موبایل
            const scrollPosition = index * 3 * itemWidth;

            servicesWrapper.scrollTo({
                left: scrollPosition,
                behavior: "smooth",
            });
        }
    }

    // اضافه کردن افکت هاور به دکمه اکشن
    const actionButton = document.querySelector(".action-button");

    if (actionButton) {
        actionButton.addEventListener("mouseenter", function () {
            this.querySelector(".button-hover-effect").style.opacity = "1";
        });

        actionButton.addEventListener("mouseleave", function () {
            this.querySelector(".button-hover-effect").style.opacity = "0";
        });
    }
});

/**
 * Projects Section JavaScript
 * Handles search, filtering, and animations
 */
document.addEventListener("DOMContentLoaded", function () {
    // Elements
    const searchInput = document.querySelector(".prj-search-input");
    const filterSelect = document.querySelector(".prj-filter-select");
    const projectCards = document.querySelectorAll(".prj-card");
    const featuredProject = document.querySelector(".prj-featured-card");

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.trim().toLowerCase();

            // If search is empty, show all projects
            if (searchTerm === "") {
                projectCards.forEach((card) => {
                    card.style.display = "block";
                });

                if (featuredProject) {
                    featuredProject.style.display = "flex";
                }

                return;
            }

            // Hide featured project during search
            if (featuredProject) {
                const featuredTitle = featuredProject.querySelector(
                    ".prj-featured-title"
                );
                const featuredDescription = featuredProject.querySelector(
                    ".prj-featured-description"
                );

                const featuredTitleText = featuredTitle
                    ? featuredTitle.textContent.toLowerCase()
                    : "";
                const featuredDescText = featuredDescription
                    ? featuredDescription.textContent.toLowerCase()
                    : "";

                if (
                    featuredTitleText.includes(searchTerm) ||
                    featuredDescText.includes(searchTerm)
                ) {
                    featuredProject.style.display = "flex";
                } else {
                    featuredProject.style.display = "none";
                }
            }

            // Filter project cards
            projectCards.forEach((card) => {
                const title = card.querySelector(".prj-card-title");
                const description = card.querySelector(".prj-card-description");

                const titleText = title ? title.textContent.toLowerCase() : "";
                const descText = description
                    ? description.textContent.toLowerCase()
                    : "";

                if (titleText.includes(searchTerm) || descText.includes(searchTerm)) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }

    // Category filter functionality
    if (filterSelect) {
        filterSelect.addEventListener("change", function () {
            const category = this.value;

            // If "all projects" is selected, show everything
            if (category === "همه پروژه‌ها") {
                projectCards.forEach((card) => {
                    card.style.display = "block";
                });

                if (featuredProject) {
                    featuredProject.style.display = "flex";
                }

                return;
            }

            // Check if featured project matches the category
            if (featuredProject) {
                const featuredTag = featuredProject.querySelector(".prj-tag-blue");
                const featuredCategory = featuredTag ? featuredTag.textContent : "";

                if (featuredCategory === category) {
                    featuredProject.style.display = "flex";
                } else {
                    featuredProject.style.display = "none";
                }
            }

            // Filter project cards by category
            projectCards.forEach((card) => {
                const badge = card.querySelector(".prj-tag-dark");
                const cardCategory = badge ? badge.textContent : "";

                if (cardCategory === category) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    }

    // Optional: Image hover effect enhancement
    const cardImages = document.querySelectorAll(".prj-card-image");
    cardImages.forEach((img) => {
        img.addEventListener("mouseenter", function () {
            this.style.transform = "scale(1.05)";
        });

        img.addEventListener("mouseleave", function () {
            this.style.transform = "";
        });
    });

    // Optional: Card animation on scroll
    const animateOnScroll = () => {
        const cards = document.querySelectorAll(".prj-card");

        cards.forEach((card, index) => {
            const cardPosition = card.getBoundingClientRect().top;
            const screenPosition = window.innerHeight;

            // Add animation when card comes into view
            if (cardPosition < screenPosition - 100) {
                setTimeout(() => {
                    card.style.opacity = "1";
                    card.style.transform = "translateY(0)";
                }, index * 100); // Staggered animation
            }
        });
    };

    // Add initial styles for animation (uncomment to enable)
    /*
      const cards = document.querySelectorAll('.prj-card');
      cards.forEach(card => {
          card.style.opacity = '0';
          card.style.transform = 'translateY(20px)';
          card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      });

      // Run on load and scroll
      window.addEventListener('scroll', animateOnScroll);
      window.addEventListener('load', animateOnScroll);
      */

    // Optional: Add lazy loading for images to improve performance
    if ("loading" in HTMLImageElement.prototype) {
        const images = document.querySelectorAll(
            ".prj-card-image, .prj-featured-image"
        );
        images.forEach((img) => {
            img.loading = "lazy";
        });
    }

    // Optional: Add button click tracking
    const trackButtons = document.querySelectorAll(".prj-featured-button");
    trackButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
            // You can add analytics tracking here
            console.log("Project button clicked:", this.getAttribute("href"));
        });
    });
});

/**
 * Experience Section JavaScript
 * Handles counter animations and interactive effects
 */
document.addEventListener("DOMContentLoaded", function () {
    // Counter animation function with smoother counting and plus sign
    function animateCounters() {
        const counters = document.querySelectorAll(".exp-counter");
        const speed = 200; // Slower for more visible counting effect

        counters.forEach((counter) => {
            const target = +counter.getAttribute("data-target");
            const increment = Math.ceil(target / speed);

            function updateCount() {
                const count = +counter.innerText;
                if (count < target) {
                    // Increment by larger values for smoother counting
                    counter.innerText = Math.min(count + increment, target);
                    // Set a slightly random timeout for more natural counting
                    setTimeout(updateCount, Math.random() * 50 + 30);
                } else {
                    counter.innerText = target;
                    // Add the plus sign after counting is complete
                    if (!counter.innerText.includes("+")) {
                        counter.innerHTML =
                            counter.innerText + '<span class="exp-counter-plus">+</span>';
                    }
                }
            }

            // Start counting with a delay to allow animations to complete
            setTimeout(updateCount, 1000);
        });
    }

    // Enhance hover effects for stat boxes
    function setupStatBoxInteractions() {
        const statBoxes = document.querySelectorAll(".exp-stat-box");

        statBoxes.forEach((box) => {
            // Add hover animation effects
            box.addEventListener("mouseenter", function () {
                const icon = this.querySelector(".exp-icon");

                // Store original animation
                const originalAnimation = icon.style.animation;

                // Apply hover animation
                icon.style.animation = "exp-icon-scale 0.5s infinite alternate";

                // Store original and hover animation for later
                icon.dataset.originalAnimation = originalAnimation;
            });

            // Restore original animation on mouse leave
            box.addEventListener("mouseleave", function () {
                const icon = this.querySelector(".exp-icon");

                // Restore original animation
                if (icon.dataset.originalAnimation) {
                    icon.style.animation = icon.dataset.originalAnimation;
                } else {
                    // If no original animation, remove the animation
                    icon.style.animation = "";
                }
            });
        });
    }

    // Function to ensure animations restart when section comes into view
    function setupScrollAnimations() {
        // Check if Intersection Observer is supported
        if ("IntersectionObserver" in window) {
            const experienceSection = document.querySelector(".exp-container");

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        // If section is visible
                        if (entry.isIntersecting) {
                            // Restart counter animations
                            animateCounters();

                            // Stop observing after triggering once
                            observer.unobserve(entry.target);
                        }
                    });
                },
                {
                    threshold: 0.2, // Trigger when 20% of the element is visible
                }
            );

            // Start observing the section
            if (experienceSection) {
                observer.observe(experienceSection);
            }
        } else {
            // Fallback for browsers without Intersection Observer
            animateCounters();
        }
    }

    // Setup interactive button effects
    function setupButtonEffects() {
        const buttons = document.querySelectorAll(".exp-button");

        buttons.forEach((button) => {
            // Add ripple effect on click
            button.addEventListener("click", function (e) {
                // Create ripple element
                const ripple = document.createElement("span");
                ripple.classList.add("exp-button-ripple");
                this.appendChild(ripple);

                // Get position
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                // Position and animate ripple
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;

                // Remove ripple after animation
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple effect
        if (!document.getElementById("exp-ripple-style")) {
            const style = document.createElement("style");
            style.id = "exp-ripple-style";
            style.textContent = `
                .exp-button {
                    position: relative;
                    overflow: hidden;
                }
                .exp-button-ripple {
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.3);
                    transform: scale(0);
                    animation: exp-ripple 0.6s linear;
                    pointer-events: none;
                }
                @keyframes exp-ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Initialize all interactive features
    function init() {
        animateCounters();
        setupStatBoxInteractions();
        setupScrollAnimations();
        setupButtonEffects();
    }

    // Start the initialization
    init();
});

/**
 * Partners Section JavaScript
 * Handles interactive functionality for partners carousel
 */
document.addEventListener("DOMContentLoaded", function () {
    // Add hover effects and animate partner items
    function initializePartnerItems() {
        const partnerItems = document.querySelectorAll(".prt-partner-item");

        partnerItems.forEach((item, index) => {
            // Add staggered animation delay
            item.style.animationDelay = 0.1 * index + "s";

            // Add click functionality
            item.addEventListener("click", function () {
                // Example: Open partner details or modal
                console.log(
                    "Partner clicked:",
                    item.querySelector(".prt-partner-name")?.textContent
                );
            });
        });
    }

    // Initialize navigation dots functionality
    function initializeNavigation() {
        const navDots = document.querySelectorAll(".prt-nav-dot");

        navDots.forEach((dot, index) => {
            dot.addEventListener("click", function () {
                // Reset all dots
                navDots.forEach((d) => {
                    d.classList.remove("prt-nav-active");
                });

                // Activate clicked dot
                this.classList.add("prt-nav-active");

                // Handle carousel navigation (example implementation)
                handleCarouselNavigation(index);
            });
        });
    }

    // Example carousel navigation function
    function handleCarouselNavigation(slideIndex) {
        console.log("Navigating to slide:", slideIndex);

        // You would implement carousel sliding logic here
        // For demonstration purposes, we'll just log the action

        // Example animation for partners grid
        const partnersGrid = document.querySelector(".prt-partners-grid");
        if (partnersGrid) {
            // Add a subtle transition effect
            partnersGrid.style.opacity = "0.5";
            partnersGrid.style.transform = "translateX(10px)";

            setTimeout(() => {
                partnersGrid.style.opacity = "1";
                partnersGrid.style.transform = "translateX(0)";
            }, 300);
        }
    }

    // Function to load partner data dynamically (example implementation)
    function loadPartnerData() {
        // This would typically be an API call
        // For demonstration, we'll simulate loading with setTimeout

        setTimeout(() => {
            // Replace placeholder elements with actual content
            const placeholders = document.querySelectorAll(
                ".prt-partner-placeholder"
            );

            // Example placeholder replacement with actual partner
            if (placeholders.length > 0) {
                // Example data for a new partner
                const newPartnerHTML = `
                    <div class="prt-partner-item">
                        <div class="prt-partner-logo">
                            <img src="https://picsum.photos/200" alt="شرکت نمونه">
                        </div>
                        <div class="prt-partner-info">
                            <h3 class="prt-partner-name">شرکت نمونه</h3>
                            <p class="prt-partner-description">توضیحات مربوط به شرکت همکار</p>
                        </div>
                        <div class="prt-partner-hover-effect"></div>
                    </div>
                `;

                // Replace first placeholder with new partner
                if (placeholders[0].parentNode) {
                    // Create a temporary container
                    const temp = document.createElement("div");
                    temp.innerHTML = newPartnerHTML;

                    // Replace placeholder with new partner
                    placeholders[0].parentNode.replaceChild(
                        temp.firstElementChild,
                        placeholders[0]
                    );
                }

                // Re-initialize partner items to add event listeners
                initializePartnerItems();
            }
        }, 2000); // Simulate 2 second loading
    }

    // CTA button animation
    function initializeCTAButton() {
        const ctaButton = document.querySelector(".prt-cta-button");

        if (ctaButton) {
            ctaButton.addEventListener("mouseenter", function () {
                // Add a subtle animation to the icon
                const icon = this.querySelector(".prt-cta-icon");
                if (icon) {
                    icon.style.transform = "translateX(-5px)";
                    icon.style.transition = "transform 0.3s ease";
                }
            });

            ctaButton.addEventListener("mouseleave", function () {
                // Reset the icon animation
                const icon = this.querySelector(".prt-cta-icon");
                if (icon) {
                    icon.style.transform = "";
                }
            });

            // Add click handler for CTA button
            ctaButton.addEventListener("click", function (e) {
                // Prevent default if you want to handle with JavaScript
                // e.preventDefault();

                // Example: Show a contact form or modal
                console.log("Partnership request button clicked");
            });
        }
    }

    // Function to add animation to elements when they come into view
    function initializeScrollAnimations() {
        // Check if Intersection Observer is supported
        if ("IntersectionObserver" in window) {
            const animatedElements = document.querySelectorAll(
                ".prt-partner-item, .prt-become-partner"
            );

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = "1";
                            entry.target.style.transform = "translateY(0)";
                            // Stop observing after animation is triggered
                            observer.unobserve(entry.target);
                        }
                    });
                },
                {
                    threshold: 0.1, // Trigger when 10% of the element is visible
                    rootMargin: "0px 0px -50px 0px", // Adjust based on when you want the animation to trigger
                }
            );

            // Start observing each element
            animatedElements.forEach((element) => {
                // Set initial styles if needed
                element.style.opacity = "0";
                element.style.transform = "translateY(20px)";
                element.style.transition = "opacity 0.5s ease, transform 0.5s ease";

                observer.observe(element);
            });
        }
    }

    // Initialize all functionality
    function init() {
        initializePartnerItems();
        initializeNavigation();
        initializeCTAButton();

        // Uncomment to enable simulated loading of partner data
        // loadPartnerData();

        // Uncomment to enable scroll animations
        // initializeScrollAnimations();
    }

    // Run initialization
    init();
});

/**
 * Partners Slider Functionality
 */
document.addEventListener("DOMContentLoaded", function() {
    const track = document.querySelector('.prt-partners-track');
    const items = document.querySelectorAll('.prt-partner-item');
    const dots = document.querySelectorAll('.prt-nav-dot');

    if (!track || items.length === 0) return;

    // Configuration
    const itemWidth = items[0].offsetWidth + 20; // Include gap
    const itemsPerSlide = 4; // Number of items to slide
    const totalSlides = Math.ceil(items.length / itemsPerSlide);

    let currentSlide = 0;

    // Initialize
    function initSlider() {
        // Set initial position
        updateSliderPosition();

        // Initialize dots
        dots.forEach((dot, index) => {
            if (index < totalSlides) {
                dot.style.display = 'block';
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    resetAutoSlideTimer(); // Reset timer when manually changing slide
                });
            } else {
                dot.style.display = 'none';
            }
        });

        // Update dots initial state
        updateDots();

        // Responsive adjustments based on window width
        updateResponsiveView();
        window.addEventListener('resize', updateResponsiveView);
    }

    // Go to specific slide
    function goToSlide(slideIndex) {
        currentSlide = slideIndex;
        updateSliderPosition();
        updateDots();
    }

    // Slide to next
    function slideNext() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
        } else {
            // Loop back to the start
            currentSlide = 0;
        }
        updateSliderPosition();
        updateDots();
    }

    // Update slider position
    function updateSliderPosition() {
        const position = -currentSlide * (itemsPerSlide * itemWidth);
        track.style.transform = `translateX(${position}px)`;
    }

    // Update dots active state
    function updateDots() {
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.classList.add('prt-nav-active');
            } else {
                dot.classList.remove('prt-nav-active');
            }
        });
    }

    // Update responsive view based on screen size
    function updateResponsiveView() {
        const viewportWidth = window.innerWidth;
        let perSlide;

        if (viewportWidth < 768) {
            perSlide = 1;
        } else if (viewportWidth < 1024) {
            perSlide = 2;
        } else if (viewportWidth < 1280) {
            perSlide = 3;
        } else {
            perSlide = 4;
        }

        // Update configuration
        itemsPerSlide = perSlide;

        // Recalculate total slides
        const totalNewSlides = Math.ceil(items.length / itemsPerSlide);

        // Adjust current slide if needed
        if (currentSlide >= totalNewSlides) {
            currentSlide = totalNewSlides - 1;
        }

        // Update position and dots
        updateSliderPosition();
        updateDots();
    }

    // Auto-sliding
    let autoSlideInterval;
    const slideDelay = 4000; // Slide every 4 seconds

    function startAutoSlide() {
        stopAutoSlide(); // Clear any existing interval first
        autoSlideInterval = setInterval(slideNext, slideDelay);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    function resetAutoSlideTimer() {
        stopAutoSlide();
        startAutoSlide();
    }

    // Pause auto-slide on hover
    track.addEventListener('mouseenter', stopAutoSlide);
    track.addEventListener('mouseleave', startAutoSlide);

    // Initialize the slider and start auto-sliding
    initSlider();
    startAutoSlide();
});

// FAQ Section JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Get all FAQ questions
    const questions = document.querySelectorAll(".ksd-faq-question");

    // Add click listener to each question
    questions.forEach((question) => {
        question.addEventListener("click", function () {
            // Toggle active class on the question
            const isActive = this.classList.contains("active");

            // Close all FAQs first
            document.querySelectorAll(".ksd-faq-question").forEach((q) => {
                q.classList.remove("active");
            });

            document.querySelectorAll(".ksd-faq-answer").forEach((a) => {
                a.style.maxHeight = "0";
            });

            // If this wasn't active, open it
            if (!isActive) {
                this.classList.add("active");
                const answer = this.nextElementSibling;
                answer.style.maxHeight = answer.scrollHeight + "px";
            }
        });
    });
});

/**
 * Modern Footer JavaScript
 * Contains additional interactive features and animations for the footer
 */
document.addEventListener("DOMContentLoaded", function () {
    // Optional: Add subtle parallax effect to decorative elements on scroll
    window.addEventListener("scroll", function () {
        const scrollPosition = window.scrollY;
        const orangeGlow = document.querySelector(".mf-orange-glow");
        const blueGlow = document.querySelector(".mf-blue-glow");

        if (orangeGlow && blueGlow) {
            orangeGlow.style.transform = `translate(${scrollPosition * 0.02}px, ${
                scrollPosition * 0.01
            }px)`;
            blueGlow.style.transform = `translate(-${scrollPosition * 0.02}px, -${
                scrollPosition * 0.01
            }px)`;
        }
    });

    // Optional: Add animated underline hover effect for links
    const links = document.querySelectorAll(".mf-link");
    links.forEach((link) => {
        link.addEventListener("mouseenter", function () {
            const dot = this.querySelector(".mf-link-dot");
            dot.style.width = "12px";
        });

        link.addEventListener("mouseleave", function () {
            const dot = this.querySelector(".mf-link-dot");
            dot.style.width = "6px";
        });
    });

    // Optional: Add smooth scrolling for navigation links
    document.querySelectorAll(".mf-link").forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            // Only apply to internal links (not external)
            if (this.getAttribute("href").startsWith("#")) {
                e.preventDefault();

                const targetId = this.getAttribute("href");
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: "smooth",
                    });
                }
            }
        });
    });

    // Optional: Back to top functionality
    // First, add this HTML to the footer:
    // <button class="mf-back-to-top" style="display: none;">
    //     <img src="https://api.iconify.design/solar:arrow-up-bold.svg?color=white" width="18" height="18" alt="بازگشت به بالا">
    // </button>

    // Then add this CSS to your stylesheet:
    // .mf-back-to-top {
    //     position: fixed;
    //     bottom: 30px;
    //     right: 30px;
    //     width: 50px;
    //     height: 50px;
    //     border-radius: 50%;
    //     background: linear-gradient(135deg, #0077ff, #005bb9);
    //     border: none;
    //     display: flex;
    //     align-items: center;
    //     justify-content: center;
    //     cursor: pointer;
    //     z-index: 100;
    //     opacity: 0;
    //     transform: translateY(20px);
    //     transition: all 0.3s ease;
    //     box-shadow: 0 5px 15px rgba(0, 119, 255, 0.3);
    // }
    // .mf-back-to-top.visible {
    //     opacity: 1;
    //     transform: translateY(0);
    // }
    // .mf-back-to-top:hover {
    //     background: linear-gradient(135deg, #0077ff, #0042a6);
    //     transform: translateY(-5px);
    //     box-shadow: 0 8px 20px rgba(0, 119, 255, 0.4);
    // }

    const backToTopBtn = document.querySelector(".mf-back-to-top");
    if (backToTopBtn) {
        window.addEventListener("scroll", function () {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.add("visible");
            } else {
                backToTopBtn.classList.remove("visible");
            }
        });

        backToTopBtn.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }
});




// اسکریپت اسلایدر مدرن داروگ
document.addEventListener('DOMContentLoaded', function() {
    // متغیرهای اصلی
    const slides = document.querySelectorAll('.slider-slide');
    const dots = document.querySelectorAll('.slider-dots .dot');
    const prevButton = document.querySelector('.arrow-prev');
    const nextButton = document.querySelector('.arrow-next');
    const counterCurrent = document.querySelector('.slider-counter .current');
    const progressBar = document.querySelector('.progress-bar');
    const totalSlides = slides.length;
    let currentSlide = 0;
    let slideInterval;
    const intervalTime = 7000; // زمان تغییر اسلاید (7 ثانیه)

    // تابع نمایش اسلاید
    function showSlide(index) {
        // مخفی کردن همه اسلایدها
        slides.forEach(slide => {
            slide.classList.remove('active');
        });

        // غیرفعال کردن همه دکمه‌های نشانگر
        dots.forEach(dot => {
            dot.classList.remove('active');
        });

        // نمایش اسلاید فعلی
        slides[index].classList.add('active');

        // فعال کردن دکمه نشانگر مربوطه
        dots[index].classList.add('active');

        // بروزرسانی شمارنده
        counterCurrent.textContent = (index + 1).toString().padStart(2, '0');

        // بروزرسانی اسلاید فعلی
        currentSlide = index;

        // شروع نوار پیشرفت
        startProgressBar();
    }

    // تابع شروع نوار پیشرفت
    function startProgressBar() {
        // ریست کردن نوار پیشرفت
        progressBar.style.width = '0%';

        // شروع انیمیشن پیشرفت
        progressBar.style.transition = `width ${intervalTime}ms linear`;
        setTimeout(() => {
            progressBar.style.width = '100%';
        }, 50);
    }

    // تابع اسلاید بعدی
    function nextSlide() {
        let newIndex = currentSlide + 1;
        if (newIndex >= totalSlides) {
            newIndex = 0;
        }
        showSlide(newIndex);
    }

    // تابع اسلاید قبلی
    function prevSlide() {
        let newIndex = currentSlide - 1;
        if (newIndex < 0) {
            newIndex = totalSlides - 1;
        }
        showSlide(newIndex);
    }

    // شروع اسلاید خودکار
    function startSlideInterval() {
        // ریست کردن زمان‌سنج قبلی
        clearInterval(slideInterval);

        // شروع زمان‌سنج جدید
        slideInterval = setInterval(() => {
            nextSlide();
        }, intervalTime);
    }

    // دکمه‌های کنترل
    prevButton.addEventListener('click', () => {
        prevSlide();
        startSlideInterval(); // ریست تایمر بعد از کلیک
    });

    nextButton.addEventListener('click', () => {
        nextSlide();
        startSlideInterval(); // ریست تایمر بعد از کلیک
    });

    // نقاط نشانگر
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            startSlideInterval(); // ریست تایمر بعد از کلیک
        });
    });

    // پشتیبانی از پیمایش لمسی (سوایپ)
    let touchStartX = 0;
    let touchEndX = 0;

    const sliderContainer = document.querySelector('.slider-container');

    sliderContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    sliderContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50; // آستانه تشخیص سوایپ

        // محاسبه فاصله سوایپ
        const swipeDistance = touchEndX - touchStartX;

        // اگر فاصله کافی باشد، به عنوان سوایپ در نظر گرفته می‌شود
        if (Math.abs(swipeDistance) >= swipeThreshold) {
            if (swipeDistance > 0) {
                // سوایپ به راست (اسلاید قبلی)
                prevSlide();
            } else {
                // سوایپ به چپ (اسلاید بعدی)
                nextSlide();
            }
            startSlideInterval(); // ریست تایمر بعد از سوایپ
        }
    }

    // شروع اسلایدر
    showSlide(0);
    startSlideInterval();

    // پشتیبانی از کلیدهای جهت‌دار
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            nextSlide(); // برای سایت RTL، جهت‌ها برعکس است
            startSlideInterval();
        } else if (e.key === 'ArrowRight') {
            prevSlide(); // برای سایت RTL، جهت‌ها برعکس است
            startSlideInterval();
        }
    });

    // متوقف کردن اسلاید خودکار هنگام هاور
    sliderContainer.addEventListener('mouseenter', () => {
        clearInterval(slideInterval);
        // توقف انیمیشن نوار پیشرفت
        progressBar.style.transition = 'none';
    });

    // شروع مجدد اسلاید خودکار بعد از خروج ماوس
    sliderContainer.addEventListener('mouseleave', () => {
        startSlideInterval();
        startProgressBar();
    });

    // افکت پارالاکس برای تصاویر
    document.addEventListener('mousemove', (e) => {
        if (window.innerWidth > 992) { // فقط در دسکتاپ
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;

            slides.forEach(slide => {
                const image = slide.querySelector('.slide-image img');
                // حرکت کم تصویر با حرکت ماوس (افکت پارالاکس)
                if (image) {
                    image.style.transform = `translate(${mouseX * -15}px, ${mouseY * -15}px) scale(1.05)`;
                }
            });
        }
    });
});
