var cart = document.getElementById("cart-sliding-box");
var cartState = false;
var cartClicked = false;

function openCloseCart() {

    if (cartState && !cartClicked) {
        cartClicked = true;
        return;
    }

    if (cartState && cartClicked) {
        cartClicked = false;
        return;
    }
}

function openCloseCartHover() {

    if (cartClicked) {
        return;
    }

    if (cartState) {
        cart.style.display = "none";
    } else {
        cart.style.display = "block";
    }
    cartState = !cartState;
}


