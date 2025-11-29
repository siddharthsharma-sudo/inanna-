<!-- ===================== HTML ===================== -->

<section class="product-gallery-section">
    <div class="left-image-wrapper">
        <img id="largeImage" src="" alt="Large Product Image">
    </div>

    <div class="right-image-wrapper">
        <div class="right-image-content">
            <img id="smallImage" src="" alt="Small Product Image">
        </div>
        
        <div class="slider-controls">
            <button id="prevSlide" class="slider-button disabled">&#9664;</button> 
            <button id="nextSlide" class="slider-button">&#9654;</button>
        </div>
    </div>
</section>


<!-- ===================== CSS ===================== -->

<style>
/* Main wrapper with perfect equal height */
.product-gallery-section {
    width: 100%;
    max-width: 1400px;
    margin: 50px auto;
    display: flex;
    background-color: white;
    height: 600px; /* FIXED HEIGHT for perfect fitting */
    overflow: hidden;
}

/* LEFT IMAGE SECTION */
.left-image-wrapper {
    flex: 3; /* 60% width approx */
    height: 100%;
    overflow: hidden;
    background-color: #F8F8F8;
}

.left-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* fills space properly */
    transition: opacity 0.4s ease-in-out;
}

/* RIGHT IMAGE SECTION */
.right-image-wrapper {
    flex: 2; /* 40% width approx */
    height: 100%;
    padding: 40px;
    background-color: white;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    box-sizing: border-box;
}

.right-image-content {
    width: 100%;
    height: 100%;
    max-height: 500px; /* keeps proper ratio */
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.right-image-content img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: opacity 0.4s ease-in-out;
}

/* Slider Buttons */
.slider-controls {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 15px;
}

.slider-button {
    background-color: white;
    border: 1px solid #ccc;
    width: 40px;
    height: 40px;
    font-size: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.slider-button:hover:not(.disabled) {
    background-color: #e0e0e0;
}

.slider-button.disabled {
    opacity: 0.5;
    cursor: default;
}

/* ================= MOBILE STYLING ================= */
@media (max-width: 992px) {
    .product-gallery-section {
        flex-direction: column;
        height: auto;
    }

    .left-image-wrapper {
        height: 350px;
    }

    .right-image-wrapper {
        height: auto;
        padding: 20px;
    }

    .right-image-content {
        height: 300px;
        max-height: none;
    }

    .slider-controls {
        bottom: 10px;
        right: 10px;
    }
}
</style>


<!-- ===================== JS ===================== -->

<script>
document.addEventListener("DOMContentLoaded", () => {

    /* -----------------------------------------------------
       JUST EDIT THESE IMAGE PAIRS BELOW ⬇️
       ----------------------------------------------------- */
    const sliderImages = [
        {
            large: "uploads/large.jpg",
            small: "uploads/small.jpg",
            altLarge: "First Large",
            altSmall: "First Small"
        },
        {
            large: "uploads/medium.jpg",
            small: "uploads/small.jpg",
            altLarge: "Second Large",
            altSmall: "Second Small"
        },
        {
            large: "uploads/large.jpg",
            small: "uploads/small.jpg",
            altLarge: "Third Large",
            altSmall: "Third Small"
        },
        {
            large: "uploads/large.jpg",
            small: "uploads/medium.jpg",
            altLarge: "Fourth Large",
            altSmall: "Fourth Small"
        }
    ];
    /* ----------------------------------------------------- */

    const largeImage = document.getElementById("largeImage");
    const smallImage = document.getElementById("smallImage");
    const nextBtn = document.getElementById("nextSlide");
    const prevBtn = document.getElementById("prevSlide");

    let index = 0;

    function updateSlider() {
        const s = sliderImages[index];

        largeImage.style.opacity = 0;
        smallImage.style.opacity = 0;

        setTimeout(() => {
            largeImage.src = s.large;
            largeImage.alt = s.altLarge;
            smallImage.src = s.small;
            smallImage.alt = s.altSmall;

            largeImage.style.opacity = 1;
            smallImage.style.opacity = 1;
        }, 200);

        prevBtn.classList.toggle("disabled", index === 0);
        nextBtn.classList.toggle("disabled", index === sliderImages.length - 1);
    }

    nextBtn.addEventListener("click", () => {
        if (index < sliderImages.length - 1) {
            index++;
            updateSlider();
        }
    });

    prevBtn.addEventListener("click", () => {
        if (index > 0) {
            index--;
            updateSlider();
        }
    });

    updateSlider(); // load first slide
});
</script>
