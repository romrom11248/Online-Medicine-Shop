function addToCart(medicineId){

    let quantity = document.getElementById(
        'qty_' + medicineId
    ).value;


    if(quantity <= 0 || isNaN(quantity)){

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


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
            JSON.parse(this.responseText);
        
        console.log(response);

            document.getElementById('msg')
                .innerHTML = response.message;


            if(response.status){

                document.getElementById('cartCount')
                    .innerHTML = response.cartCount;
            }
        }
    }

}

function increase(cart_id,med_price){

    let data = {

        cart_id: cart_id,
        med_price:med_price
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


    xhttp.send('increase=' + cart);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
            JSON.parse(this.responseText);

            document.getElementById('msg')
                .innerHTML = response.message;

                document.getElementById('subtotal_'+item['cart.id'])
                .innerHTML = response.subtotal;

          
            }
        
    }


}



function decrease(cart_id){

    let data = {

        cart_id: cart_id,
        med_price:med_price
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


    xhttp.send('decrease=' + cart);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
            JSON.parse(this.responseText);

            document.getElementById('msg')
                .innerHTML = response.message;

                document.getElementById('subtotal_'+item['cart.id'])
                .innerHTML = response.subtotal;

          
            }
        
    }
}

function remove(cart_id){
    let data = {
        cart_id: cart_id,
        med_price:med_price
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


    xhttp.send('remove=' + cart);


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 &&
           this.status == 200){

            let response =
            JSON.parse(this.responseText);

            document.getElementById('msg')
                .innerHTML = response.message;

          
            }
        
    }

}