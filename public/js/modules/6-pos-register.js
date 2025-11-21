export class POSRegister {
    constructor(state, api) {
        this.state = state;
        this.api = api;
        this.cart = [];
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <h1>POS Register</h1>
                <p>Process customer transactions</p>
            </div>
            
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div>
                    <div class="card">
                        <h3>Products</h3>
                        <div class="product-grid" id="product-grid"></div>
                    </div>
                </div>
                
                <div>
                    <div class="card">
                        <h3>Cart</h3>
                        <div id="cart-items"></div>
                        <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid #333;">
                            <div style="display: flex; justify-content: space-between; font-size: 24px; font-weight: bold;">
                                <span>Total:</span>
                                <span id="cart-total">$0.00</span>
                            </div>
                            <button class="btn btn-primary" style="width: 100%; margin-top: 20px; padding: 15px;">
                                Complete Sale
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        this.loadProducts();
    }
    
    loadProducts() {
        const products = [
            { id: 1, name: 'Product A', price: 29.99 },
            { id: 2, name: 'Product B', price: 49.99 },
            { id: 3, name: 'Product C', price: 19.99 },
            { id: 4, name: 'Product D', price: 39.99 }
        ];
        
        const grid = document.getElementById('product-grid');
        grid.innerHTML = products.map(p => `
            <div class="product-card" onclick="app.pages.register.addToCart(${p.id}, '${p.name}', ${p.price})">
                <div class="product-name">${p.name}</div>
                <div class="product-price">$${p.price}</div>
            </div>
        `).join('');
    }
    
    addToCart(id, name, price) {
        this.cart.push({ id, name, price });
        this.updateCart();
    }
    
    updateCart() {
        const cartItems = document.getElementById('cart-items');
        const cartTotal = document.getElementById('cart-total');
        
        if (this.cart.length === 0) {
            cartItems.innerHTML = '<p style="color: #999; text-align: center; padding: 20px;">Cart is empty</p>';
            cartTotal.textContent = '$0.00';
            return;
        }
        
        cartItems.innerHTML = this.cart.map((item, index) => `
            <div class="cart-item">
                <span>${item.name}</span>
                <span>$${item.price}</span>
            </div>
        `).join('');
        
        const total = this.cart.reduce((sum, item) => sum + item.price, 0);
        cartTotal.textContent = `$${total.toFixed(2)}`;
    }
}
