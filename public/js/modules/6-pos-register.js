export class POSRegister {
    constructor(state, api) {
        this.state = state;
        this.api = api;
        this.cart = [];
        this.customer = null;
        this.barcodeBuffer = '';
        this.lastKeyTime = Date.now();
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <div>
                    <h1>POS Register</h1>
                    <p>Scan products or search to add items</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <button class="btn btn-secondary" onclick="app.pages.register.clearCart()">
                        🗑️ Clear Cart
                    </button>
                    <button class="btn btn-primary" onclick="app.pages.register.openCustomerSearch()">
                        👤 Find Customer
                    </button>
                </div>
            </div>
            
            <div id="customer-info"></div>
            
            <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 20px;">
                <div>
                    <div class="card">
                        <div class="search-box">
                            <input type="text" id="product-search" placeholder="Search products or scan barcode..." 
                                   onkeyup="app.pages.register.handleSearch(event)" autofocus />
                        </div>
                    </div>
                    
                    <div class="card">
                        <h3>Products</h3>
                        <div id="product-list" style="max-height: 500px; overflow-y: auto;"></div>
                    </div>
                </div>
                
                <div>
                    <div class="card" style="position: sticky; top: 20px;">
                        <h3>Cart <span id="cart-count">(0 items)</span></h3>
                        <div id="cart-items" style="max-height: 300px; overflow-y: auto; margin: 20px 0;"></div>
                        
                        <div style="border-top: 2px solid #e5e7eb; padding-top: 20px; margin-top: 20px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span>Subtotal:</span>
                                <span id="cart-subtotal">$0.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #6b7280;">
                                <span>Tax (15%):</span>
                                <span id="cart-tax">$0.00</span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 24px; font-weight: bold; margin-top: 15px;">
                                <span>Total:</span>
                                <span id="cart-total" style="color: #2563eb;">$0.00</span>
                            </div>
                        </div>
                        
                        <button class="btn btn-success" style="width: 100%; margin-top: 20px; padding: 15px; font-size: 16px;"
                                onclick="app.pages.register.completeSale()" id="complete-btn" disabled>
                            💳 Complete Sale
                        </button>
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 10px;">
                            <button class="btn btn-secondary" onclick="app.pages.register.holdSale()">
                                ⏸️ Hold
                            </button>
                            <button class="btn btn-secondary" onclick="app.pages.register.retrieveSale()">
                                📋 Retrieve
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        this.loadProducts();
        this.updateCart();
        this.setupBarcodeScanner();
    }
    
    setupBarcodeScanner() {
        document.addEventListener('keypress', (e) => {
            const now = Date.now();
            // Barcode scanners type fast (< 50ms between chars)
            if (now - this.lastKeyTime > 50) {
                this.barcodeBuffer = '';
            }
            this.lastKeyTime = now;
            
            if (e.key === 'Enter' && this.barcodeBuffer.length > 3) {
                this.searchByBarcode(this.barcodeBuffer);
                this.barcodeBuffer = '';
            } else if (e.key !== 'Enter') {
                this.barcodeBuffer += e.key;
            }
        });
    }
    
    async loadProducts() {
        // Load from API or use sample data
        const products = [
            { id: 1, sku: 'VAPE001', name: 'Vaporesso XROS 3', price: 45.99, barcode: '8888888001', stock: 25, category: 'Devices' },
            { id: 2, sku: 'LIQUID001', name: 'Salt Nic 30ml Berry', price: 24.99, barcode: '8888888002', stock: 150, category: 'E-Liquids' },
            { id: 3, sku: 'COIL001', name: 'XROS Mesh Coils (5pk)', price: 18.99, barcode: '8888888003', stock: 80, category: 'Coils' },
            { id: 4, sku: 'DISP001', name: 'HQD Disposable 5000', price: 32.99, barcode: '8888888004', stock: 200, category: 'Disposables' },
            { id: 5, sku: 'BATTERY001', name: '18650 Battery 3000mAh', price: 12.99, barcode: '8888888005', stock: 50, category: 'Batteries' },
            { id: 6, sku: 'LIQUID002', name: 'Freebase 100ml Menthol', price: 34.99, barcode: '8888888006', stock: 75, category: 'E-Liquids' },
            { id: 7, sku: 'VAPE002', name: 'GeekVape Aegis Legend', price: 89.99, barcode: '8888888007', stock: 15, category: 'Devices' },
            { id: 8, sku: 'TANK001', name: 'Zeus Sub-Ohm Tank', price: 39.99, barcode: '8888888008', stock: 30, category: 'Tanks' }
        ];
        
        this.products = products;
        this.displayProducts(products);
    }
    
    displayProducts(products) {
        const list = document.getElementById('product-list');
        if (products.length === 0) {
            list.innerHTML = '<p style="text-align: center; color: #6b7280; padding: 40px;">No products found</p>';
            return;
        }
        
        list.innerHTML = products.map(p => `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; border-bottom: 1px solid #e5e7eb; cursor: pointer; transition: background 0.2s;"
                 onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'"
                 onclick="app.pages.register.addToCart(${p.id}, '${p.name}', ${p.price}, '${p.sku}')">
                <div style="flex: 1;">
                    <div style="font-weight: 600; margin-bottom: 4px;">${p.name}</div>
                    <div style="font-size: 13px; color: #6b7280;">
                        ${p.sku} • ${p.category} • Stock: ${p.stock}
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 18px; font-weight: 700; color: #2563eb;">$${p.price.toFixed(2)}</div>
                    <button class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; margin-top: 5px;"
                            onclick="event.stopPropagation(); app.pages.register.addToCart(${p.id}, '${p.name}', ${p.price}, '${p.sku}')">
                        + Add
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    handleSearch(event) {
        const query = event.target.value.toLowerCase();
        if (!query) {
            this.displayProducts(this.products);
            return;
        }
        
        const filtered = this.products.filter(p => 
            p.name.toLowerCase().includes(query) ||
            p.sku.toLowerCase().includes(query) ||
            p.barcode.includes(query) ||
            p.category.toLowerCase().includes(query)
        );
        this.displayProducts(filtered);
    }
    
    searchByBarcode(barcode) {
        const product = this.products.find(p => p.barcode === barcode);
        if (product) {
            this.addToCart(product.id, product.name, product.price, product.sku);
            document.getElementById('product-search').value = '';
        }
    }
    
    addToCart(id, name, price, sku) {
        const existing = this.cart.find(item => item.id === id);
        if (existing) {
            existing.quantity++;
        } else {
            this.cart.push({ id, name, price, sku, quantity: 1 });
        }
        this.updateCart();
    }
    
    removeFromCart(id) {
        this.cart = this.cart.filter(item => item.id !== id);
        this.updateCart();
    }
    
    updateQuantity(id, quantity) {
        const item = this.cart.find(item => item.id === id);
        if (item) {
            item.quantity = Math.max(1, parseInt(quantity) || 1);
            this.updateCart();
        }
    }
    
    updateCart() {
        const cartItems = document.getElementById('cart-items');
        const cartCount = document.getElementById('cart-count');
        const cartSubtotal = document.getElementById('cart-subtotal');
        const cartTax = document.getElementById('cart-tax');
        const cartTotal = document.getElementById('cart-total');
        const completeBtn = document.getElementById('complete-btn');
        
        if (this.cart.length === 0) {
            cartItems.innerHTML = '<p style="color: #9ca3af; text-align: center; padding: 40px;">Cart is empty<br/>Scan or search to add items</p>';
            cartCount.textContent = '(0 items)';
            cartSubtotal.textContent = '$0.00';
            cartTax.textContent = '$0.00';
            cartTotal.textContent = '$0.00';
            completeBtn.disabled = true;
            return;
        }
        
        const totalItems = this.cart.reduce((sum, item) => sum + item.quantity, 0);
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.15; // 15% GST
        const total = subtotal + tax;
        
        cartItems.innerHTML = this.cart.map(item => `
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #f3f4f6;">
                <div style="flex: 1;">
                    <div style="font-weight: 500; margin-bottom: 4px;">${item.name}</div>
                    <div style="font-size: 12px; color: #6b7280;">${item.sku}</div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="number" value="${item.quantity}" min="1" 
                           style="width: 50px; padding: 4px; text-align: center;"
                           onchange="app.pages.register.updateQuantity(${item.id}, this.value)" />
                    <div style="min-width: 60px; text-align: right; font-weight: 600;">
                        $${(item.price * item.quantity).toFixed(2)}
                    </div>
                    <button onclick="app.pages.register.removeFromCart(${item.id})" 
                            style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 18px;">
                        ×
                    </button>
                </div>
            </div>
        `).join('');
        
        cartCount.textContent = `(${totalItems} items)`;
        cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
        cartTax.textContent = `$${tax.toFixed(2)}`;
        cartTotal.textContent = `$${total.toFixed(2)}`;
        completeBtn.disabled = false;
    }
    
    openCustomerSearch() {
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;" onclick="this.remove()">
                <div class="card" style="width: 500px; max-width: 90%;" onclick="event.stopPropagation()">
                    <h3>Find Customer</h3>
                    <div class="search-box" style="margin: 20px 0;">
                        <input type="text" id="customer-search" placeholder="Search by name, email, or phone..." />
                    </div>
                    <div id="customer-results"></div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }
    
    clearCart() {
        if (this.cart.length > 0 && confirm('Clear all items from cart?')) {
            this.cart = [];
            this.updateCart();
        }
    }
    
    holdSale() {
        if (this.cart.length > 0) {
            const held = JSON.parse(localStorage.getItem('heldSales') || '[]');
            held.push({
                id: Date.now(),
                cart: [...this.cart],
                customer: this.customer,
                timestamp: new Date().toISOString()
            });
            localStorage.setItem('heldSales', JSON.stringify(held));
            alert('Sale held successfully');
            this.cart = [];
            this.updateCart();
        }
    }
    
    retrieveSale() {
        const held = JSON.parse(localStorage.getItem('heldSales') || '[]');
        if (held.length === 0) {
            alert('No held sales');
            return;
        }
        
        const sale = held[held.length - 1];
        this.cart = sale.cart;
        this.customer = sale.customer;
        this.updateCart();
        
        held.pop();
        localStorage.setItem('heldSales', JSON.stringify(held));
    }
    
    async completeSale() {
        if (this.cart.length === 0) return;
        
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.15;
        const total = subtotal + tax;
        
        if (confirm(`Complete sale for $${total.toFixed(2)}?`)) {
            // Save sale to API
            const sale = {
                items: this.cart,
                customer: this.customer,
                subtotal,
                tax,
                total,
                timestamp: new Date().toISOString()
            };
            
            // Mock API call
            console.log('Sale completed:', sale);
            
            alert('✅ Sale completed successfully!');
            this.cart = [];
            this.customer = null;
            this.updateCart();
            document.getElementById('customer-info').innerHTML = '';
        }
    }
}
