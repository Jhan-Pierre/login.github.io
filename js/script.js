document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const showPasswordBtn = document.getElementById("showPasswordBtn");
    
    showPasswordBtn.addEventListener("click", function () {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            passwordInput.type = "password";
            showPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
        }
    });    
});
