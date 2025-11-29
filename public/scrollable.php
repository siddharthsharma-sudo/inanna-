<?php
/**
 * Expressive Auto-Scrolling Gallery Section
 * Updated to fetch **latest images first**
 */

$host = 'localhost';
$db   = 'your_database_name';    // **CHANGE THIS**
$user = 'your_db_user';          // **CHANGE THIS**
$pass = 'your_db_password';      // **CHANGE THIS**
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$images = [];
$errorMessage = '';

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    
    // UPDATED → Fetch latest images first
    $stmt = $pdo->query("
        SELECT image_url, alt_text, image_class 
        FROM gallery_images 
        ORDER BY id DESC
    ");

    $images = $stmt->fetchAll();

} catch (\PDOException $e) {
    error_log('Gallery DB Error: ' . $e->getMessage());
    $errorMessage = '<p style="color: red; text-align: center;">Error loading gallery images from the database.</p>';
}
?>

<style>
    :root {
        --text-color: #333;
        --background-color: #fff;
        --font-primary: 'Playfair Display', serif;
    }

    .expressive-wrapper {
        padding: 60px 0;
        text-align: center;
        font-family: var(--font-primary);
        color: var(--text-color);
    }

    .expressive-title-container {
        margin-bottom: 50px;
        padding: 0 20px;
    }

    .expressive-title {
        font-size: 2.5rem;
        font-weight: 500;
        margin: 0;
        letter-spacing: 5px;
    }

    .expressive-subtitle {
        font-size: 1.2rem;
        font-weight: 400;
        margin-top: 5px;
        letter-spacing: 12px;
        color: #555;
    }

    .expressive-gallery {
        display: flex;
        overflow-x: scroll;
        white-space: nowrap;
        align-items: flex-end;
        gap: 15px;
        padding: 0 5vw;
        scrollbar-width: none;
    }

    .expressive-gallery::-webkit-scrollbar {
        display: none;
    }

    .expressive-card {
        flex-shrink: 0;
        width: 200px;
        height: 300px;
        overflow: hidden;
    }

    .center-card {
        width: 280px;
        height: 400px;
    }

    .expressive-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .expressive-title {
            font-size: 1.8rem;
        }

        .expressive-subtitle {
            font-size: 0.9rem;
            letter-spacing: 6px;
        }

        .expressive-card {
            width: 180px;
            height: 250px;
        }

        .center-card {
            width: 240px;
            height: 340px;
        }
    }
</style>

<section class="expressive-wrapper">
    <div class="expressive-title-container">
        <h2 class="expressive-title">EXPRESSIVE</h2>
        <h3 class="expressive-subtitle">TIMELESS ELEGANT</h3>
    </div>

    <?= $errorMessage ?>

    <div class="expressive-gallery">
        <?php
        if (!empty($images)) {
            foreach ($images as $image) {
                $url = htmlspecialchars($image['image_url']);
                $alt = htmlspecialchars($image['alt_text']);
                $class = htmlspecialchars($image['image_class']);

                echo "<div class=\"expressive-card $class\">";
                echo "<img src=\"$url\" alt=\"$alt\">";
                echo "</div>";
            }

            // Smooth looping duplicates
            if (count($images) >= 3) {
                $dup1 = $images[0];
                $dup2 = $images[1];

                echo "<div class=\"expressive-card {$dup1['image_class']}\"><img src=\"{$dup1['image_url']}\" alt=\"dup\"></div>";
                echo "<div class=\"expressive-card {$dup2['image_class']}\"><img src=\"{$dup2['image_url']}\" alt=\"dup\"></div>";
            }

        } else if (!$errorMessage) {
            echo '<p>No gallery images available at this time.</p>';
        }
        ?>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const gallery = document.querySelector('.expressive-gallery');
    if (!gallery) return;

    const scrollSpeed = 0.5;
    const intervalTime = 10;
    let scrollPosition = 0;

    function autoScroll() {
        scrollPosition += scrollSpeed;

        if (scrollPosition >= gallery.scrollWidth - gallery.clientWidth) {
            scrollPosition = 0;
        }

        gallery.scrollLeft = scrollPosition;
    }

    let autoScrollInterval = setInterval(autoScroll, intervalTime);

    gallery.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
    gallery.addEventListener('mouseleave', () => {
        autoScrollInterval = setInterval(autoScroll, intervalTime);
    });
});
</script>
