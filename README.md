# LightSpeed Vend POS - Enterprise Edition

A complete, production-ready Point of Sale system built from the ground up for modern retail operations. Replaces Vend with more advanced features, flexibility, and control—at a fraction of the cost.

## 🎯 What This Is

**LightSpeed Vend POS** is an open-source, self-hosted POS system that includes:

- ✅ **POS Register** - Barcode scanning, EFTPOS, receipt printing, offline capability
- ✅ **Web Order Fulfillment** - Pick lists, packing slips, shipping labels, Slack integration
- ✅ **Customer Portal** - Purchase history, loyalty points, one-click reorder
- ✅ **Website Integration API** - 50+ endpoints for real-time inventory sync, web orders, customer data
- ✅ **Inventory Management** - Single source of truth, real-time stock, prevent overselling
- ✅ **Reporting & Analytics** - 20+ pre-built reports, dashboards, financial insights
- ✅ **Xero Integration** - Real-time invoice creation, bank reconciliation, P&L sync
- ✅ **Advanced Auditing** - Transaction logging, compliance reports, security camera integration

## 🚀 Quick Start

### Option 1: Docker (Recommended)

```bash
# Clone the repository
git clone https://github.com/pearcestephens/lightspeed-vend-pos.git
cd lightspeed-vend-pos

# Start with Docker
docker-compose up -d

# Install frontend dependencies
cd frontend
npm install
npm run dev
```

Access the system at `http://localhost`

### Option 2: Manual Installation

```bash
# 1. Database
mysql -u root -p < database/database.sql

# 2. Backend
cp .env.example .env
# Edit .env with your configuration

# 3. Frontend
cd frontend
npm install
npm run build

# 4. Start
npm run preview
```

## 📊 System Architecture

```
┌─────────────────────────────────────────────────────────┐
│                    Your Website (PHP)                   │
│         (Existing e-commerce platform)                  │
└────────────────┬────────────────────────────────────────┘
                 │ API Calls (REST)
                 ↓
┌─────────────────────────────────────────────────────────┐
│            API Gateway / Load Balancer                   │
│          (50+ Integration Endpoints)                     │
└────────────────┬────────────────────────────────────────┘
                 │
    ┌────────────┼────────────┐
    ↓            ↓            ↓
┌─────────┐ ┌─────────┐ ┌─────────┐
│   POS   │ │ Fulfill │ │ Portal  │
│Register │ │ment     │ │ & Admin │
│         │ │ Screen  │ │         │
└─────────┘ └─────────┘ └─────────┘
    │            │            │
    └────────────┼────────────┘
                 │
    ┌────────────┼────────────────────┐
    ↓            ↓                    ↓
┌─────────┐ ┌──────────┐ ┌──────────────┐
│ Xero    │ │ Stripe / │ │ Security     │
│ Real-   │ │ Square / │ │ Cameras &    │
│ time    │ │ PayPal   │ │ Auditing     │
└─────────┘ └──────────┘ └──────────────┘
    │
┌───────────────────────────────────────┐
│      MariaDB Database                 │
│      (100+ Tables)                    │
│  • POS Sales & Inventory              │
│  • Web Orders & Fulfillment           │
│  • Customers & Loyalty                │
│  • Audit Logs & Compliance            │
└───────────────────────────────────────┘
```

## 📁 Project Structure

```
├── api/                          # Backend REST API (PHP)
│   ├── routes/
│   │   └── api.php              # 50+ endpoints
│   ├── BaseController.php        # Base request/response handling
│   ├── BaseRequest.php           # Input validation
│   └── APIResponse.php           # JSON response formatting
│
├── database/                     # Database schema
│   ├── database.sql             # 100+ tables
│   └── migration_001_initial.php # Laravel migration
│
├── frontend/                     # Svelte SPA application
│   ├── src/
│   │   ├── routes/              # 18 pages
│   │   │   ├── +page.svelte     # Dashboard
│   │   │   ├── pos_register     # POS screen
│   │   │   ├── web_orders_queue # Fulfillment
│   │   │   ├── customer_portal  # Portal features
│   │   │   └── reports/         # Analytics
│   │   ├── components/          # 20+ reusable components
│   │   └── stores.ts            # Svelte stores for state
│   ├── package.json
│   ├── vite.config.js
│   └── svelte.config.js
│
└── deployment/                   # DevOps & Infrastructure
    ├── Dockerfile               # Multi-stage build
    ├── docker-compose.yml       # Local development
    ├── k8s/                     # Kubernetes manifests
    │   ├── deployment.yaml
    │   ├── service.yaml
    │   ├── configmap.yaml
    │   └── ingress.yaml
    ├── .github/workflows/
    │   ├── test.yml            # Automated testing
    │   └── deploy.yml          # Auto-deployment on push
    └── scripts/
        ├── deploy.sh           # Deployment script
        └── health-check.sh     # Health monitoring
```

