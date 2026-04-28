const urlParams = new URLSearchParams(window.location.search);
const movieId = urlParams.get('id');

if (!movieId) {
    alert('❌ No movie ID!');
    window.location.href = "movie-list.html";
}

fetch("../get_movie_detail.php?id=" + movieId)
.then(res => res.json())
.then(movie => {
    if (movie.success) {
        document.getElementById('movieId').value = movie.data.movie_id;
        document.getElementById('title').value = movie.data.title;
        document.getElementById('type').value = movie.data.type;
        document.getElementById('rating').value = movie.data.rating;
    } else {
        alert('❌ ' + movie.message);
    }
})
.catch(e => {
    alert("❌ Network error! 请检查PHP是否正常运行");
    console.log(e);
});

document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    fetch("../update_movie.php", {
        method: "POST",
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("✅ 修改成功！");
            location.href = "movie-list.html";
        } else {
            alert("❌ " + data.message);
        }
    });
});