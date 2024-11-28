<?php
// 1.Fetch data for upcoming animes
$upcomingApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/upcoming';
$upcomingJsonData = file_get_contents($upcomingApiUrl);
$upcomingResponse = json_decode($upcomingJsonData, true);

// 2.Fetch data for top rated animes
$topRatedApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/bypopularity';
$topRatedJsonData = file_get_contents($topRatedApiUrl); 
$topRatedResponse = json_decode($topRatedJsonData, true);

// 3.Fetch data for top airing animes
$topAiringApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/airing';
$topAiringJsonData = file_get_contents($topAiringApiUrl); 
$topAiringResponse = json_decode($topAiringJsonData, true);

// 4.Fetch data for top ova animes
$topOvaApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/ova';
$topOvaJsonData = file_get_contents($topOvaApiUrl); 
$topOvaResponse = json_decode($topOvaJsonData, true);

// 5.Fetch data for top movie animes
$topMovieApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/movie';
$topMovieJsonData = file_get_contents($topMovieApiUrl); 
$topMovieResponse = json_decode($topMovieJsonData, true);

// 6.Fetch data for top favorited animes
$topFavoriteApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/favorite';
$topFavoriteJsonData = file_get_contents($topFavoriteApiUrl); 
$topFavoriteResponse = json_decode($topFavoriteJsonData, true);

// 7.Fetch data for top series animes
$topSeriesApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/all';
$topSeriesJsonData = file_get_contents($topSeriesApiUrl); 
$topSeriesResponse = json_decode($topSeriesJsonData, true);

// 8.Fetch data for top special animes
$topSpecialApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/special';
$topSpecialJsonData = file_get_contents($topSpecialApiUrl); 
$topSpecialResponse = json_decode($topSpecialJsonData, true);

// 9.Fetch data for top TV animes
$topTVApiUrl = 'https://data.mediascout.tokyo/anime/recommendations/tv';
$topTVJsonData = file_get_contents($topTVApiUrl); 
$topTVResponse = json_decode($topTVJsonData, true);


// Use the Season class to fetch current year and season
require_once 'src/models/Season.php';
$seasonInstance = new Season();
$currentYear = $seasonInstance->getCurrentYear();
$currentSeason = $seasonInstance->getCurrentSeason();

// Fetch data for anime of the current season
$seasonApiUrl = "https://data.mediascout.tokyo/anime/season?year={$currentYear}&season={$currentSeason}";
$seasonJsonData = file_get_contents($seasonApiUrl);
$seasonResponse = json_decode($seasonJsonData, true);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime Showcase</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="/public/styles/home.css">
</head>
<body>
    
<?php
function renderCarousel($data, $title, $link, $className) {
    if (empty($data['data'])) return; // Không hiển thị nếu không có dữ liệu
    ?>
    <div class="<?php echo htmlspecialchars($className); ?> carousel-container" style="display: none;">
        <div class="section-header">
            <h2>
                <a href="<?php echo htmlspecialchars($link); ?>" class="category-link"><?php echo htmlspecialchars($title); ?></a>
            </h2>
        </div>
        <button class="arrow left-arrow" aria-label="Previous">&#10094;</button>
        <div class="carousel">
            <?php foreach ($data['data'] as $anime):
                $node = $anime['node']; ?>
                <div class="anime-item" data-id="<?php echo htmlspecialchars($node['id']); ?>">
                    <img src="<?php echo htmlspecialchars($node['main_picture']['medium']); ?>"
                         alt="<?php echo htmlspecialchars($node['title']); ?>"
                         class="anime-image">
                    <h3><?php echo htmlspecialchars($node['title']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="arrow right-arrow" aria-label="Next">&#10095;</button>
    </div>
    <?php
}
?>
<!-- Anime Carousel Section -->
<div class="anime-carousel">
    <?php include_once 'genreslist.php'; ?>
    <div class="anime-selection carousel-container">
        <div class="button-group">
            <button class="category-button" data-category="upcoming">Upcoming Animes</button>
            <button class="category-button" data-category="top-rated">Top Anime by Popularity</button>
            <button class="category-button" data-category="top-series">Top Anime Series</button>
            <button class="category-button" data-category="top-airing">Top Airing Anime</button>
            <button class="category-button" data-category="top-tv">Top Anime TV Series</button>
            <button class="category-button" data-category="top-ova">Top Anime OVA Series</button>
            <button class="category-button" data-category="top-movies">Top Anime Movies</button>
            <button class="category-button" data-category="top-special">Top Anime Specials</button>
            <button class="category-button" data-category="top-favorited">Top Favorited Anime</button>
        </div>
    </div>
    
    <!-- Render Sections Dynamically -->
    <?php
    renderCarousel($upcomingResponse, 'Upcoming Animes', '/Anime/Upcoming', 'upcoming-animes');
    renderCarousel($topRatedResponse, 'Top Anime by Popularity', '/Anime/TopRated', 'top-rated-animes');
    renderCarousel($topAiringResponse, 'Top Airing Animes', '/Anime/Airing', 'top-airing');
    renderCarousel($topOvaResponse, 'Top Anime OVA Series', '/Anime/Ova', 'top-ova');
    renderCarousel($topMovieResponse, 'Top Anime Movies', '/Anime/Movie', 'top-movie');
    renderCarousel($topFavoriteResponse, 'Top Favorited Animes', '/Anime/Favorited', 'top-favorited');
    renderCarousel($topSeriesResponse, 'Top Anime Series', '/Anime/Series', 'top-series');
    renderCarousel($topSpecialResponse, 'Top Anime Specials', '/Anime/Special', 'top-special');
    renderCarousel($topTVResponse, 'Top Animes TV Series', '/Anime/TV', 'top-tv');
    ?>
    <div class="anime-season carousel-container" style="display: none;">
        <div class="section-header">
        <h2>
           <a href="/anime/Seasonal" class="category-link">Anime Series in the <?php echo ucfirst($currentSeason); ?></a>
        </h2>
        </div>
        <button class="arrow left-arrow" aria-label="Previous">&#10094;</button>
        <div class="carousel">
            <?php foreach ($seasonResponse['data'] as $anime):
                $node = $anime['node']; ?>
                <div class="anime-item" data-id="<?php echo htmlspecialchars($node['id']); ?>">
                    <img src="<?php echo htmlspecialchars($node['main_picture']['medium']); ?>"
                         alt="<?php echo htmlspecialchars($node['title']); ?>"
                         class="anime-image">
                    <h3><?php echo htmlspecialchars($node ['title']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="arrow right-arrow" aria-label="Next">&#10095;</button>
    </div>
</div>


<!-- Link to JavaScript -->
<script src="/assets/scripts/getid.js"></script>
<script src="/assets/scripts/home.js"></script>
<script src="/assets/scripts/listhidden.js"></script>
</body>
</html>

