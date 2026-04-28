document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('../login.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Login successful!');
            window.location.href = "/teamwork/index.php";
        } else {
            alert(data.message || '❌ Login failed!');
        }
    })
    .catch(() => {
        alert('❌ Network error!');
    });
});