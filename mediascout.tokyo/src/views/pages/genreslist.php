<div class="genre-list carousel-container">
    <button class="arrow left-arrow" aria-label="Previous" data-direction="left">&#10094;</button>
    <div class="carousel">
        <button class="genre-button" data-genre="1">Action</button>
        <button class="genre-button" data-genre="2">Adventure</button>
        <button class="genre-button" data-genre="5">Avant Garde</button>
        <button class="genre-button" data-genre="46">Award Winning</button>
        <button class="genre-button" data-genre="28">Boys Love</button>
        <button class="genre-button" data-genre="4">Comedy</button>
        <button class="genre-button" data-genre="8">Drama</button>
        <button class="genre-button" data-genre="10">Fantasy</button>
        <button class="genre-button" data-genre="26">Girls Love</button>
        <button class="genre-button" data-genre="47">Gourmet</button>
        <button class="genre-button" data-genre="14">Horror</button>
        <button class="genre-button" data-genre="7">Mystery</button>
        <button class="genre-button" data-genre="22">Romance</button>
        <button class="genre-button" data-genre="24">Sci-Fi</button>
        <button class="genre-button" data-genre="36">Slice of Life</button>
        <button class="genre-button" data-genre="30">Sports</button>
        <button class="genre-button" data-genre="37">Supernatural</button>
        <button class="genre-button" data-genre="41">Suspense</button>
    </div>
    <button class="arrow right-arrow" aria-label="Next" data-direction="right">&#10095;</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const genreButtons = document.querySelectorAll('.genre-button');

    genreButtons.forEach(button => {
        button.addEventListener('click', function() {
            const genreId = this.getAttribute('data-genre'); // Get the genre ID
            const url = `/anime/genre/?genres=${encodeURIComponent(genreId)}`;

            // Send a GET request to the PHP script
            window.location.href = url;
        });
    });
});
</script>