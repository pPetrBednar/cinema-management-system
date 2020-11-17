var cart = document.getElementById("cart-sliding-box");
var cartState = false;

function openCloseCart() {

    if (cartState) {
        cart.style.display = "none";
    } else {
        cart.style.display = "block";
    }
    cartState = !cartState;
}


