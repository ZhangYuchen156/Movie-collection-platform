document.getElementById('registerForm').addEventListener('submit', function (e) {
    var user = document.querySelector('input[name="username"]').value;
    var pwd = document.querySelector('input[name="password"]').value;
    var repwd = document.querySelector('input[name="repassword"]').value;
    if (user == '' || pwd == '' || repwd == '') {
        alert('Cannot be empty');
        e.preventDefault();
        return;
    }
    if (pwd != repwd) {
        alert('Passwords do not match');
        e.preventDefault();
    }
    if (pwd.length < 6) {
        alert('Password at least 6 characters');
        e.preventDefault();
    }
});