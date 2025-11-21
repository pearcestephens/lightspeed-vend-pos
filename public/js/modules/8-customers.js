export class Customers {
    constructor(state, api) {
        this.state = state;
        this.api = api;
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <h1>Customer Management</h1>
                <p>Manage your customer database</p>
            </div>
            
            <div class="card">
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <input type="text" placeholder="Search customers..." style="flex: 1; margin-right: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <button class="btn btn-primary">+ Add Customer</button>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total Spent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#C001</td>
                                <td>John Doe</td>
                                <td>john@example.com</td>
                                <td>555-0123</td>
                                <td>$1,234.56</td>
                                <td>
                                    <button class="btn" style="font-size: 12px; padding: 5px 10px;">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td>#C002</td>
                                <td>Jane Smith</td>
                                <td>jane@example.com</td>
                                <td>555-0124</td>
                                <td>$2,456.78</td>
                                <td>
                                    <button class="btn" style="font-size: 12px; padding: 5px 10px;">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
}