## 🎯 Key Features

### POS Register
- Barcode scanning with lookup
- Multiple payment methods (card, cash, Afterpay, bank transfer)
- Receipt printing (receipt printer or PDF)
- Offline mode with queue-based sync
- Staff login with role-based permissions
- Inventory tracking on every sale
- Discounts & gift cards
- Refunds & returns

### Web Order Fulfillment
- Web orders appear on POS screen in real-time
- Staff picks items with barcode scanning
- Pick lists auto-generated (with product barcodes)
- Packing slips auto-generated (with shipping address)
- Shipping labels printed to thermal printer
- Staff workflow: Acknowledge → Pick → Pack → Ready
- Slack notifications for new orders
- Real-time status updates sent back to website

### Customer Portal
- Login with email/password
- View purchase history (from POS receipts)
- Loyalty points tracking
- One-click reorder from past purchases
- Request refunds/returns
- Track web orders
- Save favorite products
- AI product recommendations

### Website Integration
- REST API with 50+ endpoints
- Real-time inventory sync (no overselling)
- Web order ingestion
- Customer data sync
- Webhook notifications
- API key authentication
- JWT tokens
- Rate limiting

### Reporting & Analytics
- Sales reports (daily, hourly, by product, by staff, by payment method)
- Inventory reports (stock levels, movement, accuracy)
- Financial reports (revenue, margins, tax)
- Customer analytics (top customers, repeat purchases)
- Staff performance (transactions, revenue, discounts)
- Web order analytics (fulfillment time, return rate)
- Xero reconciliation report

### Xero Integration
- Real-time invoice creation on POS sale
- Automatic credit notes from refunds
- Bank reconciliation
- Tax code mapping
- Multi-currency support
- P&L sync
- Balance sheet data

### Advanced Auditing
- Transaction-level audit logs
- Inventory audit trail (adjustments, transfers, stock takes)
- User activity tracking (login, configuration changes)
- Compliance reports (PCI DSS, GDPR)
- Incident reporting with auto-anomaly detection
- Security camera integration (Hikvision, Uniview, RTSP)
- User approval workflows

## 🔧 Technology Stack

| Layer | Technology |
|-------|-----------|
| **Frontend** | Svelte 4, TypeScript, Vite, TailwindCSS |
| **Backend** | PHP 8.2, Composer |
| **Database** | MariaDB 10.5 |
| **Cache** | Redis 7 |
| **Payments** | Stripe, Square, PayPal |
| **Accounting** | Xero API (real-time) |
| **SMS** | Twilio |
| **Chat** | Slack |
| **Deployment** | Docker, Kubernetes, GitHub Actions |
| **Monitoring** | Health checks, logging, error tracking |

## 🚀 Deployment Options

### Option 1: Docker (Development & Small Business)
```bash
docker-compose up -d
npm install && npm run dev
```
- Local testing
- Single server deployment
- ~2 minute setup time

### Option 2: GitHub Auto-Deploy (Recommended)
Every push to `main` branch automatically:
1. Runs tests
2. Builds Docker image
3. Deploys to production
4. Runs health checks

```bash
git add .
git commit -m "Feature: Add new report"
git push origin main
# Automatically deployed!
```

### Option 3: Kubernetes (Enterprise Scale)
```bash
kubectl apply -f deployment/k8s/
kubectl get pods
```
- Multi-region deployment
- High availability (3+ replicas)
- Auto-scaling
- Load balancing
- Rolling updates

## 🔐 Security

- ✅ **JWT Authentication** - Secure API tokens
- ✅ **API Key Management** - Rate limiting, key rotation
- ✅ **PCI DSS Compliance** - No credit card storage
- ✅ **Encryption** - TLS for all connections
- ✅ **Audit Logging** - Every transaction logged
- ✅ **Role-based Access** - Granular permissions
- ✅ **Offline Integrity** - Queue-based sync with conflict resolution

## 📊 Database

**100+ Tables** organized in categories:

- **POS**: stores, staff, products, sales, customers, registers (15 tables)
- **Web Orders**: orders, items, fulfillment, pick lists, packing slips, labels (9 tables)
- **Customer Portal**: accounts, sessions, saved carts, wishlist, returns, rewards (6 tables)
- **Website Integration**: api_keys, sync_logs, webhooks (6 tables)
- **Inventory**: adjustments, audits, reorders, suppliers, purchase orders (12 tables)
- **Reporting**: daily, shift, inventory, financial, performance reports (8 tables)
- **Auditing**: transaction, inventory, user, system, compliance, incidents (10 tables)
- **Plus**: loyalty, discounts, tax, transfers, refunds, settings (40+ more tables)

See `database/database.sql` for complete schema.

## 🤝 Integration with Your Website

