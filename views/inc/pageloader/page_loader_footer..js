
window.addEventListener("load", function () {

    const loader = document.getElementById("pageLoader");

    if (loader) {
        loader.classList.add("hide");

        setTimeout(function () {
            loader.remove();
        }, 500);
    }

});
