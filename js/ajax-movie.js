function loadMovies() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../movies.json', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            var movies = JSON.parse(xhr.responseText);
            var container = document.getElementById('movie-container');

            container.innerHTML = '';

            for (var i = 0; i < movies.length; i++) {
                var m = movies[i];
                var card = `
                <div class="card">
                    <h3>${m.title}</h3>
                    <p>Type: ${m.type}</p>
                    <p>Rating: ${m.rating}</p>
                    <a href="edit-movie.html" class="btn-small">Edit</a>
                    <a href="#" class="btn-small delete">Delete</a>
                </div>
                `;
                container.innerHTML += card;
            }
        }
    };
    xhr.send();
}

window.onload = loadMovies;