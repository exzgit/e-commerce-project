document.addEventListener('DOMContentLoaded', (event) => {
    const scrollLeftBtn = document.getElementById('scrollLeftBtn');
    const scrollRightBtn = document.getElementById('scrollRightBtn');
    const container = document.getElementById('product-container');

    scrollLeftBtn.addEventListener('click', () => {
        container.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    scrollRightBtn.addEventListener('click', () => {
        container.scrollBy({
            left: 300, 
            behavior: 'smooth'
        });
    });
});

document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('password');
    const icon = this;
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});




document.getElementById('toggleNewPassword').addEventListener('click', function () {
    const passwordField = document.getElementById('newPassword');
    const icon = this;
    
    if (passwordField.type === 'newPassword') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'newPassword';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('toggleOldPassword').addEventListener('click', function () {
    const passwordField = document.getElementById('oldPassword');
    const icon = this;
    
    if (passwordField.type === 'oldPassword') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordField.type = 'oldPassword';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
