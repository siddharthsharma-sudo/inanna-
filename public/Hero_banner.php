<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<style>
    /* Reset and general styles for demonstration */
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }
    .swiper {
        width: 100%;
        height: 100vh; /* Full viewport height on desktop */
    }

    /* Style for each slide */
    .swiper-slide {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        color: #fff; /* White text for contrast on dark background */
        text-align: center;
    }

    /* Video background styling */
    .fashion-video-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures the video covers the entire slide */
        z-index: 1;
    }

    /* Dark overlay for better text readability */
    .fashion-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent black overlay */
        z-index: 2;
    }

    /* Text content styling */
    .fashion-content {
        position: relative;
        z-index: 3;
        padding: 20px;
        max-width: 800px;
        align-self:end;
        margin-bottom:5rem;
        
    }

    /* Responsive Font Size for Header */
    .fashion-content h1 {
        font-size: 4vw; /* Use vw for responsive size */
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1.1;
    }

    /* Responsive Font Size for Paragraph */
    .fashion-content p {
        font-size: 1vw; /* Use vw for responsive size */
        margin-bottom: 20px;
        opacity: 0.9;
    }

    .fashion-btn {
        padding: 12px 35px;
        background: #fff; 
        color: #000;
        text-decoration: none;
        border-radius: 5px; 
        font-size: 18px;
        font-weight: 600;
        transition: background 0.3s;
    }
    
    .fashion-btn:hover {
        background: #e0e0e0;
    }

    /* Navigation Arrows - Styled for a full-screen dark look */
    .swiper-button-next,
    .swiper-button-prev {
        color: #fff !important; 
        border: 1px solid #fff;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        transition: background 0.3s;
        /* Positioned for desktop */
        top: 50%;
        transform: translateY(-50%);
    }
    
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 15px !important;
    }

    .swiper-button-next:hover,
    .swiper-button-prev:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .swiper-button-prev {
        left: 50px; 
    }

    .swiper-button-next {
        right: 50px; 
    }

    /* Hide pagination as it's not visible in the image's style */
    .swiper-pagination {
        display: none;
    }
    
    /* =========================
       RESPONSIVE MEDIA QUERIES
       ========================= */

    @media (max-width: 1024px) {
        /* Tablet adjustments */
        .swiper-button-prev {
            left: 20px;
        }
        .swiper-button-next {
            right: 20px;
        }
    }

    @media (max-width: 768px) {
        /* Mobile adjustments */
        .swiper {
            height: 70vh; /* Smaller height on mobile to save screen space */
        }
        
        /* Fixed, larger font sizes for mobile to ensure legibility */
        .fashion-content h1 {
            font-size: 36px;
        }
        .fashion-content p {
            font-size: 16px;
        }
        
        /* Smaller navigation arrows and closer to the edges */
        .swiper-button-next,
        .swiper-button-prev {
             width: 40px;
             height: 40px;
             border-width: 2px;
        }
        .swiper-button-prev {
            left: 10px;
        }
        .swiper-button-next {
            right: 10px;
        }
        
        .fashion-btn {
            padding: 10px 25px;
            font-size: 16px;
        }
    }
    
    @media (max-width: 480px) {
        /* Very small screens */
        .fashion-content {
            padding: 10px;
        }
        .fashion-content h1 {
            font-size: 30px;
        }
        .swiper-button-next,
        .swiper-button-prev {
             display: none; /* Hide arrows on smallest screens if preferred */
        }
    }
</style>

<div class="swiper fashion-hero-slider">

    <div class="swiper-wrapper">

        <div class="swiper-slide">
            <video class="fashion-video-background" autoplay loop muted playsinline poster="">
                <source src="https://worldofinanna.org/wp-content/uploads/2025/11/innana-curvy.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="fashion-overlay"></div>
            <div class="fashion-content">
                <h1>Fashion with Purpose</h1>
                <p>Explore our limited edition collection that champions sustainable style.</p>
                <a href="#" class="fashion-btn">SHOP NOW</a>
            </div>
        </div>

        <div class="swiper-slide">
            <video class="fashion-video-background" autoplay loop muted playsinline poster="">
                <source src="https://worldofinanna.org/wp-content/uploads/2025/11/innana-curvy.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="fashion-overlay"></div>
            <div class="fashion-content">
                <h1>The New Era of Luxury</h1>
                <p>Discover bold silhouettes and exclusive handcrafted pieces.</p>
                <a href="#" class="fashion-btn">DISCOVER</a>
            </div>
        </div>

        <!-- <div class="swiper-slide">
            <video class="fashion-video-background" autoplay loop muted playsinline poster="">
                <source src="https://dummy-video-url-3.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="fashion-overlay"></div>
            <div class="fashion-content">
                <h1>Unleash Your Urban Edge</h1>
                <p>Streetwear redefined with modern tailoring and comfortable fits.</p>
                <a href="#" class="fashion-btn">VIEW COLLECTION</a>
            </div>
        </div> -->

    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>

</div>


<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
    var swiper = new Swiper(".fashion-hero-slider", {
        loop: true,
        autoplay: {
            delay: 9000, 
            disableOnInteraction: false,
        },
        speed: 1200, 
        effect: "fade",
        fadeEffect: {
            crossFade: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        on: {
            init: function () {
                var activeVideo = this.slides[this.activeIndex].querySelector('.fashion-video-background');
                if (activeVideo) {
                    activeVideo.play();
                }
            },
            slideChangeTransitionStart: function () {
                var videos = this.el.querySelectorAll('.fashion-video-background');
                videos.forEach(video => {
                    video.pause();
                    video.currentTime = 0; 
                });
            },
            slideChangeTransitionEnd: function () {
                var activeVideo = this.slides[this.activeIndex].querySelector('.fashion-video-background');
                if (activeVideo) {
                    activeVideo.play();
                }
            }
        }
    });
</script>