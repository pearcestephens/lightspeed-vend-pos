export class Router {
    constructor() {
        this.routes = {};
        window.addEventListener('hashchange', () => this.handleRoute());
    }
    
    on(path, handler) {
        this.routes[path] = handler;
    }
    
    navigate(hash) {
        window.location.hash = hash;
    }
    
    handleRoute() {
        const path = window.location.hash.slice(1) || '/dashboard';
        const handler = this.routes[path];
        if (handler) {
            handler();
        }
    }
}
