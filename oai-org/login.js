document.addEventListener('DOMContentLoaded', () => {
    const loginView = document.getElementById('login-view');
    const registerView = document.getElementById('register-view');
    const toggleLinkArea = document.getElementById('toggle-link-area');
    
    let currentView = 'login';

    function updateView() {
        if (currentView === 'login') {
            loginView.style.display = 'block';
            registerView.style.display = 'none';
            toggleLinkArea.innerHTML = 'Belum punya akun? <a href="#" id="show-register">Daftar di sini</a>';
        } else { 
            loginView.style.display = 'none';
            registerView.style.display = 'block';
            toggleLinkArea.innerHTML = 'Sudah punya akun? <a href="#" id="show-login">Login di sini</a>';
        }
        addToggleListeners();
    }

    function addToggleListeners() {
        const showRegisterLink = document.getElementById('show-register');
        const showLoginLink = document.getElementById('show-login');

        if (showRegisterLink) {
            showRegisterLink.addEventListener('click', (e) => {
                e.preventDefault();
                currentView = 'register';
                updateView();
            });
        }
        if (showLoginLink) {
            showLoginLink.addEventListener('click', (e) => {
                e.preventDefault();
                currentView = 'login';
                updateView();
            });
        }
    }
    updateView();
});