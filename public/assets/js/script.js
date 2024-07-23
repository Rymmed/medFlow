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

