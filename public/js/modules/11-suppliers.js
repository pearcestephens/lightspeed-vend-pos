export class Suppliers {
    constructor(state, api) {
        this.state = state;
        this.api = api;
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <div>
                    <h1>Supplier Management</h1>
                    <p>Manage your product suppliers</p>
                </div>
                <button class="btn btn-primary" onclick="app.pages.suppliers.addSupplier()">
                    + Add Supplier
                </button>
            </div>
            
            <div class="card">
                <div class="search-box" style="margin-bottom: 20px;">
                    <input type="search" placeholder="Search suppliers..." />
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Supplier Name</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>VapeCo Wholesale NZ</strong></td>
                                <td>John Smith</td>
                                <td>john@vapeco.nz</td>
                                <td>09-123-4567</td>
                                <td>247</td>
                                <td><span class="status-badge status-online">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="font-size: 12px; padding: 5px 10px;">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Nicotine Supplies Ltd</strong></td>
                                <td>Sarah Jones</td>
                                <td>sarah@nicsupply.co.nz</td>
                                <td>09-234-5678</td>
                                <td>156</td>
                                <td><span class="status-badge status-online">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="font-size: 12px; padding: 5px 10px;">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Hardware Imports</strong></td>
                                <td>Mike Chen</td>
                                <td>mike@hwimports.nz</td>
                                <td>09-345-6789</td>
                                <td>89</td>
                                <td><span class="status-badge status-online">Active</span></td>
                                <td>
                                    <button class="btn btn-primary" style="font-size: 12px; padding: 5px 10px;">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    addSupplier() {
        alert('Add supplier form would open here');
    }
}
