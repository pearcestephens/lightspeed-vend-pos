export class State {
    constructor() {
        this.data = {
            user: null,
            cart: [],
            products: [],
            customers: [],
            settings: {}
        };
        this.listeners = {};
    }
    
    get(key) {
        return this.data[key];
    }
    
    set(key, value) {
        this.data[key] = value;
        this.notify(key);
    }
    
    on(key, callback) {
        if (!this.listeners[key]) {
            this.listeners[key] = [];
        }
        this.listeners[key].push(callback);
    }
    
    notify(key) {
        if (this.listeners[key]) {
            this.listeners[key].forEach(callback => callback(this.data[key]));
        }
    }
}
