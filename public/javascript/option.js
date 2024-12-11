document.addEventListener('DOMContentLoaded', function() {
    const userLogoutButton = document.querySelector('.user-logout-button');
    const popupWindow = document.querySelector('.popup-window');
    const closeBtn = document.querySelector('.close-btn');

    userLogoutButton.addEventListener('click', function() {
        popupWindow.classList.toggle('show-popup');
    });

    closeBtn.addEventListener('click', function() {
        popupWindow.classList.remove('show-popup');
    });

    window.addEventListener('click', function(event) {
        if (event.target === popupWindow) {
            popupWindow.classList.remove('show-popup');
        }
    });
});
