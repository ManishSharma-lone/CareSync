function validateForm() {
    // 1. Setup - Clear previous error messages
    document.querySelectorAll(".text-danger").forEach(function (el) {
        el.textContent = "";
    });

    let isValid = true;

    // 2. Capture Values
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let mobile = document.getElementById("mobile").value.trim();
    let dob = document.getElementById("dob").value;
    let aadhar = document.getElementById("aadhar").value.trim();
    let blood = document.getElementById("blood").value;
    let city = document.getElementById("city").value.trim();
    let address = document.getElementById("address").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let gender = document.querySelector('input[name="gender"]:checked');

    // 3. Regex Patterns
    let nameRegex = /^[A-Za-z ]{3,}$/; // Min 3 letters
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let mobileRegex = /^[6-9][0-9]{9}$/; // Indian mobile standard
    let aadharRegex = /^[0-9]{12}$/;
    let cityRegex = /^[A-Za-z ]{2,}$/; // Letters and spaces, min 2

    // 4. Validation Logic

    // Name
    if (!nameRegex.test(name)) {
        document.getElementById("nameError").textContent = "Enter valid name (Letters only, min 3)";
        isValid = false;
    }

    // Email
    if (!emailRegex.test(email)) {
        document.getElementById("emailError").textContent = "Enter a valid email address";
        isValid = false;
    }

    // Mobile
    if (!mobileRegex.test(mobile)) {
        document.getElementById("mobileError").textContent = "Enter valid 10-digit mobile number";
        isValid = false;
    }

    // DOB
    if (dob === "") {
        document.getElementById("dobError").textContent = "Please select date of birth";
        isValid = false;
    }

    // Gender
    if (!gender) {
        document.getElementById("genderError").textContent = "Please select gender";
        isValid = false;
    }

    // Aadhar
    if (!aadharRegex.test(aadhar)) {
        document.getElementById("aadharError").textContent = "Enter valid 12-digit Aadhar number";
        isValid = false;
    }

    // Blood Group
    if (blood === "") {
        document.getElementById("bloodError").textContent = "Please select blood group";
        isValid = false;
    }

    // City Validation
    if (!cityRegex.test(city)) {
        document.getElementById("cityError").textContent = "Enter valid city name (Letters only)";
        isValid = false;
    }

    // Address Validation
    if (address.length < 10) {
        document.getElementById("addressError").textContent = "Please enter a full address (min 10 characters)";
        isValid = false;
    }

    // Password
    if (password.length < 6) {
        document.getElementById("passwordError").textContent = "Password must be at least 6 characters";
        isValid = false;
    }

    // Confirm Password
    if (password !== confirmPassword) {
        document.getElementById("confirmPasswordError").textContent = "Passwords do not match";
        isValid = false;
    }

    // 5. User Experience: Scroll to the first error found
    if (!isValid) {
        const firstError = document.querySelector(".text-danger:not(:empty)");
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    return isValid;
}