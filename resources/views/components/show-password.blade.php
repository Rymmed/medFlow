<a type="button" class="btn-outline-secondary position-absolute end-0 top-50 translate-middle-y" onclick="togglePasswordVisibility('password')">
    <i class="fa fa-eye-slash me-2 text-xs" id="togglePasswordIcon"></i>
</a>
<script>
    function togglePasswordVisibility(fieldId) {
        var passwordField = document.getElementById(fieldId);
        var toggleIcon = document.querySelector(`#${fieldId} ~ a .fa`);

        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
</script>
