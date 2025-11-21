// Import all modules
import { Router } from './modules/1-router.js';
import { API } from './modules/2-api.js';
import { State } from './modules/3-state.js';
import { Navigation } from './modules/4-navigation.js';
import { Dashboard } from './modules/5-dashboard.js';
import { POSRegister } from './modules/6-pos-register.js';
import { Inventory } from './modules/7-inventory.js';
import { Customers } from './modules/8-customers.js';
import { Reports } from './modules/9-reports.js';
import { Settings } from './modules/10-settings.js';

class App {
    constructor() {
        this.state = new State();
        this.api = new API();
        this.router = new Router();
        this.navigation = new Navigation();
        
        // Register pages
        this.pages = {
            dashboard: new Dashboard(this.state, this.api),
            register: new POSRegister(this.state, this.api),
            inventory: new Inventory(this.state, this.api),
            customers: new Customers(this.state, this.api),
            reports: new Reports(this.state, this.api),
            settings: new Settings(this.state, this.api)
        };
        
        this.init();
    }
    
    init() {
        this.navigation.render();
        this.setupRouting();
        this.router.navigate(window.location.hash || '#/dashboard');
    }
    
    setupRouting() {
        this.router.on('/dashboard', () => this.pages.dashboard.render());
        this.router.on('/register', () => this.pages.register.render());
        this.router.on('/inventory', () => this.pages.inventory.render());
        this.router.on('/customers', () => this.pages.customers.render());
        this.router.on('/reports', () => this.pages.reports.render());
        this.router.on('/settings', () => this.pages.settings.render());
    }
}

// Initialize app
window.addEventListener('DOMContentLoaded', () => {
    window.app = new App();
});
