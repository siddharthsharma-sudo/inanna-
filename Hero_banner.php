<!-- ========================================================= -->
<!-- 1. HERO SECTION (Swiper Slider with Enhanced Controls) -->
<!-- ========================================================= -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="assets/css/style.css">
<section id="hero">
    
    <div class="swiper fashion-hero-slider">
    
        <div class="swiper-wrapper">

            <div class="swiper-slide" aria-label="Slide 1">
        <video class="fashion-video-background" muted playsinline loop preload="metadata" aria-hidden="true">
          <source data-src="assets/video/1.mp4" type="video/mp4">
        </video>
        <div class="fashion-overlay" aria-hidden="true"></div>
                <div class="fashion-overlay"></div>
                <div class="fashion-content">
                    <div class="hero-tagline">NEW TREND</div>
                    <h1 class="hero-title">CULTURAL<br/>ELEGANCE</h1>
                    <a href="#" class="hero-cta">
                        <span>OUR STUDIO</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="swiper-slide">
            <video class="fashion-video-background" muted playsinline loop preload="metadata" aria-hidden="true">
          <source data-src="assets/video/2.mp4" type="video/mp4">
        </video>
                <div class="fashion-overlay"></div>
                <div class="fashion-content">
                    <div class="hero-tagline">A PRESENCE YOU DON'T FOLLOW UP WITH.</div>
                    <h1 class="hero-title">FASHION WITH<br/>PURPOSE</h1>
                    <a href="#" class="hero-cta">
                        <span>EXPLORE</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="swiper-slide">
            <video class="fashion-video-background" muted playsinline loop preload="metadata" aria-hidden="true">
          <source data-src="assets/video/3.mp4" type="video/mp4">
        </video>
                <div class="fashion-overlay"></div>
                <div class="fashion-content">
                    <div class="hero-tagline">THE NEW COLLECTION: NO PLUS ONE.</div>
                    <h1 class="hero-title">TIMELESS<br/>ELEGANCE</h1>
                    <a href="#" class="hero-cta">
                        <span>SHOP NOW</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        <!-- Navigation Arrows -->
        <button class="hero-arrow hero-arrow-prev" aria-label="Previous">
            <svg class="hero-arrow-icon" viewBox="0 0 24 24">
                <path d="M15 6l-6 6 6 6" stroke="currentColor" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <line x1="8" y1="12" x2="20" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></line>
            </svg>
        </button>
        <button class="hero-arrow hero-arrow-next" aria-label="Next">
            <svg class="hero-arrow-icon" viewBox="0 0 24 24">
                <path d="M9 6l6 6-6 6" stroke="currentColor" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <line x1="4" y1="12" x2="16" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></line>
            </svg>
        </button>
        
        <!-- Pagination Bars -->
        <div class="hero-pagination"></div>

        <!-- Social Icons -->
        <div class="hero-social">
            <span class="hero-social-label">FOLLOW US</span>
            <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="hero-scroll"><span>SCROLL</span><span class="hero-scroll-line"></span></div>

    </div>

</section>

 
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Load sources from data-src -> src, mark as loaded
  function loadVideo(video) {
    if (!video || video.dataset.loaded === 'true') return;
    const sources = video.querySelectorAll('source[data-src]');
    sources.forEach(s => {
      s.src = s.getAttribute('data-src');
      s.removeAttribute('data-src');
    });
    try { video.load(); } catch(e){}
    video.dataset.loaded = 'true';
  }

  // Play only index's video; pause others and reset
  function playOnlyActive(swiper, index) {
    swiper.slides.forEach((slide, i) => {
      const v = slide.querySelector('video.fashion-video-background');
      if (!v) return;
      if (i === index) {
        loadVideo(v);
        // ensure muted and try to play
        v.muted = true;
        const p = v.play();
        if (p && p.then) {
          p.catch(()=>{/* autoplay blocked */});
        }
      } else {
        try { v.pause(); v.currentTime = 0; } catch(e){}
      }
    });
  }

  var swiper = new Swiper('.fashion-hero-slider', {
    loop: true,
    autoplay: { delay: 5000, disableOnInteraction: false },
    speed: 900,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    navigation: { nextEl: '.hero-arrow-next', prevEl: '.hero-arrow-prev' },
    pagination: {
      el: '.hero-pagination',
      type: 'bullets',
      clickable: true,
      renderBullet: function(index, className) {
        return '<span class="' + className + ' hero-bullet"></span>';
      }
    },
    on: {
      init: function() {
        playOnlyActive(this, this.activeIndex);
      },
      slideChangeTransitionStart: function() {
        playOnlyActive(this, this.activeIndex);
      },
      autoplayStop: function() {
        document.querySelectorAll('video.fashion-video-background').forEach(v=>{try{v.pause();}catch(e){}});
      },
      autoplayStart: function() {
        playOnlyActive(this, this.activeIndex);
      }
    }
  });

  // Pause autoplay when user interacts with navigation for accessibility
  document.querySelectorAll('.hero-arrow').forEach(btn => {
    btn.addEventListener('focus', () => { try{ swiper.autoplay.stop(); }catch(e){} });
    btn.addEventListener('blur',  () => { try{ swiper.autoplay.start(); }catch(e){} });
  });

  // free video memory on pagehide
  window.addEventListener('pagehide', () => {
    document.querySelectorAll('video.fashion-video-background').forEach(v => {
      try { v.pause(); v.src = ''; } catch(e){}
    });
  });
});
</script>
<style>
/* Minimal styles for video-only hero */
#hero { position: relative; }
.fashion-hero-slider { position: relative; overflow: hidden; }
.swiper-slide { position: relative; min-height: 70vh; }

/* video fills slide */
.fashion-video-background {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: 0;
}

/* optional subtle overlay to keep contrast for UI elements */
.fashion-overlay { position:absolute; inset:0; background: rgba(0,0,0,0.12); z-index:1; }

/* ensure arrow buttons are clickable and visible */
.hero-arrow { background: transparent; border: 0; cursor: pointer; }
</style>
