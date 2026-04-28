document.getElementById('registerForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    let username = document.querySelector('input[name="username"]').value;
    let password = document.querySelector('input[name="password"]').value;
    let confirm_password = document.querySelector('input[name="confirm_password"]').value;

    if (!username || !password || !confirm_password) {
        alert('All fields are required');
        return;
    }

    if (password !== confirm_password) {
        alert('Passwords do not match');
        return;
    }

    let formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    formData.append('confirm_password', confirm_password);

    try {
        let res = await fetch('../register.php', {
            method: 'POST',
            body: formData
        });

        let text = await res.text(); 

        if (res.ok) {
            alert('Registration successful!');
            location.replace('login.html');
        } else {
            alert('Registration failed');
        }
    } catch (err) {
        alert('Error: ' + err.message);
    }
});