document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        const validators = {
            customer_name: [
                (value) => value.trim().length >= 2 && value.trim().length <= 100,
                'Enter a name between 2 and 100 characters.'
            ],
            customer_email: [
                (value) => value.length <= 50 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim()),
                'Enter a valid email address (maximum 50 characters).'
            ],
            customer_pass: [
                (value) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{8,}$/.test(value),
                'Use at least 8 characters and include uppercase and lowercase letters, a number, and a special character.'
            ],
            customer_country: [(value) => value !== '', 'Select a country.'],
            customer_city: [
                (value) => value.trim().length > 0 && value.trim().length <= 30,
                'Enter a city (maximum 30 characters).'
            ],
            customer_contact: [
                (value) => /^[0-9+\-\s]{7,15}$/.test(value.trim()),
                'Enter 7–15 digits, spaces, +, or -.'
            ]
        };
        let firstInvalidField = null;

        Object.entries(validators).forEach(([name, [isValid, message]]) => {
            const field = form.elements.namedItem(name);
            const error = form.querySelector(`[data-error-for="${name}"]`);
            const valid = isValid(field.value);

            field.setAttribute('aria-invalid', String(!valid));
            error.textContent = valid ? '' : message;

            if (!valid && !firstInvalidField) firstInvalidField = field;
        });

        if (firstInvalidField) {
            e.preventDefault();
            firstInvalidField.focus();
            return;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = submitBtn.textContent;
            submitBtn.textContent = 'Registering…';
        }
    });
});
