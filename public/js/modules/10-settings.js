export class Settings {
    constructor(state, api) {
        this.state = state;
        this.api = api;
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <h1>Settings</h1>
                <p>Configure your POS system</p>
            </div>
            
            <div class="card">
                <h2>Store Information</h2>
                <div class="form-group">
                    <label>Store Name</label>
                    <input type="text" value="My Store" />
                </div>
                <div class="form-group">
                    <label>Store Address</label>
                    <input type="text" value="123 Main Street" />
                </div>
                <div class="form-group">
                    <label>Contact Email</label>
                    <input type="email" value="store@example.com" />
                </div>
                <button class="btn btn-primary">Save Changes</button>
            </div>
            
            <div class="card">
                <h2>Hardware Status</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <div>
                        <strong>Receipt Printer</strong>
                        <span class="status-badge status-online" style="display: block; margin-top: 5px;">Online</span>
                    </div>
                    <div>
                        <strong>Barcode Scanner</strong>
                        <span class="status-badge status-online" style="display: block; margin-top: 5px;">Online</span>
                    </div>
                    <div>
                        <strong>Card Reader</strong>
                        <span class="status-badge status-offline" style="display: block; margin-top: 5px;">Offline</span>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <h2>API Configuration</h2>
                <div class="form-group">
                    <label>Lightspeed API Key</label>
                    <input type="password" value="••••••••••••••••" />
                </div>
                <div class="form-group">
                    <label>Vend API Token</label>
                    <input type="password" value="••••••••••••••••" />
                </div>
                <button class="btn btn-primary">Update API Keys</button>
            </div>
        `;
    }
}
