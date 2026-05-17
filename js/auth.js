function validateRegister() {
    let name = document.getElementById('name').value.trim();
    let email = document.getElementById('email').value.trim();
    let password = document.getElementById('password').value;
    let address = document.getElementById('address').value.trim();
    let phone = document.getElementById('phone').value.trim();
    
    // Clear errors
    document.getElementById('nameError').innerText = '';
    document.getElementById('emailError').innerText = '';
    document.getElementById('passwordError').innerText = '';
    document.getElementById('addressError').innerText = '';
    document.getElementById('phoneError').innerText = '';
    
    let isValid = true;
    
    if(name === '') {
        document.getElementById('nameError').innerText = 'Name is required.';
        isValid = false;
    }
    if(email === '') {
        document.getElementById('emailError').innerText = 'Email is required.';
        isValid = false;
    }
    if(password.length < 8) {
        document.getElementById('passwordError').innerText = 'Password must be at least 8 characters long.';
        isValid = false;
    }
    if(address === '') {
        document.getElementById('addressError').innerText = 'Address is required.';
        isValid = false;
    }
    if(phone === '') {
        document.getElementById('phoneError').innerText = 'Phone is required.';
        isValid = false;
    }
    
    return isValid;
}

function validateLogin() {
    let email = document.getElementById('login_email').value.trim();
    let password = document.getElementById('login_password').value;
    
    document.getElementById('emailError').innerText = '';
    document.getElementById('passwordError').innerText = '';
    
    let isValid = true;
    
    if(email === '') {
        document.getElementById('emailError').innerText = 'Email is required.';
        isValid = false;
    }
    if(password === '') {
        document.getElementById('passwordError').innerText = 'Password is required.';
        isValid = false;
    }
    
    return isValid;
}