document.addEventListener('DOMContentLoaded', function () {
    // Danh sách các carousel và các mũi tên tương ứng
    const carousels = [
        { selector: '.upcoming-animes', scrollAmount: 0 },
        { selector: '.top-rated-animes', scrollAmount: 0 },
        { selector: '.top-airing', scrollAmount: 0 },
        { selector: '.top-ova', scrollAmount: 0 },
        { selector: '.top-movie', scrollAmount: 0 },
        { selector: '.top-favorited', scrollAmount: 0 },
        { selector: '.top-series', scrollAmount: 0 },
        { selector: '.top-special', scrollAmount: 0 },
        { selector: '.top-tv', scrollAmount: 0 },
        { selector: '.anime-season', scrollAmount: 0 },
        { selector: '.genre-list', scrollAmount: 0 },
    ];

    // Hàm cuộn carousel
    function scrollCarousel(carousel, direction, scrollAmount) {
        const scrollStep = 200; // Cuộn mỗi lần 200px
        const maxScroll = carousel.scrollWidth - carousel.offsetWidth;

        if (direction === 'left') {
            scrollAmount -= scrollStep;
            if (scrollAmount < 0) scrollAmount = maxScroll; // Reset về cuối
        } else if (direction === 'right') {
            scrollAmount += scrollStep;
            if (scrollAmount > maxScroll) scrollAmount = 0; // Reset về đầu
        }

        carousel.style.transform = `translateX(-${scrollAmount}px)`;
        return scrollAmount;
    }

    // Hàm khởi tạo sự kiện cho từng carousel
    function initCarousel(carouselItem) {
        const carousel = document.querySelector(`${carouselItem.selector} .carousel`);
        const leftArrow = document.querySelector(`${carouselItem.selector} .left-arrow`);
        const rightArrow = document.querySelector(`${carouselItem.selector} .right-arrow`);

        if (carousel && leftArrow && rightArrow) {
            leftArrow.addEventListener('click', () => {
                carouselItem.scrollAmount = scrollCarousel(carousel, 'left', carouselItem.scrollAmount);
            });

            rightArrow.addEventListener('click', () => {
                carouselItem.scrollAmount = scrollCarousel(carousel, 'right', carouselItem.scrollAmount);
            });
        }
    }

    // Khởi tạo tất cả các carousel
    carousels.forEach(initCarousel);

    // Optional: Auto-scroll tất cả các carousel
    setInterval(() => {
        carousels.forEach(item => {
            const carousel = document.querySelector(`${item.selector} .carousel`);
            if (carousel) {
                item.scrollAmount = scrollCarousel(carousel, 'right', item.scrollAmount);
            }
        });
    }, 3000); // Thời gian tự động cuộn
});
