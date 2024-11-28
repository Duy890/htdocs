document.addEventListener('DOMContentLoaded', function() {
    const animeItems = document.querySelectorAll('.anime-item');

    animeItems.forEach(item => {
        item.addEventListener('click', function() {
            const animeId = this.getAttribute('data-id');
            const animeTitle = this.getAttribute('data-title');
            const animeImage = this.querySelector('.anime-image').src;

            // Vô hiệu hóa click để tránh nhiều yêu cầu
            this.style.pointerEvents = 'none';

            saveAnimeHistory(animeId, animeTitle, animeImage)
                .then(() => {
                    // Chuyển hướng sau khi lưu thành công
                    window.location.href = `/anime/info/${animeId}`;
                })
                .catch(error => {
                    console.error("Error saving anime history: ", error);
                    // Bật lại sự kiện click nếu có lỗi
                    this.style.pointerEvents = 'auto';
                });
        });
    });

    function saveAnimeHistory(id, title, image) {
        return fetch('src/models/savehistory.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ animeId: id, animeTitle: title, animeImage: image }),
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.message);
            }
            console.log("Anime saved to history.");
        });
    }
});