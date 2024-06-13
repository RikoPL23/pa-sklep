const renderBasketItems = () => {
    const basket = JSON.parse(sessionStorage.getItem("basket")) || [];
    const basketItemsContainer = document.querySelector(".basket-items");
    basketItemsContainer.innerHTML = "";
    basket.forEach(item => {
        const basketItem = document.createElement("div");
        basketItem.className = "basket-item";
        basketItem.innerHTML = `
            <span>${item.name}</span>
            <span>${item.price.toFixed(2)} zł</span>
        `;
        basketItemsContainer.appendChild(basketItem);
    });
    const basketTotal = basket.reduce((sum, product) => sum + product.price, 0);
    document.getElementById("basketTotal").innerText = `${basketTotal.toFixed(2)} zł`;
};

const updateOrderData = () => {
    const basket = JSON.parse(sessionStorage.getItem("basket")) || [];
    const orderDataInput = document.getElementById("orderData");
    orderDataInput.value = JSON.stringify(basket);
};

document.addEventListener("DOMContentLoaded", () => {
    fetch("session_status.php")
        .then(response => response.json())
        .then(data => {
            if (data.loggedin) {
                sessionStorage.setItem("loggedIn", "true");
                document.getElementById("placeOrderButton").style.display = "block";
                updateOrderData();
            } else {
                sessionStorage.setItem("loggedIn", "false");
                document.getElementById("placeOrderButton").style.display = "none";
            }
        });
    renderBasketItems();
});
