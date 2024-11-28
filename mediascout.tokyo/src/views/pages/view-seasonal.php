<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Thêm Anime</title>
    <link rel="stylesheet" href="/public/styles/view-more-anime.css">
</head>
<body>
<div class="layout">
    <div class="body">
        <div class="container" id="contentContainer">
            <div class="anime-list-section">
                <!-- Dynamically change this title with JS -->
                <h2 id="animeTitle">BEST ANIME FOR </h2>
                <div class="search-bar">
                    <select id="season-select">
                     <option value="winter">Winter</option>
                     <option value="spring">Spring</option>
                     <option value="summer">Summer</option>
                     <option value="fall">Fall</option>
                    </select>
                    <input type="number" id="year-input" placeholder="Enter year" />
                    <button id="search-btn">Tìm</button>
                </div>
                <div class="anime-list"></div> <!-- This is where anime list will be injected -->
                <!-- Pagination Section -->
                <div id="pagination"></div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/scripts/viewmore(season).js"></script>
</body>
</html>
