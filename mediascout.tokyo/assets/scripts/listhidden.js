document.addEventListener('DOMContentLoaded', () => {
    const categoryButtons = document.querySelectorAll('.category-button');
    const carousels = [
        { name: 'upcoming', element: document.querySelector('.upcoming-animes') },
        { name: 'top-rated', element: document.querySelector('.top-rated-animes') },
        { name: 'top-airing', element: document.querySelector('.top-airing') },
        { name: 'top-ova', element: document.querySelector('.top-ova') },
        { name: 'top-favorited', element: document.querySelector('.top-favorited') },
        { name: 'top-series', element: document.querySelector('.top-series') },
        { name: 'top-special', element: document.querySelector('.top-special') },
        { name: 'top-tv', element: document.querySelector('.top-tv') },
        { name: 'top-movie', element: document.querySelector('.top-movie') },
    ];
    const seasonCarousel = document.querySelector('.anime-season'); // Current season carousel

    // Log the carousels to check for null elements
    console.log(carousels);

    // Function to show the selected carousel
    const showCarousel = (selectedValue) => {
        carousels.forEach(({ name, element }) => {
            if (element) {
                element.style.display = name === selectedValue ? 'block' : 'none';
            } else {
                console.error(`Element for ${name} not found.`);
            }
        });
    };

 // Function to highlight the active button
    const highlightActiveButton = (activeButton) => {
        categoryButtons.forEach(button => button.classList.remove('active')); // Remove active class from all buttons
        activeButton.classList.add('active'); // Add active class to the clicked button
    };

    // Add event listeners to buttons
    categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
            const selectedValue = button.getAttribute('data-category');
            showCarousel(selectedValue);
            highlightActiveButton(button); // Highlight the clicked button
        });
    });

    // Show default carousel (Upcoming Animes) and always show Current Season
    showCarousel('upcoming'); // Show upcoming by default
    if (seasonCarousel) {
        seasonCarousel.style.display = 'block'; // Ensure Current Season is always displayed
    } else {
        console.error('Current season carousel not found.');
    }

    // Highlight the "Upcoming" button by default
    const upcomingButton = document.querySelector('.category-button[data-category="upcoming"]');
    if (upcomingButton) {
        highlightActiveButton(upcomingButton); // Highlight the upcoming button
    } else {
        console.error('Upcoming button not found.');
    }
});