/**
 * ===================================
 * SI-MAGANG - Form Validation Component
 * ===================================
 */

export class FormValidator {
    constructor(form, options = {}) {
        this.form = form;
        this.options = {
            validateOnBlur: true,
            validateOnInput: true,
            showSuccessState: true,
            realTimeValidation: true,
            ...options
        };
        
        this.rules = {};
        this.errors = {};
        this.isValid = false;
        
        this.init();
    }
    
    init() {
        this.parseRules();
        this.setupEventListeners();
        this.setupSubmitHandler();
    }
    
    parseRules() {
        const fields = this.form.querySelectorAll('input, select, textarea');
        
        fields.forEach(field => {
            const rules = [];
            
            // Required validation
            if (field.hasAttribute('required')) {
                rules.push('required');
            }
            
            // Type-based validation
            if (field.type === 'email') {
                rules.push('email');
            }
            
            if (field.type === 'url') {
                rules.push('url');
            }
            
            if (field.type === 'number') {
                rules.push('numeric');
            }
            
            // Length validation
            if (field.minLength) {
                rules.push(`min:${field.minLength}`);
            }
            
            if (field.maxLength) {
                rules.push(`max:${field.maxLength}`);
            }
            
            // Pattern validation
            if (field.pattern) {
                rules.push(`pattern:${field.pattern}`);
            }
            
            // Custom rules from data attribute
            if (field.dataset.rules) {
                rules.push(...field.dataset.rules.split('|'));
            }
            
            if (rules.length > 0) {
                this.rules[field.name] = rules;
            }
        });
    }
    
    setupEventListeners() {
        const fields = this.form.querySelectorAll('input, select, textarea');
        
        fields.forEach(field => {
            if (this.options.validateOnBlur) {
                field.addEventListener('blur', () => {
                    this.validateField(field);
                });
            }
            
            if (this.options.validateOnInput && this.options.realTimeValidation) {
                field.addEventListener('input', this.debounce(() => {
                    if (field.classList.contains('is-invalid') || field.classList.contains('is-valid')) {
                        this.validateField(field);
                    }
                }, 300));
            }
            
            // Special handling for password confirmation
            if (field.name === 'password_confirmation') {
                field.addEventListener('input', () => {
                    this.validatePasswordConfirmation(field);
                });
            }
            
            // Special handling for NIM (only numbers)
            if (field.name === 'nim') {
                field.addEventListener('input', () => {
                    field.value = field.value.replace(/[^0-9]/g, '');
                });
            }
        });
    }
    
