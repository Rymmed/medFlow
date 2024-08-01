// speciality selection
document.addEventListener('DOMContentLoaded', function () {
    const specialitySelect = document.getElementById('speciality');
    const choices = new Choices(specialitySelect, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Tapez pour séléctinner',
        itemSelectText: '',
        allowHTML: true,
    });
});
function showMessage(message, isSuccess) {
    const messageContainer = document.getElementById('message-container');
    const messageText = messageContainer.querySelector('.alert-text');

    messageText.textContent = message;
    messageContainer.classList.remove('alert-primary', 'alert-success');
    messageContainer.classList.add(isSuccess ? 'alert-success' : 'alert-primary');
    messageContainer.style.display = 'block';
}

function toggleIcon(id) {
    var chevronUpIcon = document.getElementById(id + "UpIcon");
    var chevronDownIcon = document.getElementById(id + "DownIcon");

    if (chevronUpIcon.style.display === "none") {
        chevronUpIcon.style.display = "inline";
        chevronDownIcon.style.display = "none";
    } else {
        chevronUpIcon.style.display = "none";
        chevronDownIcon.style.display = "inline";
    }
}
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


