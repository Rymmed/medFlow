@props(['id'])

<i class="fa fa-light fa-minus text-xs position-absolute end-0 me-3" aria-hidden="true" id="{{ $id }}UpIcon"></i>
<i class="fa fa-light fa-plus text-xs position-absolute end-0 me-3" aria-hidden="true" id="{{ $id }}DownIcon" style="display: none;"></i>

<script>
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
</script>
