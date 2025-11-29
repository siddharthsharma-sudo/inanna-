<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    :root { 
        --font-primary: 'Playfair Display', serif;
        --text-color: #333;
    }

    .expressive-wrapper {
        padding: 60px 0;
        text-align: center;
        font-family: var(--font-primary);
        color: var(--text-color);
    }

    .expressive-title {
        font-size: 2.5rem;
        letter-spacing: 5px;
        margin-bottom: 5px;
    }

    .expressive-subtitle {
        font-size: 1.2rem;
        letter-spacing: 12px;
        color: #555;
        margin-bottom: 50px;
    }

    .expressive-gallery {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 15px;
    }

    .expressive-card {
        overflow: hidden;
        border-radius: 3px;
        transition: 0.3s ease;
    }

    .small { width: 170px; height: 250px; }
    .medium { width: 220px; height: 350px; }
    .large { width: 320px; height: 500px; }

    @media (max-width: 768px) {
        .small { width: 90px; height: 150px; }
        .medium { width: 120px; height: 240px; }
        .large { width: 180px; height: 350px; }
    }

    .expressive-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<section class="expressive-wrapper">
    <h2 class="expressive-title">EXPRESSIVE</h2>
    <h3 class="expressive-subtitle">TIMELESS ELEGANT</h3>

    <div class="expressive-gallery">

        <div class="expressive-card small">
            <img src="uploads/large.jpg" alt="">
        </div>

        <div class="expressive-card medium">
            <img src="uploads/medium.jpg" alt="">
        </div>

        <div class="expressive-card large">
            <img src="uploads/small.jpg" alt="">
        </div>

        <div class="expressive-card medium">
            <img src="uploads/large.jpg" alt="">
        </div>

        <div class="expressive-card small">
            <img src="uploads/medium.jpg" alt="">
        </div>

    </div>
</section>