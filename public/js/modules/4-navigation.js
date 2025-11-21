export class Navigation {
    constructor() {
        this.items = [
            { id: 'dashboard', label: '�� Dashboard', path: '#/dashboard' },
            { id: 'register', label: '🛒 POS Register', path: '#/register' },
            { id: 'inventory', label: '📦 Inventory', path: '#/inventory' },
            { id: 'customers', label: '👥 Customers', path: '#/customers' },
            { id: 'reports', label: '📈 Reports', path: '#/reports' },
            { id: 'settings', label: '⚙️ Settings', path: '#/settings' }
        ];
    }
    
    render() {
        const sidebar = document.getElementById('sidebar');
        sidebar.innerHTML = `
            <h2 style="margin-bottom: 30px; font-size: 24px;">⚡ Lightspeed POS</h2>
            ${this.items.map(item => `
                <div class="nav-item" data-path="${item.path}">
                    ${item.label}
                </div>
            `).join('')}
        `;
        
        sidebar.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                const path = e.target.dataset.path;
                window.location.hash = path;
                this.setActive(path);
            });
        });
        
        this.setActive(window.location.hash || '#/dashboard');
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
