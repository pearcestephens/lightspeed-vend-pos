export class Inventory {
    constructor(state, api) {
        this.state = state;
        this.api = api;
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <h1>Inventory Management</h1>
                <p>Manage your product inventory</p>
            </div>
            
            <div class="card">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <input type="text" placeholder="Search products..." style="flex: 1; margin-right: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <button class="btn btn-primary">+ Add Product</button>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>SKU001</td>
                                <td>Product A</td>
                                <td>Electronics</td>
                                <td>45</td>
                                <td>$29.99</td>
                                <td>
                                    <button class="btn" style="font-size: 12px; padding: 5px 10px;">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td>SKU002</td>
                                <td>Product B</td>
                                <td>Accessories</td>
                                <td>122</td>
                                <td>$49.99</td>
                                <td>
                                    <button class="btn" style="font-size: 12px; padding: 5px 10px;">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
}
