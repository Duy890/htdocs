document.addEventListener("DOMContentLoaded", function () {
    const itemsPerPage = 10; // Number of anime per page
    let currentPage = 1; // Current page
    const totalItems = 500; // Limit on the total number of records that the API allows
    const totalPages = Math.ceil(totalItems / itemsPerPage); // Calculate total pages
    let currentCategory = 'upcoming'; // Default category

    // Get category and page from URL
    const params = new URLSearchParams(window.location.search);
    if (params.get('category')) currentCategory = params.get('category');
    if (params.get('page')) currentPage = parseInt(params.get('page'), 10);

    // Fetch anime recommendations and display them
    function fetchAnime(page) {
        if (page > totalPages || page < 1) {
            console.warn("No more pages to load.");
            return;
        }

        const offset = (page - 1) * itemsPerPage; // Calculate offset
        fetch(`https://data.mediascout.tokyo/anime/recommendations/${currentCategory}?limit=${itemsPerPage}&offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Error fetching data:', data.error);
                } else {
                    displayAnimeList(data);
                    createPagination(page);
                }
            })
            .catch(error => {
                console.error('Error fetching API:', error);
            });
    }

    // Function to display anime list
    function displayAnimeList(data) {
        const animeListContainer = document.querySelector('.anime-list');
        animeListContainer.innerHTML = ''; // Clear old content

        if (!data || !Array.isArray(data.data)) {
            console.error('Invalid data:', data.data);
            return;
        }

        // Iterate over anime items
        data.data.forEach(anime => {
            const animeImage = getImageSrc(anime);
            const animeTitle = anime.node.title || 'No Title Available';
            const animeId = anime.node.id;

            // Create anime item element
            const animeItem = document.createElement('div');
            animeItem.classList.add('anime-item');
            animeItem.innerHTML = `
                <a href="/anime/info/${animeId}">
                    <img src="${animeImage}" alt="${animeTitle}">
                </a>
                <h3>
                    <a href="/anime/info/${animeId}">${animeTitle}</a>
                </h3>
            `;
            animeListContainer.appendChild(animeItem);

            // Add click event to the image for navigation
            const animeImageElement = animeItem.querySelector('img');
            animeImageElement.addEventListener('click', function () {
                window.location.href = `/anime/info/${animeId}`;
            });
        });
    }

    // Define the getImageSrc function
    function getImageSrc(anime) {
        if (anime?.node?.main_picture?.large) {
            return anime.node.main_picture.large;
        }
        return 'assets/images/default-image.jpg'; // Default image if not available
    }

    // Function to create pagination buttons
    function createPagination(page) {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';

        // Previous button
        if (page > 1) {
            const prevButton = document.createElement('a');
            prevButton.innerText = 'Previous Page';
            prevButton.href = `?category=${currentCategory}&page=${page - 1}`;
            paginationContainer.appendChild(prevButton);
        }

        // Page buttons
        for (let i = Math.max(1, page - 1); i <= Math.min(totalPages, page + 2); i++) {
            const pageLink = document.createElement('a');
            pageLink.innerText = i;
            pageLink.href = `?category=${currentCategory}&page=${i}`;
            if (i === page) {
                pageLink.classList.add('active'); // Highlight current page
            }
            paginationContainer.appendChild(pageLink);
        }

        // Next button
        if (page < totalPages) {
            const nextButton = document.createElement('a');
            nextButton.innerText = 'Next Page';
            nextButton.href = `?category=${currentCategory}&page=${page + 1}`;
            paginationContainer.appendChild(nextButton);
        }
    }

    // Fetch anime for the first page or the one in URL
    fetchAnime(currentPage);
});
