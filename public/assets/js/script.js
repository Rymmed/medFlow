// speciality selection
document.addEventListener('DOMContentLoaded', function () {
    const specialitySelect = document.getElementById('speciality');
    const choices = new Choices(specialitySelect, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Sélectionnez des spécialités',
        itemSelectText: 'Appuyer pour séléctionner',
        allowHTML: true,
    });
});

// Minimize Sidebar
document.addEventListener("DOMContentLoaded", function () {
    var logoImg = document.getElementById("logo-img");
    var minimizedLogoImg = document.getElementById("minimized-img");
    var toggleLeftButton = document.getElementById("toggleLeftButton");
    var toggleRightButton = document.getElementById("toggleRightButton");
    var sidenav = document.getElementById("sidenav-main");
    var mainContent = document.getElementById("main-content");

    toggleLeftButton.addEventListener("click", function () {
        sidenav.classList.toggle("collapsed");
        mainContent.classList.add("expanded");
        logoImg.style.display = "none";
        minimizedLogoImg.style.display = "block";
        toggleRightButton.style.display = "block";
        toggleLeftButton.style.display = "none";
    });
    toggleRightButton.addEventListener("click", function () {
        sidenav.classList.remove("collapsed");
        mainContent.classList.remove("expanded");
        logoImg.style.display = "block";
        minimizedLogoImg.style.display = "none";
        toggleLeftButton.style.display = "block";
        toggleRightButton.style.display = "none";
    });
});

