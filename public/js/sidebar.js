// public/js/sidebar.js
document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('[data-collapse-toggle]');
    dropdowns.forEach((dropdown) => {
       const toggle = dropdown;
       const menuId = toggle.getAttribute('aria-controls');
       const menu = document.getElementById(menuId);
       
       toggle.addEventListener('click', function () {
          menu.classList.toggle('hidden');
       });
    });
 });