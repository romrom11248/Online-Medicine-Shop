function addToCart(medicineId) {

    let quantity = document.getElementById(
        'qty_' + medicineId
    ).value;


    if (quantity <= 0 || isNaN(quantity)) {

        document.getElementById('msg')
            .innerHTML = 'Invalid Quantity';

        return;
    }


    let data = {

        med_id: medicineId,
        quantity: quantity
    };


    let cart = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../api/cart/add.php',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + cart);


    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 &&
            this.status == 200) {


                console.log(response);

            let response =
                JSON.parse(this.responseText);

        

            document.getElementById('msg')
                .innerHTML = response.message;


            if (response.status) {

                document.getElementById('cartCount')
                    .innerHTML = response.cartCount;
            }
        }
    }

}

function updateQuantity(cartId, action) {

    let data = {

        cart_id: cartId,
        action: action
    };


    let cart = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../api/cart/update.php',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + cart);



    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 &&
            this.status == 200) {

            console.log(this.responseText);

            let response =
                JSON.parse(this.responseText);





            document.getElementById('msg')
                .innerHTML = response.message;



            if (response.status) {

                document.getElementById(
                    'qty_' + cartId
                ).innerHTML =
                    response.quantity;



                document.getElementById(
                    'subtotal_' + cartId
                ).innerHTML =
                    response.subtotal;



                document.getElementById(
                    'total'
                ).innerHTML =
                    response.grandTotal;
            }
        }
    }
}


function removeCartItem(cartId) {

    let data = {

        cart_id: cartId
    };


    let cart = JSON.stringify(data);


    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../api/cart/remove.php',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + cart);



    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 &&
            this.status == 200) {

            let response =
                JSON.parse(this.responseText);



            document.getElementById('msg')
                .innerHTML =
                response.message;



            if (response.status) {

                document.getElementById(
                    'cartRow_' + cartId
                ).remove();



                document.getElementById(
                    'total'
                ).innerHTML =
                    response.grandTotal;
            }
        }
    }
}



function confirmOrder() {
    let addr = document.getElementById("address").value;
    let pay= document.getElementsByName("payment").value;

    if (address == " " || payment == " ") {
        document.getElementById("msg").innerHTML = "Address and Payment Method cant be empty";
        return;
    }

    let data = {
        address: addr,
        payment: pay
    };
    let check = JSON.stringify(true, data);

    let xhttp = new XMLHttpRequest();


    xhttp.open(
        'POST',
        '../../api/order/confirm.php',
        true
    );


    xhttp.setRequestHeader(
        'Content-type',
        'application/x-www-form-urlencoded'
    );


    xhttp.send('cart=' + check);



    xhttp.onreadystatechange = function () {

        if (this.readyState == 4 &&
            this.status == 200) {

            let response =
                JSON.parse(this.responseText);



            document.getElementById('confirm')
                .innerHTML =
                response.message;


                if (response.status) {
                    window.location = "../../views/customer/medicines.php";

                }


            }
        }


}