var select_product_remove = document.querySelectorAll(".select_product_remove");

select_product_remove.forEach(function (element) {
    element.addEventListener("click", function () {
        // Set background color of the clicked div to red
        this.style.border = "2px solid red";
        document.querySelector('#data_img_delete').value = this.id;

        // Set background color of all other divs to white
        select_product_remove.forEach(function (otherElement) {
            if (otherElement !== element) {
                otherElement.style.border = "1px solid black";
            }
        });
    });
});