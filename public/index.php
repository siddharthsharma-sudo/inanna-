<?php
// public/index.php - main homepage
// Use includes/header.php and includes/footer.php inside the public folder

// If you later use sessions, you can start here
// session_start();

include __DIR__ . '/includes/header.php';?>





<?php require "Hero_banner.php"; ?>

<!-- ===========Product Listing ======-->

<style>
    /* Add a basic container for the grid */
    .product-grid-section {
        padding: 40px 20px;
        font-family: Arial, sans-serif;
    }

    /* Grid container for 4 columns on desktop */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Product card styling */
    .product-card {
        text-align: left;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: #000;
    }

    /* Image container for the hover effect */
    .product-image-container {
        position: relative;
        overflow: hidden;
        /* Ensures a square aspect ratio for placeholders */
        padding-top: 130%; /* Set aspect ratio (e.g., 100% for square, 130% for taller portrait) */
        height: 0;
        margin-bottom: 10px;
    }

    /* Styling for both images (front and back) */
    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.4s ease-in-out;
    }

    /* Initial state: Show the primary image */
    .product-image.back-image {
        opacity: 0;
    }

    /* Hover state: Hide the primary image and show the secondary image */
    .product-card:hover .product-image.front-image {
        opacity: 0;
    }
    .product-card:hover .product-image.back-image {
        opacity: 1;
    }

    /* Text styling */
    .product-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .product-price {
        font-size: 14px;
        color: #333;
        margin-bottom: 10px;
        font-weight: 500;
    }

    /* Button/Link styling */
    .product-actions {
        display: flex;
        align-items: center;
        margin-top: 8px;
    }

    .select-btn {
        font-size: 12px;
        font-weight: 600;
        color: #c0392b; /* Reddish color from your image */
        text-decoration: none;
        margin-right: 15px;
        letter-spacing: 0.5px;
    }

    .quickview-btn {
        font-size: 12px;
        font-weight: 600;
        color: #c0392b;
        text-decoration: none;
        border-left: 1px solid #ccc;
        padding-left: 15px;
        letter-spacing: 0.5px;
    }

    /* Heart icon (can be replaced with an SVG/Font Icon) */
    .heart-icon {
        color: #c0392b;
        font-size: 18px;
        margin-left: auto;
        cursor: pointer;
    }

    /* ==================================
       RESPONSIVE DESIGN (2-column layout)
       ================================== */
    @media (max-width: 992px) {
        /* Tablet: 3 columns */
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 600px) {
        /* Mobile: 2 columns (as requested) */
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px; /* Reduce gap on mobile */
        }
        .product-grid-section {
            padding: 20px 10px; /* Reduce padding on mobile */
        }
        .product-title {
            font-size: 14px;
        }
        .product-price {
            font-size: 13px;
        }
    }
</style>

<section class="product-grid-section">
    <div class="product-grid">

        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=1" 
                     data-src-dynamic="image_url_1" 
                     class="product-image front-image" 
                     alt="Golden Hour Heiress - Primary view"/>
                
                <img src="https://picsum.photos/400/520?random=2" 
                     data-src-dynamic="image_hover_url_1" 
                     class="product-image back-image" 
                     alt="Golden Hour Heiress - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Golden hour heiress</h3>
                <p class="product-price">₹0.00 - ₹26,645.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>
        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=3" data-src-dynamic="image_url_2" class="product-image front-image" alt="After midnight sheer shirt - Primary view"/>
                <img src="https://picsum.photos/400/520?random=4" data-src-dynamic="image_hover_url_2" class="product-image back-image" alt="After midnight sheer shirt - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">After midnight sheer shirt</h3>
                <p class="product-price">₹8,250.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>

        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=5" data-src-dynamic="image_url_3" class="product-image front-image" alt="Tidal Romance Co-ord - Primary view"/>
                <img src="https://picsum.photos/400/520?random=6" data-src-dynamic="image_hover_url_3" class="product-image back-image" alt="Tidal Romance Co-ord - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Tidal Romance Co-ord - Striped top & multiple Split Skirt Set</h3>
                <p class="product-price">₹7,119.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>
        
        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=7" data-src-dynamic="image_url_4" class="product-image front-image" alt="Pastel power Jacquard set - Primary view"/>
                <img src="https://picsum.photos/400/520?random=8" data-src-dynamic="image_hover_url_4" class="product-image back-image" alt="Pastel power Jacquard set - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Pastel power Jacquard set</h3>
                <p class="product-price">₹8,900.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>

        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=9" data-src-dynamic="image_url_5" class="product-image front-image" alt="Lunar Lines Split Set - Primary view"/>
                <img src="https://picsum.photos/400/520?random=10" data-src-dynamic="image_hover_url_5" class="product-image back-image" alt="Lunar Lines Split Set - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Lunar Lines Split Set</h3>
                <p class="product-price">₹8,319.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>
        
        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=11" data-src-dynamic="image_url_6" class="product-image front-image" alt="Embrace - Primary view"/>
                <img src="https://picsum.photos/400/520?random=12" data-src-dynamic="image_hover_url_6" class="product-image back-image" alt="Embrace - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Embrace</h3>
                <p class="product-price">₹3,500.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>
        
        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=13" data-src-dynamic="image_url_7" class="product-image front-image" alt="Whirlwind Serenade - Primary view"/>
                <img src="https://picsum.photos/400/520?random=14" data-src-dynamic="image_hover_url_7" class="product-image back-image" alt="Whirlwind Serenade - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Whirlwind Serenade</h3>
                <p class="product-price">₹4,000.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>
        
        <a href="#" class="product-card">
            <div class="product-image-container">
                <img src="https://picsum.photos/400/520?random=15" data-src-dynamic="image_url_8" class="product-image front-image" alt="Golden Hour Silk-Net Saree - Primary view"/>
                <img src="https://picsum.photos/400/520?random=16" data-src-dynamic="image_hover_url_8" class="product-image back-image" alt="Golden Hour Silk-Net Saree - Hover view"/>
            </div>
            <div class="product-text">
                <h3 class="product-title">Golden Hour Silk-Net Saree</h3>
                <p class="product-price">₹42,900.00</p>
                <div class="product-actions">
                    <span class="select-btn">SELECT OPTIONS</span>
                    <span class="quickview-btn">QUICKVIEW</span>
                    <span class="heart-icon">♥</span>
                </div>
            </div>
        </a>

    </div>
