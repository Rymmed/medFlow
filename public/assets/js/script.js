function showMessage(message, isSuccess) {
    const messageContainer = document.getElementById('message-container');
    const messageText = messageContainer.querySelector('.alert-text');

    messageText.textContent = message;
    messageContainer.classList.remove('alert-primary', 'alert-success');
    messageContainer.classList.add(isSuccess ? 'alert-success' : 'alert-primary');
    messageContainer.style.display = 'block';
}

// Minimize Sidebar
document.addEventListener("DOMContentLoaded", function () {
    let activeTabId = localStorage.getItem('activeTabId');

    if (activeTabId) {
        let activeTab = document.getElementById(activeTabId);
        if (activeTab) {
            let tabInstance = new bootstrap.Tab(activeTab);
            tabInstance.show();
        }
    }
    let tabs = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabs.forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function (event) {
            localStorage.setItem('activeTabId', event.target.id);
        });
    });

    const specialitySelect = document.getElementById('speciality');
    const choices = new Choices(specialitySelect, {
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Tapez pour séléctinner',
        itemSelectText: '',
        allowHTML: true,
    });
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


