document.getElementById("registrationForm").addEventListener("submit", function(event) {

    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let roll = document.getElementById("roll").value.trim();
    let email = document.getElementById("email").value.trim();
    let course = document.getElementById("course").value;
    let password = document.getElementById("password").value;
    let file = document.getElementById("document").files[0];

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
            "Password needs 8 characters, uppercase, lowercase, number and special character";
        valid = false;
    }

    if (!file) {
        document.getElementById("fileError").textContent =
            "Please upload a document";
        valid = false;
    } else {
        let allowedTypes = [
            "application/pdf",
            "image/jpeg",
            "image/png"
        ];

        if (!allowedTypes.includes(file.type)) {
            document.getElementById("fileError").textContent =
                "Upload only PDF, JPG or PNG files";
            valid = false;
        }

        if (file.size > 2 * 1024 * 1024) {
            document.getElementById("fileError").textContent =
                "File size must not exceed 2 MB";
            valid = false;
        }
    }

    if (valid) {
        document.getElementById("successMessage").textContent =
            "Registration successful!";
    }

});document.getElementById("registrationForm").addEventListener("submit", function(event) {

    event.preventDefault();

    let name = document.getElementById("name").value.trim();
    let roll = document.getElementById("roll").value.trim();
    let email = document.getElementById("email").value.trim();
    let course = document.getElementById("course").value;
    let password = document.getElementById("password").value;
    let file = document.getElementById("document").files[0];

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
            "Password needs 8 characters, uppercase, lowercase, number and special character";
        valid = false;
    }

    if (!file) {
        document.getElementById("fileError").textContent =
            "Please upload a document";
        valid = false;
    } else {
        let allowedTypes = [
            "application/pdf",
            "image/jpeg",
            "image/png"
        ];

        if (!allowedTypes.includes(file.type)) {
            document.getElementById("fileError").textContent =
                "Upload only PDF, JPG or PNG files";
            valid = false;
        }

        if (file.size > 2 * 1024 * 1024) {
            document.getElementById("fileError").textContent =
                "File size must not exceed 2 MB";
            valid = false;
        }
    }

    if (valid) {
        document.getElementById("successMessage").textContent =
            "Registration successful!";
    }

});