document.addEventListener("DOMContentLoaded", function() {
    const signUpForm = document.querySelector('form[action="signup_process.php"]');
    signUpForm.addEventListener('submit', function(event) {
        // Prevent form submission
        event.preventDefault();

        // Validate full name
        const fullNameInput = document.querySelector('input[name="name"]');
        const fullName = fullNameInput.value.trim();
        const fullNameRegex = /^[a-zA-Z]+\s[a-zA-Z]+$/; // Regex for full name with two names
        if (!fullNameRegex.test(fullName)) {
            alert("Please enter a valid full name with two names separated by a space.");
            return;
        }

        // Validate email
        const emailInput = document.querySelector('input[name="email"]');
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation regex
        if (!emailRegex.test(email)) {
            alert("Please enter a valid email address.");
            return;
        }

        // Validate password complexity
        const passwordInput = document.querySelector('input[name="password"]');
        const password = passwordInput.value;
        const passwordRegex = /^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/;
        if (!passwordRegex.test(password)) {
            alert("Password must contain at least 1 capital letter, 1 special character, 1 number, and be at least 8 characters long.");
            return;
        }

        // Validate confirm password
        const confirmPasswordInput = document.querySelector('input[name="confirm_password"]');
        const confirmPassword = confirmPasswordInput.value;
        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return;
        }

        // If all validations pass, submit the form
        signUpForm.submit();
    });
});
