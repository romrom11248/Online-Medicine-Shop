function validateProfile(){
    let name = document.getElementById('name').value;
    let phone = document.getElementById('phone').value;
    let address = document.getElementById('address').value;

    if(name == '' || phone == '' || address == ''){
        alert('Please fill all the fields');
        return false;
    }
    return true;
}