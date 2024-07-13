// navbar dropdown menu
var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
    return new bootstrap.Dropdown(dropdownToggleEl)
})

// Collapsed Sidebar
document.addEventListener("DOMContentLoaded", function () {
    var logoImg = document.getElementById("logo-img");
    var minimizedLogoImg = document.getElementById("minimized-img");
    var toggleLeftButton = document.getElementById("toggleLeftButton");
    var toggleRightButton = document.getElementById("toggleRightButton");
    var sidenav = document.getElementById("sidenav-main");
    var mainContent = document.getElementById("main-content");

    toggleLeftButton.addEventListener("click", function () {
        sidenav.classList.toggle("collapsed");
        mainContent.classList.toggle("expanded");
        logoImg.style.display = "none";
        minimizedLogoImg.style.display = "block";
        toggleRightButton.style.display = "block";
        toggleLeftButton.style.display = "none";
    });
    toggleRightButton.addEventListener("click", function () {
        logoImg.style.display = "block";
        minimizedLogoImg.style.display = "none";
        toggleLeftButton.style.display = "block";
        toggleRightButton.style.display = "none";
        sidenav.classList.remove("collapsed");
        mainContent.classList.remove("expanded");
    });
});

