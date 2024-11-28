// Đảm bảo file genre-search.js được liên kết đúng vào trang HTML

// Hàm gọi API để lấy danh sách anime theo thể loại


// Hàm hiển thị danh sách anime
function displayAnimeList(animeList) {
    const container = document.querySelector('.anime-results');
    container.innerHTML = ''; // Xóa nội dung cũ

    if (!animeList || animeList.length === 0) {
        container.innerHTML = '<p>No results found for this genre.</p>';
        return;
    }

    animeList.forEach((anime) => {
        const animeItem = document.createElement('div');
        animeItem.className = 'anime-item';

        animeItem.innerHTML = `
            <a href="/anime/info/${anime.id}" class="anime-link">
                <img src="${anime.main_picture?.medium || '/public/images/default-anime.png'}" alt="${anime.title}" class="anime-image">
                <h3 class="anime-title">${anime.title}</h3>
            </a>
        `;
        container.appendChild(animeItem);
    });
}

// Thêm sự kiện click vào các nút thể loại
document.querySelectorAll('.genre-button').forEach((button) => {
    button.addEventListener('click', async () => {
        const genreId = button.getAttribute('data-genre'); // Lấy ID thể loại từ data-genre
        const animeData = await fetchAnimeByGenre(genreId); // Gọi API

        if (animeData && animeData.data) {
            displayAnimeList(animeData.data); // Hiển thị danh sách anime
        } else {
            console.error('No anime data found.');
        }
    });
});