    setupSubmitHandler() {
        this.form.addEventListener('submit', (e) => {
            if (!this.validateForm()) {
                e.preventDefault();
                e.stopPropagation();
                
                // Focus on first invalid field
                const firstInvalid = this.form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                this.showFormErrors();
            } else {
                // Show loading state on submit button
                const submitBtn = this.form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    this.setButtonLoading(submitBtn, true);
                }
            }
        });
    }
    
    validateField(field) {
        const fieldName = field.name;
        const rules = this.rules[fieldName];
        
        if (!rules) return true;
        
        const errors = [];
        const value = field.value.trim();
        
        for (const rule of rules) {
            const error = this.applyRule(field, rule, value);
            if (error) {
                errors.push(error);
                break; // Stop at first error
            }
        }
        
        this.updateFieldState(field, errors);
        
        if (errors.length > 0) {
            this.errors[fieldName] = errors;
            return false;
        } else {
            delete this.errors[fieldName];
            return true;
        }
    }
    
    applyRule(field, rule, value) {
        const [ruleName, ruleValue] = rule.split(':');
        
        switch (ruleName) {
            case 'required':
                if (!value) {
                    return this.getErrorMessage(field, 'required');
                }
                break;
                
            case 'email':
                if (value && !this.isValidEmail(value)) {
                    return this.getErrorMessage(field, 'email');
                }
                break;
                
            case 'url':
                if (value && !this.isValidUrl(value)) {
                    return this.getErrorMessage(field, 'url');
                }
                break;
                
            case 'numeric':
                if (value && !this.isNumeric(value)) {
                    return this.getErrorMessage(field, 'numeric');
                }
                break;
                
            case 'min':
                if (value && value.length < parseInt(ruleValue)) {
                    return this.getErrorMessage(field, 'min', { min: ruleValue });
                }
                break;
                
            case 'max':
                if (value && value.length > parseInt(ruleValue)) {
                    return this.getErrorMessage(field, 'max', { max: ruleValue });
                }
                break;
                
            case 'pattern':
                if (value && !new RegExp(ruleValue).test(value)) {
                    return this.getErrorMessage(field, 'pattern');
                }
                break;
                
            case 'nim':
                if (value && !this.isValidNIM(value)) {
                    return this.getErrorMessage(field, 'nim');
                }
                break;
                
            case 'phone':
                if (value && !this.isValidPhone(value)) {
                    return this.getErrorMessage(field, 'phone');
                }
                break;
                
            case 'confirmed':
                const confirmField = this.form.querySelector(`input[name="${field.name}_confirmation"]`);
                if (confirmField && value !== confirmField.value) {
                    return this.getErrorMessage(field, 'confirmed');
                }
                break;
        }
        
        return null;
    }
    
    validatePasswordConfirmation(field) {
        const passwordField = this.form.querySelector('input[name="password"]');
        if (!passwordField) return;
        
        const isValid = field.value === passwordField.value;
        const errors = isValid ? [] : [this.getErrorMessage(field, 'confirmed')];
        
        this.updateFieldState(field, errors);
        
        if (errors.length > 0) {
            this.errors[field.name] = errors;
        } else {
            delete this.errors[field.name];
        }
    }
    
    updateFieldState(field, errors) {
        const hasErrors = errors.length > 0;
        
        // Update field classes
        if (hasErrors) {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        } else if (this.options.showSuccessState && field.value.trim()) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-invalid', 'is-valid');
        }
        
        // Update error message
        this.updateErrorMessage(field, errors[0] || '');
    }
    
    updateErrorMessage(field, message) {
        let feedback = field.parentNode.querySelector('.invalid-feedback');
        
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback';
            
            // Insert after field or input group
            const inputGroup = field.closest('.input-group');
            const insertAfter = inputGroup || field;
            insertAfter.parentNode.insertBefore(feedback, insertAfter.nextSibling);
        }
        
        feedback.innerHTML = message ? `<i class="fas fa-exclamation-circle me-1"></i>${message}` : '';
    }
    
    validateForm() {
        const fields = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;
        
        fields.forEach(field => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        
        // Additional form-level validations
        if (!this.validateTermsAgreement()) {
            isValid = false;
        }
        
        this.isValid = isValid;
        return isValid;
    }
    
    validateTermsAgreement() {
        const termsCheckbox = this.form.querySelector('input[name="terms"]');
        if (!termsCheckbox) return true;
        
        if (!termsCheckbox.checked) {
            this.updateFieldState(termsCheckbox, ['Anda harus menyetujui syarat dan ketentuan']);
            return false;
        }
        
        this.updateFieldState(termsCheckbox, []);
        return true;
    }
    
    showFormErrors() {
        const errorCount = Object.keys(this.errors).length;
        if (errorCount > 0) {
            this.showNotification(
                `Terdapat ${errorCount} kesalahan pada form. Mohon periksa kembali.`,
                'error'
            );
        }
    }
    
    // Validation helper methods
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    isValidUrl(url) {
        try {
            new URL(url);
            return true;
        } catch {
            return false;
        }
    }
    
    isNumeric(value) {
        return !isNaN(value) && !isNaN(parseFloat(value));
    }
    
    isValidNIM(nim) {
        // NIM should be 8-15 digits
        const nimRegex = /^[0-9]{8,15}$/;
        return nimRegex.test(nim);
    }
    
    isValidPhone(phone) {
        // Indonesian phone number format
        const phoneRegex = /^(\+62|62|0)[0-9]{8,13}$/;
        return phoneRegex.test(phone.replace(/[\s-]/g, ''));
    }
    
    getErrorMessage(field, rule, params = {}) {
        const fieldLabel = this.getFieldLabel(field);
        
        const messages = {
            required: `${fieldLabel} wajib diisi`,
            email: `${fieldLabel} harus berupa email yang valid`,
            url: `${fieldLabel} harus berupa URL yang valid`,
            numeric: `${fieldLabel} harus berupa angka`,
            min: `${fieldLabel} minimal ${params.min} karakter`,
            max: `${fieldLabel} maksimal ${params.max} karakter`,
            pattern: `Format ${fieldLabel} tidak valid`,
            nim: `${fieldLabel} harus berupa angka 8-15 digit`,
            phone: `${fieldLabel} harus berupa nomor telepon yang valid`,
            confirmed: `Konfirmasi ${fieldLabel} tidak sama`
        };
        
        return messages[rule] || `${fieldLabel} tidak valid`;
    }
    
    getFieldLabel(field) {
        // Try to get label from associated label element
        const label = this.form.querySelector(`label[for="${field.id}"]`);
        if (label) {
            return label.textContent.replace('*', '').trim();
        }
        
        // Try to get from placeholder
        if (field.placeholder) {
            return field.placeholder;
        }
        
        // Fallback to field name
        return field.name.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    }
    
    // Utility methods
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    setButtonLoading(button, loading) {
        if (loading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || button.innerHTML;
        }
    }
    
    showNotification(message, type = 'info') {
        if (window.SIMagang && window.SIMagang.utils.showNotification) {
            window.SIMagang.utils.showNotification(message, type);
        } else {
            alert(message);
        }
    }
    
    // Public methods
    reset() {
        this.form.reset();
        this.errors = {};
        this.isValid = false;
        
        // Clear validation states
        const fields = this.form.querySelectorAll('input, select, textarea');
        fields.forEach(field => {
            field.classList.remove('is-valid', 'is-invalid');
        });
        
        // Clear error messages
        const feedbacks = this.form.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => {
            feedback.innerHTML = '';
        });
    }
    
    getErrors() {
        return this.errors;
    }
    
    hasErrors() {
        return Object.keys(this.errors).length > 0;
    }
    
    setFieldError(fieldName, message) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            this.updateFieldState(field, [message]);
            this.errors[fieldName] = [message];
        }
    }
    
    clearFieldError(fieldName) {
        const field = this.form.querySelector(`[name="${fieldName}"]`);
        if (field) {
            this.updateFieldState(field, []);
            delete this.errors[fieldName];
        }
    }
    
    destroy() {
        // Clean up event listeners
        this.errors = {};
        this.rules = {};
        console.log('FormValidator destroyed');
    }
}

// Auto-initialize form validation
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        const options = {};
        
        // Parse options from data attributes
        if (form.dataset.validateOnBlur === 'false') options.validateOnBlur = false;
        if (form.dataset.validateOnInput === 'false') options.validateOnInput = false;
        if (form.dataset.showSuccessState === 'false') options.showSuccessState = false;
        if (form.dataset.realTimeValidation === 'false') options.realTimeValidation = false;
        
        // Initialize FormValidator
        new FormValidator(form, options);
    });
});

export default FormValidator;