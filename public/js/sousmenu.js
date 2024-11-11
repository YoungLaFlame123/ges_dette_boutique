document.addEventListener('click', function(event) {
    const button = document.getElementById('menu-button');
    const menu = button.nextElementSibling;

    if (button.contains(event.target)) {
        menu.classList.toggle('hidden');
    } else {
        menu.classList.add('hidden');
    }
});
