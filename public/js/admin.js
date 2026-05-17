function showFieldError(input, message){
    let error = null;
    let next = input.nextElementSibling;

    while(next){
        if(next.classList && next.classList.contains('field-error')){
            error = next;
            break;
        }

        next = next.nextElementSibling;
    }

    if(!error){
        error = input.parentElement.querySelector('.field-error');
    }

    if(error){
        error.innerHTML = message;
    }
}

function clearFormErrors(form){
    let errors = form.querySelectorAll('.field-error');

    for(let i = 0; i < errors.length; i++){
        errors[i].innerHTML = "";
    }
}

function validateCategoryForm(form){
    clearFormErrors(form);

    let name = form.querySelector('[name="name"]');
    let type = form.querySelector('[name="category_type"]');
    let valid = true;

    if(name.value.trim() == ""){
        showFieldError(name, "Category name is required");
        valid = false;
    }

    if(type.value == ""){
        showFieldError(type, "Category type is required");
        valid = false;
    }

    return valid;
}

function validateMedicineForm(form){
    clearFormErrors(form);

    let valid = true;
    let name = form.querySelector('[name="name"]');
    let category = form.querySelector('[name="category_id"]');
    let vendor = form.querySelector('[name="vendor_name"]');
    let price = form.querySelector('[name="price"]');
    let stock = form.querySelector('[name="availability"]');
    let image = form.querySelector('[name="image"]');

    if(name.value.trim() == ""){
        showFieldError(name, "Medicine name is required");
        valid = false;
    }

    if(category.value == ""){
        showFieldError(category, "Category is required");
        valid = false;
    }

    if(vendor.value.trim() == ""){
        showFieldError(vendor, "Vendor name is required");
        valid = false;
    }

    if(price.value == "" || Number(price.value) <= 0){
        showFieldError(price, "Price must be greater than zero");
        valid = false;
    }

    if(stock.value == "" || Number(stock.value) < 0 || !Number.isInteger(Number(stock.value))){
        showFieldError(stock, "Stock must be a positive integer");
        valid = false;
    }

    if(image && form.getAttribute('data-image-required') == '1' && image.files.length == 0){
        showFieldError(image, "Medicine image is required");
        valid = false;
    }

    if(image && image.files.length > 0){
        let file = image.files[0];
        let allowed = ['image/jpeg', 'image/png'];

        if(!allowed.includes(file.type)){
            showFieldError(image, "Only JPEG or PNG image allowed");
            valid = false;
        }

        if(file.size > 2 * 1024 * 1024){
            showFieldError(image, "Image must be 2MB or less");
            valid = false;
        }
    }

    return valid;
}

function validateLoginForm(form){
    clearFormErrors(form);

    let email = form.querySelector('[name="email"]');
    let password = form.querySelector('[name="password"]');
    let valid = true;

    if(email.value.trim() == ""){
        showFieldError(email, "Email is required");
        valid = false;
    }

    if(password.value == ""){
        showFieldError(password, "Password is required");
        valid = false;
    }

    return valid;
}

let categoryForms = document.querySelectorAll('.validate-category');
for(let i = 0; i < categoryForms.length; i++){
    categoryForms[i].addEventListener('submit', function(event){
        if(!validateCategoryForm(this)){
            event.preventDefault();
        }
    });
}

let medicineForms = document.querySelectorAll('.validate-medicine');
for(let i = 0; i < medicineForms.length; i++){
    medicineForms[i].addEventListener('submit', function(event){
        if(!validateMedicineForm(this)){
            event.preventDefault();
        }
    });
}

let loginForm = document.getElementById('loginForm');
if(loginForm){
    loginForm.addEventListener('submit', function(event){
        if(!validateLoginForm(this)){
            event.preventDefault();
        }
    });
}

let deleteForms = document.querySelectorAll('.delete-form');
for(let i = 0; i < deleteForms.length; i++){
    deleteForms[i].addEventListener('submit', function(event){
        if(!confirm('Are you sure?')){
            event.preventDefault();
        }
    });
}

let orderButtons = document.querySelectorAll('.order-action');
for(let i = 0; i < orderButtons.length; i++){
    orderButtons[i].addEventListener('click', function(){
        let button = this;
        let orderId = button.getAttribute('data-id');
        let status = button.getAttribute('data-status');
        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let messageBox = document.getElementById('ajaxMessage');
        let data = new FormData();

        data.append('order_id', orderId);
        data.append('status', status);
        data.append('csrf_token', token);

        fetch('../controllers/orderController.php', {
            method: 'POST',
            body: data
        })
        .then(function(response){
            return response.json();
        })
        .then(function(result){
            messageBox.className = result.success ? 'ajax-message success' : 'ajax-message error';
            messageBox.innerHTML = result.message;

            if(result.success){
                let row = document.getElementById('order-' + orderId);
                row.querySelector('.status-text').innerHTML = result.status;
                row.querySelector('.order-buttons').innerHTML = 'Updated';
            }
        })
        .catch(function(){
            messageBox.className = 'ajax-message error';
            messageBox.innerHTML = 'Order update request failed';
        });
    });
}
