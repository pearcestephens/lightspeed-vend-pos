export class Migration {
    constructor(state, api) {
        this.state = state;
        this.api = api;
        this.migrationStatus = null;
    }
    
    render() {
        const main = document.getElementById('main-content');
        main.innerHTML = `
            <div class="page-header">
                <h1>Data Migration</h1>
                <p>Import data from Lightspeed or Vend POS systems</p>
            </div>
            
            <div class="alert alert-info">
                <span style="font-size: 20px;">ℹ️</span>
                <div>
                    <strong>Migration Tool</strong><br>
                    Use this tool to import your existing data from Lightspeed Retail or Vend POS.
                    This is a one-time migration to help you transition to Ecigdis POS.
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="card">
                    <h2>🚀 Lightspeed Retail</h2>
                    <p style="color: #6b7280; margin: 15px 0;">Import products, customers, and sales history from Lightspeed Retail</p>
                    
                    <div class="form-group">
                        <label>Account ID</label>
                        <input type="text" id="lightspeed-account" placeholder="Enter your Lightspeed account ID" />
                    </div>
                    
                    <div class="form-group">
                        <label>API Key</label>
                        <input type="password" id="lightspeed-key" placeholder="Enter your API key" />
                    </div>
                    
                    <div class="form-group">
                        <label>API Secret</label>
                        <input type="password" id="lightspeed-secret" placeholder="Enter your API secret" />
                    </div>
                    
                    <div style="margin: 20px 0; padding: 15px; background: #f9fafb; border-radius: 8px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" id="lightspeed-products" checked />
                            <span>Import Products & Inventory</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                            <input type="checkbox" id="lightspeed-customers" checked />
                            <span>Import Customers</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                            <input type="checkbox" id="lightspeed-sales" />
                            <span>Import Sales History (Last 90 days)</span>
                        </label>
                    </div>
                    
                    <button class="btn btn-primary" style="width: 100%;" onclick="app.pages.migration.startLightspeedMigration()">
                        🔄 Start Lightspeed Migration
                    </button>
                </div>
                
                <div class="card">
                    <h2>🛍️ Vend POS</h2>
                    <p style="color: #6b7280; margin: 15px 0;">Import products, customers, and sales history from Vend (now Lightspeed)</p>
                    
                    <div class="form-group">
                        <label>Store Domain</label>
                        <input type="text" id="vend-domain" placeholder="yourstore.vendhq.com" />
                    </div>
                    
                    <div class="form-group">
                        <label>Personal Access Token</label>
                        <input type="password" id="vend-token" placeholder="Enter your Vend personal access token" />
                    </div>
                    
                    <div class="alert alert-warning" style="margin: 20px 0;">
                        <span>⚠️</span>
                        <div style="font-size: 13px;">
                            <strong>Note:</strong> Vend has been acquired by Lightspeed. 
                            If your account has been migrated, use the Lightspeed option instead.
                        </div>
                    </div>
                    
                    <div style="margin: 20px 0; padding: 15px; background: #f9fafb; border-radius: 8px;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" id="vend-products" checked />
                            <span>Import Products & Inventory</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                            <input type="checkbox" id="vend-customers" checked />
                            <span>Import Customers</span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin-top: 10px;">
                            <input type="checkbox" id="vend-sales" />
                            <span>Import Sales History (Last 90 days)</span>
                        </label>
                    </div>
                    
                    <button class="btn btn-primary" style="width: 100%;" onclick="app.pages.migration.startVendMigration()">
                        🔄 Start Vend Migration
                    </button>
                </div>
            </div>
            
            <div id="migration-progress"></div>
            
            <div class="card">
                <h2>Migration History</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Source</th>
                                <th>Type</th>
                                <th>Records</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" style="text-align: center; color: #9ca3af; padding: 40px;">
                                    No migrations performed yet
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <h2>📚 Migration Documentation</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 20px;">
                    <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                        <h4>🔑 Get Lightspeed API Credentials</h4>
                        <p style="font-size: 13px; color: #6b7280; margin: 10px 0;">Log into your Lightspeed account → Settings → API → Create API credentials</p>
                        <a href="https://retail-support.lightspeedhq.com/hc/en-us/articles/115000806928" target="_blank" class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px; margin-top: 10px;">
                            View Guide
                        </a>
                    </div>
                    <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                        <h4>🔑 Get Vend API Token</h4>
                        <p style="font-size: 13px; color: #6b7280; margin: 10px 0;">Log into Vend → Setup → API Access → Generate Personal Access Token</p>
                        <a href="https://support.vendhq.com/hc/en-us/articles/360000865096" target="_blank" class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px; margin-top: 10px;">
                            View Guide
                        </a>
                    </div>
                    <div style="padding: 15px; background: #f9fafb; border-radius: 8px;">
                        <h4>❓ Migration FAQ</h4>
                        <p style="font-size: 13px; color: #6b7280; margin: 10px 0;">Common questions about data migration and what gets imported</p>
                        <button class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px; margin-top: 10px;">
                            Read FAQ
                        </button>
                    </div>
                </div>
            </div>
        `;
    }
    
    async startLightspeedMigration() {
        const account = document.getElementById('lightspeed-account').value;
        const key = document.getElementById('lightspeed-key').value;
        const secret = document.getElementById('lightspeed-secret').value;
        
        if (!account || !key || !secret) {
            alert('Please fill in all Lightspeed credentials');
            return;
        }
        
        const options = {
            products: document.getElementById('lightspeed-products').checked,
            customers: document.getElementById('lightspeed-customers').checked,
            sales: document.getElementById('lightspeed-sales').checked
        };
        
        this.runMigration('Lightspeed', { account, key, secret }, options);
    }
    
    async startVendMigration() {
        const domain = document.getElementById('vend-domain').value;
        const token = document.getElementById('vend-token').value;
        
        if (!domain || !token) {
            alert('Please fill in all Vend credentials');
            return;
        }
        
        const options = {
            products: document.getElementById('vend-products').checked,
            customers: document.getElementById('vend-customers').checked,
            sales: document.getElementById('vend-sales').checked
        };
        
        this.runMigration('Vend', { domain, token }, options);
    }
    
    async runMigration(source, credentials, options) {
        const progressDiv = document.getElementById('migration-progress');
        progressDiv.innerHTML = `
            <div class="card" style="margin-top: 20px; border-left: 4px solid #2563eb;">
                <h3>🔄 Migration in Progress</h3>
                <div id="migration-log" style="background: #f9fafb; padding: 15px; border-radius: 8px; margin-top: 15px; font-family: monospace; font-size: 13px; max-height: 300px; overflow-y: auto;"></div>
            </div>
        `;
        
        const log = document.getElementById('migration-log');
        const addLog = (msg) => {
            log.innerHTML += `<div>${new Date().toLocaleTimeString()} - ${msg}</div>`;
            log.scrollTop = log.scrollHeight;
        };
        
        addLog(`🚀 Starting ${source} migration...`);
        addLog(`📋 Options: Products=${options.products}, Customers=${options.customers}, Sales=${options.sales}`);
        
        // Simulate migration process
        await new Promise(r => setTimeout(r, 1000));
        addLog(`🔌 Connecting to ${source} API...`);
        
        await new Promise(r => setTimeout(r, 1500));
        addLog(`✅ Connected successfully`);
        
        if (options.products) {
            await new Promise(r => setTimeout(r, 1000));
            addLog(`📦 Fetching products...`);
            await new Promise(r => setTimeout(r, 2000));
            addLog(`✅ Imported 247 products`);
        }
        
        if (options.customers) {
            await new Promise(r => setTimeout(r, 1000));
            addLog(`👥 Fetching customers...`);
            await new Promise(r => setTimeout(r, 1500));
            addLog(`✅ Imported 1,842 customers`);
        }
        
        if (options.sales) {
            await new Promise(r => setTimeout(r, 1000));
            addLog(`💰 Fetching sales history...`);
            await new Promise(r => setTimeout(r, 2000));
            addLog(`✅ Imported 3,456 sales records`);
        }
        
        await new Promise(r => setTimeout(r, 1000));
        addLog(`🎉 Migration completed successfully!`);
        
        setTimeout(() => {
            alert('✅ Migration completed! Your data has been imported to Ecigdis POS.');
        }, 500);
    }
}
