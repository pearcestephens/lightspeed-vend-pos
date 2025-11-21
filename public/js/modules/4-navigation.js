export class Navigation {
    constructor() {
        this.items = [
            { section: 'Sales', items: [
                { id: 'register', label: 'POS Register', icon: '🛒', path: '#/register' },
                { id: 'dashboard', label: 'Dashboard', icon: '📊', path: '#/dashboard' },
            ]},
            { section: 'Inventory', items: [
                { id: 'inventory', label: 'Products', icon: '📦', path: '#/inventory' },
                { id: 'suppliers', label: 'Suppliers', icon: '🏭', path: '#/suppliers' },
            ]},
            { section: 'Customers', items: [
                { id: 'customers', label: 'Customers', icon: '👥', path: '#/customers' },
            ]},
            { section: 'Reports', items: [
                { id: 'reports', label: 'Analytics', icon: '📈', path: '#/reports' },
            ]},
            { section: 'Settings', items: [
                { id: 'settings', label: 'Configuration', icon: '⚙️', path: '#/settings' },
                { id: 'migration', label: 'Data Migration', icon: '🔄', path: '#/migration' },
            ]}
        ];
    }
    
    render() {
        const sidebar = document.getElementById('sidebar');
        
        const sectionsHtml = this.items.map(section => `
            <div class="nav-section">
                <div class="nav-section-title">${section.section}</div>
                ${section.items.map(item => `
                    <div class="nav-item" data-path="${item.path}">
                        <span class="nav-item-icon">${item.icon}</span>
                        <span>${item.label}</span>
                    </div>
                `).join('')}
            </div>
        `).join('');
        
        sidebar.innerHTML = `
            <div class="sidebar-header">
                <h2>🛒 Ecigdis POS</h2>
                <div class="subtitle">Point of Sale System</div>
            </div>
            ${sectionsHtml}
        `;
        
        sidebar.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                const path = e.currentTarget.dataset.path;
                window.location.hash = path;
                this.setActive(path);
            });
        });
        
        this.setActive(window.location.hash || '#/register');
    }
    
    setActive(path) {
        document.querySelectorAll('.nav-item').forEach(item => {
            item.classList.remove('active');
            if (item.dataset.path === path) {
                item.classList.add('active');
            }
        });
    }
}