Your website and the POS system communicate via REST API:

### Get Real-Time Inventory
```php
$response = $http->get('https://pos.example.com/api/inventory/stock-levels', [
    'headers' => ['Authorization' => 'Bearer ' . $apiToken]
]);
$stock = json_decode($response->getBody());
```

### Send Web Order to POS
```php
$response = $http->post('https://pos.example.com/api/web-orders/create', [
    'json' => [
        'customer_id' => $customerId,
        'items' => [
            ['product_id' => 123, 'quantity' => 2, 'price' => 29.99]
        ],
        'delivery_address' => $shippingAddress,
        'webhook_url' => 'https://yoursite.com/webhooks/pos'
    ],
    'headers' => ['Authorization' => 'Bearer ' . $apiToken]
]);
```

### Receive Order Status Updates (Webhook)
```php
// When order status changes, POS sends POST to your webhook
// Body contains: order_id, status (acknowledged/picking/packing/ready/completed), timestamp
```

See `LIGHTSPEED_POS_ECOSYSTEM_COMPLETE.md` for complete API documentation.

## 📈 Comparison vs Vend

| Feature | Vend | LightSpeed POS |
|---------|------|--|
| Monthly Cost | $50-200/user | One-time setup |
| Data Hosting | Vend's cloud | Your servers |
| Customization | Limited | Unlimited (open source) |
| Web Order Fulfillment | ❌ Not built in | ✅ Full workflow |
| Customer Portal | ❌ Separate | ✅ Integrated |
| Xero Integration | ✅ Extra cost | ✅ Built-in |
| API Endpoints | 15 | 50+ |
| Offline Mode | ❌ Manual sync | ✅ Automatic |
| Hardware Control | ❌ Limited | ✅ Full |
| Multi-store | ✅ Extra cost | ✅ Built-in |
| Audit Trail | ✅ Basic | ✅ Enterprise-grade |
| Custom Reports | ❌ No | ✅ Yes |

## 📚 Documentation

- **[LIGHTSPEED_POS_ECOSYSTEM_COMPLETE.md](../LIGHTSPEED_POS_ECOSYSTEM_COMPLETE.md)** - Complete system guide
- **[LIGHTSPEED_POS_DEPLOYMENT_GUIDE.md](../LIGHTSPEED_POS_DEPLOYMENT_GUIDE.md)** - Deployment instructions
- **[LIGHTSPEED_POS_ADVANCED_FEATURES.md](../LIGHTSPEED_POS_ADVANCED_FEATURES.md)** - Feature deep-dive
- **[GENERATOR_INDEX.md](../GENERATOR_INDEX.md)** - Generator system overview

## 🛠️ Configuration

Create `.env` file:

```env
# Database
DB_HOST=localhost
DB_PORT=3306
DB_NAME=lightspeed_vend_pos
DB_USER=root
DB_PASSWORD=your_password

# Xero Integration
XERO_CLIENT_ID=your_client_id
XERO_CLIENT_SECRET=your_client_secret
XERO_TENANT_ID=your_tenant_id

# Payment Processing
STRIPE_SECRET_KEY=sk_live_...
STRIPE_PUBLIC_KEY=pk_live_...
SQUARE_ACCESS_TOKEN=sq_...
PAYPAL_CLIENT_ID=...

# Twilio (SMS notifications)
TWILIO_ACCOUNT_SID=...
TWILIO_AUTH_TOKEN=...
TWILIO_PHONE_NUMBER=+1...

# Slack (Staff notifications)
SLACK_WEBHOOK_URL=https://hooks.slack.com/services/...

# Security
JWT_SECRET=your_jwt_secret_key_min_32_chars
API_KEY_PREFIX=sk_live_

# Environment
APP_ENV=production
APP_DEBUG=false
```

## 🚦 Health Checks

The system includes automated health checks:

```bash
./deployment/scripts/health-check.sh

# Output:
# ✅ Database: OK
# ✅ API: OK (Response time: 45ms)
# ✅ Frontend: OK
# ✅ Xero Integration: OK
# ✅ Payment Processors: OK
```

## 📞 Support

For issues, feature requests, or questions:

1. Check the documentation in the `docs/` directory
2. Review the `LIGHTSPEED_POS_ECOSYSTEM_COMPLETE.md` guide
3. Create a GitHub issue

## 📄 License

This project is provided as-is. Modify and deploy as needed for your business.

## 🎉 What's Next?

1. **Deploy locally** - Test the system with Docker
2. **Configure integrations** - Set up Xero, payment processors, Twilio
3. **Integrate website** - Call API endpoints from your existing site
4. **Go live** - Deploy to production

Everything is ready. Start with:

```bash
docker-compose up -d
```

Questions? See the comprehensive documentation above.

---

**Built with ❤️ for modern retail**  
Generated: November 2025  
Ready to deploy: YES