</section>

<!-- ====== Second section ========================== -->

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap');

    :root {
        
        --accent-gradient-start: #e53c7a;
        --accent-gradient-end: #c90f5c;
        --text-color: #fff;
    }

    .promo-container {
        display: flex;
        max-width: 1200px;
        margin: 0 auto;
        gap: 20px;
        padding: 40px 20px;
        flex-wrap: wrap;
        justify-content: center;
        font-family: 'Playfair Display', serif;
    }

    .promo-card {
        flex: 1 1 45%;
        min-width: 350px;
        height: 600px;
        background-color: var(--card-bg-color);
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 30px;
    }

    .promo-card img {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        object-fit: cover;
        mix-blend-mode: luminosity;
        opacity: 0.8;
        z-index: 1;
    }
    
    .text-content-positioned {
        position: absolute;
        z-index: 2;
        color: var(--text-color);
        padding: 30px;
        box-sizing: border-box;
        width: 100%;
        top: 0;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .main-headline {
        font-size: 2.5rem;
        font-weight: 600;
        line-height: 1.1;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0;
        padding-top: 50px;
    }

    .main-headline span {
        display: block;
    }

    .card-note {
        font-size: 1rem;
        font-weight: 400;
        margin-top: 20px;
        line-height: 1.5;
        margin-bottom: auto;
    }

    .card-one .main-headline {
        text-align: right;
        margin-left: auto;
        max-width: 80%;
    }
    .card-one .card-note {
        text-align: right;
        margin-left: auto;
        max-width: 60%;
    }
    .card-one .cta-button-wrapper {
        align-self: flex-end;
    }

    .card-two .main-headline {
        text-align: left;
        margin-right: auto;
        max-width: 80%;
    }
    .card-two .card-note {
        text-align: left;
        margin-right: auto;
        max-width: 70%;
    }
    .card-two .cta-button-wrapper {
        align-self: flex-start;
    }
    
    .cta-button-wrapper {
        position: relative;
        z-index: 2;
        margin-top: auto;
        display: flex;
        padding-top: 20px;
    }

    .cta-button {
        background: linear-gradient(to right, var(--accent-gradient-start), var(--accent-gradient-end));
        color: var(--text-color);
        border: none;
        padding: 15px 30px;
        font-size: 0.95rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        border-radius: 5px;
        transition: opacity 0.3s ease;
        white-space: nowrap;
    }

    .cta-button:hover {
        opacity: 0.85;
    }

    @media (max-width: 768px) {
        .promo-card {
            flex: 1 1 100%;
            height: 500px;
        }
        .card-one .main-headline,
        .card-one .card-note,
        .card-one .cta-button-wrapper,
        .card-two .main-headline,
        .card-two .card-note,
        .card-two .cta-button-wrapper {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            max-width: 90%;
            align-self: center;
            justify-content: center;
        }
        .cta-button-wrapper {
            justify-content: center;
        }
        .main-headline {
            font-size: 2rem;
            padding-top: 30px;
        }
        .card-note {
            font-size: 0.9rem;
        }
    }
</style>

<div class="promo-container">
    
    <div class="promo-card card-one">
        <img src="images/model_yellow_card1.jpg" alt="Model sitting on a box in a yellow and red setting.">

        <div class="text-content-positioned">
            <div>
                <h2 class="main-headline">
                    WE DON'T RESTOCK 
                    <span>WE REINVENT</span>
                </h2>
                <p class="card-note">
                    INANNA isn't about trends—it's about transformation.
                </p>
            </div>
            <div class="cta-button-wrapper">
                <button class="cta-button">Secure your piece</button>
            </div>
        </div>
    </div>

    <div class="promo-card card-two">
        <img src="images/model_yellow_card2.jpg" alt="Model lying down in a brown dress in a yellow and red setting.">

        <div class="text-content-positioned">
            <div>
                <h2 class="main-headline">
                    EXCLUSIVITY 
                    <span>ISN'T OFFERED</span>
                    <span>IT'S CREATED</span>
                </h2>
                <p class="card-note">
                    Every 15 days a new drop. 
                    <br>No repeats no apologies.
                </p>
            </div>
            <div class="cta-button-wrapper">
                <button class="cta-button">SHOP NOW</button>
            </div>
        </div>
    </div>

</div>

<!-- ========Collection============= -->
 <?php require 'collection.php'?>
<!-- =====Bare-Essence Code -->

<?php require 'bare-essence.php'?>

<!-- ========Scollable Expressive Gallery======== -->

<?php require 'scrollable.php'?>


<div class="py-5 text-center">
  <div class="container">
     <h1 class="display-5">Welcome to My Shop</h1>
    <p class="lead">This is the homepage. Replace this content with your homepage HTML.</p>
    <p><a href="product.php" class="btn btn-primary">View Products</a></p>
  </div>
</div>



<?php
include __DIR__ . '/includes/footer.php';
