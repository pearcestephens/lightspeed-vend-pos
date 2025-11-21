export class Dashboard {
    constructor(state, api) {
        this.state = state;
        this.api = api;
    }
    
    async render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <h1>Dashboard</h1>
                <p>Overview of your POS system</p>
            </div>
            
            <div class="grid">
                <div class="card stat-card">
                    <h3>Today's Sales</h3>
                    <div class="stat-value">$2,847</div>
                    <p>+12% from yesterday</p>
                </div>
                <div class="card stat-card">
                    <h3>Transactions</h3>
                    <div class="stat-value">47</div>
                    <p>Active today</p>
                </div>
                <div class="card stat-card">
                    <h3>Products</h3>
                    <div class="stat-value">1,247</div>
                    <p>In stock</p>
                </div>
                <div class="card stat-card">
                    <h3>Customers</h3>
                    <div class="stat-value">328</div>
                    <p>Registered</p>
                </div>
            </div>
            
            <div class="card">
                <h2>Recent Transactions</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#0001</td>
                                <td>John Doe</td>
                                <td>3</td>
                                <td>$127.50</td>
                                <td><span class="status-badge status-online">Completed</span></td>
                            </tr>
                            <tr>
                                <td>#0002</td>
                                <td>Jane Smith</td>
                                <td>5</td>
                                <td>$245.00</td>
                                <td><span class="status-badge status-online">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
}
