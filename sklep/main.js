let categories = new Set();
let basket = JSON.parse(sessionStorage.getItem("basket")) || [];
let addToBasketButtons;
const productsSection = document.querySelector(".products");

const isLoggedIn = () => {
    return sessionStorage.getItem("loggedIn") === "true";
};

const fetchProducts = async () => {
    const response = await fetch("get_products.php");
    return response.json();
};

const renderProducts = (items) => {
    productsSection.innerHTML = "";
    for (let i = 0; i < items.length; i++) {
        const newProduct = document.createElement("div");
        newProduct.className = `product-item ${items[i].sale ? "on-sale" : ""}`;
        newProduct.innerHTML = `
        <img src="${items[i].image}" alt="product-image" />
        <p class="product-name">${items[i].name}</p>
        <p class="product-description">
        ${items[i].description}
        </p>
        <div class="product-price">
        <span class="price">${items[i].price.toFixed(2)} zł</span>
        <span class="price-sale">${(items[i].price - items[i].saleAmount).toFixed(
            2
        )} zł</span>
        </div>
        <button data-id="${
            items[i].id
        }" class="product-add-to-basket-btn">Dodaj do koszyka</button>
        <p class="product-item-sale-info">Promocja</p>`;

        productsSection.appendChild(newProduct);
    }
    addToBasketButtons = document.querySelectorAll(".product-add-to-basket-btn");
    addToBasketButtons.forEach((btn) =>
        btn.addEventListener("click", addToBasket)
    );
};

const renderCategories = (items) => {
    categories.clear();
    for (let i = 0; i < items.length; i++) {
        categories.add(items[i].category);
    }

    const categoriesItems = document.querySelector(".categories-items");
    categoriesItems.innerHTML = '';

    categories = ["wszystkie", ...categories];

    categories.forEach((category, index) => {
        const newCategory = document.createElement("button");
        newCategory.innerHTML = category;
        newCategory.dataset.category = category;

        index === 0 ? newCategory.classList.add("active") : "";

        categoriesItems.appendChild(newCategory);
    });

    categoriesItems.querySelectorAll("button").forEach((btn) =>
        btn.addEventListener("click", (e) => {
            const category = e.target.dataset.category;

            categoriesItems.querySelectorAll("button").forEach((btn) => btn.classList.remove("active"));
            e.target.classList.add("active");

            currentProducts = products;

            if (category === "wszystkie") {
                currentProducts = products;
            } else {
                currentProducts = currentProducts.filter(
                    (product) => product.category === category
                );
            }

            renderProducts(currentProducts);
        })
    );
};

const addToBasket = (e) => {
    if (!isLoggedIn()) {
        alert("Musisz być zalogowany, aby dodać produkt do koszyka.");
        return;
    }

    const selectedId = parseInt(e.target.dataset.id);
    const product = currentProducts.find((product) => product.id === selectedId);

    basket.push(product);
    sessionStorage.setItem("basket", JSON.stringify(basket));

    updateBasketAmount();
    updateOrderData();
};

const updateBasketAmount = () => {
    const basketTotal = basket.reduce((sum, product) => {
        return (sum += product.price);
    }, 0);

    document.querySelector(".basket-amount").innerHTML = `${basketTotal.toFixed(2)} zł`;
};

const updateOrderData = () => {
    const orderDataInput = document.getElementById("orderData");
    if (orderDataInput) {
        orderDataInput.value = JSON.stringify(basket);
    }
};

document.addEventListener("DOMContentLoaded", async () => {
    fetch("session_status.php")
        .then(response => response.json())
        .then(data => {
            if (data.loggedin) {
                sessionStorage.setItem("loggedIn", "true");
                document.getElementById("orderForm").style.display = "block";
            } else {
                sessionStorage.setItem("loggedIn", "false");
            }
        });

    const products = await fetchProducts();
    renderProducts(products);
    renderCategories(products);
    updateBasketAmount();
});
