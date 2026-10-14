
document.getElementById("registrationForm").addEventListener("submit", function(event) {

    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let roll = document.getElementById("roll").value.trim();
    let email = document.getElementById("email").value.trim();
    let course = document.getElementById("course").value;
    let password = document.getElementById("password").value;

    let valid = true;

    document.querySelectorAll(".error").forEach(function(error) {
        error.textContent = "";
    });

    document.getElementById("successMessage").textContent = "";

    if (name === "") {
        document.getElementById("nameError").textContent =
            "Name is required";
        valid = false;
    }

    if (roll === "") {
        document.getElementById("rollError").textContent =
            "Roll number is required";
        valid = false;
    }

    let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
        document.getElementById("emailError").textContent =
            "Enter a valid email address";
        valid = false;
    }

    if (course === "") {
        document.getElementById("courseError").textContent =
            "Please select a course";
        valid = false;
    }

    let passwordPattern =
        /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$/;

    if (!passwordPattern.test(password)) {
        document.getElementById("passwordError").textContent =
            "Password must contain 8 characters, uppercase, lowercase, number and special character";
        valid = false;
    }

    if (valid) {
        document.getElementById("successMessage").textContent =
            "Registration successful!";
    }

});

