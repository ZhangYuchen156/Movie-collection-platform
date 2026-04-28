async function deleteMovie(id) {
    if (!confirm('Confirm delete?')) return;

    let formData = new FormData();
    formData.append('id', id);

    let res = await fetch('../delete-movie.php', {
        method: 'POST',
        body: formData
    });

    let data = await res.json();

    if (res.ok) {
        alert('Movie deleted successfully!');
        location.replace('movie-list.html');
    } else {
        alert(data.message);
    }
}