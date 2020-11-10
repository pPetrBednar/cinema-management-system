function generateGallery() {
    let gal = document.getElementById("gallery");
    let item = gal.innerHTML;
    let items = "";
    
    for (let i = 0; i < 30; i++) {
        items += item;
    }

    gal.innerHTML = items;
}























window.onload = function() {
    generateGallery();
};