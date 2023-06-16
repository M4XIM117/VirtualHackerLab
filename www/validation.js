document.addEventListener('DOMContentLoaded', function() {
    var nameInput = document.getElementById('name');
    var emailInput = document.getElementById('email');
    var passwordInput = document.getElementById('password');
    var confirmPasswordInput = document.getElementById('confirmPassword');
  
    nameInput.addEventListener('blur', function() {
      validateField(nameInput, 'name-error', 'Der Name darf nur aus Buchstaben und Zahlen bestehen.');
      validateField(nameInput, 'name-error2', 'Der Name darf nicht länger als 15 Zeichen sein.');
    });
  
    emailInput.addEventListener('blur', function() {
      validateField(emailInput, 'email-error', 'Die E-Mail-Adresse muss ein @ enthalten.');
      validateField(emailInput, 'email-error2', 'Die E-Mail-Adresse darf nur mit .com oder .de enden.');
    });
  
    passwordInput.addEventListener('blur', function() {
      validateField(passwordInput, 'password-error', 'Das Passwort muss mindestens eine Ziffer enthalten.');
      validateField(passwordInput, 'password-error2', 'Das Passwort muss mindestens ein Sonderzeichen enthalten.');
      validateField(passwordInput, 'password-error3', 'Das Passwort muss mindestens 8 Zeichen lang sein.');
      validateField(passwordInput, 'password-error4', 'Das Passwort muss aus Groß- und Kleinbuchstaben bestehen.');
    });
  
    confirmPasswordInput.addEventListener('blur', function() {
      validateField(confirmPasswordInput, 'confirmPassword-error', 'Die Passwörter stimmen nicht überein.');
    });
  
    function validateField(input, errorId, errorMessage) {
      var errorElement = document.getElementById(errorId);
      errorElement.textContent = '';
  
      if (input.value.trim() === '') {
        errorElement.textContent = errorMessage;
      }
    }
  });
  
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById('password');
    var showPasswordBtn = document.getElementById('showPasswordBtn');
  
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      showPasswordBtn.textContent = 'Verbergen';
  
      setTimeout(function() {
        passwordInput.type = 'password';
        showPasswordBtn.textContent = 'Anzeigen';
      }, 5000); // Das Passwort nach 5 Sekunden wieder verbergen
    } else {
      passwordInput.type = 'password';
      showPasswordBtn.textContent = 'Anzeigen';
    }
  }

  function displayError(errors, fieldName) {
    if (errors[fieldName]) {
      var errorElement = document.createElement("span");
      errorElement.classList.add("error");
      errorElement.innerHTML = errors[fieldName];
      var inputElement = document.getElementById(fieldName);
      inputElement.classList.add("error-input");
      inputElement.parentNode.insertBefore(errorElement, inputElement.nextSibling);
    }
  }
  
  