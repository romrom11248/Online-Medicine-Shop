function addToCart(medicineId){

    let quantity = document.getElementById(
        'qty_' + medicineId
    ).value;


    let data = {

        med_id: medicineId,
        quantity: quantity
    };


    let cart = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../controllers/cartController.php?action=add',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + cart);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
                JSON.parse(this.responseText);


            document.getElementById('msg')
                .innerHTML = response.message;


            if(response.status){

                document.getElementById('cartCount')
                    .innerHTML = response.cartCount;
            }
        }
    }
}


function updateQuantity(cartId, action){

    let data = {

        cart_id: cartId,
        action: action
    };


    let cart = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../controllers/cartController.php?action=update',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + cart);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
                JSON.parse(this.responseText);


            document.getElementById('msg')
                .innerHTML = response.message;


            if(response.status){

                document.getElementById(
                    'qty_' + cartId
                ).innerHTML = response.quantity;


                document.getElementById(
                    'subtotal_' + cartId
                ).innerHTML = response.subtotal;


                document.getElementById(
                    'total'
                ).innerHTML = response.grandTotal;
            }
        }
    }
}


function removeCartItem(cartId){

    let data = {

        cart_id: cartId
    };


    let cart = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../controllers/cartController.php?action=remove',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + cart);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
                JSON.parse(this.responseText);


            document.getElementById('msg')
                .innerHTML = response.message;


            if(response.status){

                document.getElementById(
                    'cartRow_' + cartId
                ).remove();


                document.getElementById(
                    'total'
                ).innerHTML = response.grandTotal;
            }
        }
    }
}


function confirmOrder(){

    let addr = document.getElementById(
        'address'
    ).value;


    let payment = '';


    let methods =
        document.getElementsByName('payment');


    for(let i=0; i<methods.length; i++){

        if(methods[i].checked){

            payment = methods[i].value;
        }
    }


    if(addr == '' || payment == ''){

        document.getElementById('msg')
            .innerHTML =
            'Address and payment required';

        return;
    }


    let data = {

        address: addr,
        payment: payment
    };


    let check = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../controllers/orderController.php?action=confirm',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('check=' + check);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
                JSON.parse(this.responseText);


            document.getElementById('confirm')
                .innerHTML = response.message;


            if(response.status){

                setTimeout(function(){

                    window.location =
                    '../../views/customer/medicines.php';

                }, 1500);
            }
        }
    }
}