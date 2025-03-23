document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    const loginForm = document.getElementById('login-form');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const errorContainer = document.getElementById('error-messages');
    
    console.log('Login form:', loginForm);
    console.log('Email input:', emailInput);
    console.log('Password input:', passwordInput);
    console.log('Error container:', errorContainer);


    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            // Clear previous errors
            console.log('Form submit event triggered');
            errorContainer.innerHTML = '';
            
            let errors = [];
            console.log('Initial errors array:', errors);


            // Email validation
            if (!emailInput.value.trim()) {
                errors.push('Email is required');
            } else if (!validateEmail(emailInput.value.trim())) {
                errors.push('Please enter a valid email address');
            }

            // Password validation
            if (!passwordInput.value.trim()) {
                errors.push('Password is required');
            } else if (passwordInput.value.trim().length < 8) {
                errors.push('Password must be at least 8 characters');
            }

            // Display errors if any
            if (errors.length > 0) {
                console.log('Validation errors found:', errors);
                event.preventDefault();
                errors.forEach(error => {
                    const errorElement = document.createElement('div');
                    errorElement.className = 'alert alert-danger';
                    errorElement.textContent = error;
                    errorContainer.appendChild(errorElement);
                    console.log('Added error message:', error);
                });
            } else {
                console.log('No validation errors found');
            }

        });
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});
