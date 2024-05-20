document.addEventListener('DOMContentLoaded', () => {
    loadCart();
});

function loadCart() {
    // Funkcja ładowania elementów koszyka
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    const cartItemsDiv = document.getElementById('cartItems');
    cartItemsDiv.innerHTML = '';
    if (cartItems.length === 0) {
        cartItemsDiv.innerHTML = '<p>Koszyk jest pusty.</p>';
    } else {
        cartItems.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('cart-item');
            itemDiv.innerHTML = `
                <h3>${item.name}</h3>
                <p>Cena: ${item.price.toFixed(2)} PLN</p>
                <button onclick="removeFromCart('${item.name}')">Usuń</button>
            `;
            cartItemsDiv.appendChild(itemDiv);
        });
        const totalDiv = document.createElement('div');
        totalDiv.classList.add('cart-total');
        totalDiv.innerHTML = `<p><strong>Total:</strong> ${calculateTotal(cartItems).toFixed(2)} PLN</p>`;
        cartItemsDiv.appendChild(totalDiv);
    }
}

function addToCart(productId, productName, productPrice) {
    // Funkcja dodawania produktu do koszyka
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartItems.push({ id: productId, name: productName, price: productPrice });
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    alert(`${productName} został dodany do koszyka.`);
}

function removeFromCart(productName) {
    // Funkcja usuwania produktu z koszyka
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    cartItems = cartItems.filter(item => item.name !== productName);
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    loadCart();
}

function checkout() {
    // Funkcja do zamówienia
    alert('Zamówienie zostało złożone.');
    localStorage.removeItem('cartItems');
    loadCart();
}
