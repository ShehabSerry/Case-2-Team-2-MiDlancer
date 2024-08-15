document.addEventListener('DOMContentLoaded', (event) => {
    const openPopupBtn = document.getElementById('openPopupBtn');
    const popup = document.getElementById('popup');
    const closePopupBtn = document.getElementById('closePopupBtn');

    openPopupBtn.addEventListener('click', () => {
        popup.style.display = 'block';
    });

    closePopupBtn.addEventListener('click', () => {
        popup.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
});