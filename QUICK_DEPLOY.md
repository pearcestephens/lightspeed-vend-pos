# 🚀 Quick Deploy Guide

Your LightSpeed Vend POS system is fully ready to deploy!

## Deploy in 3 Steps

### Step 1: SSH to Your Server
```bash
ssh master_apdnjwdpkt@sell.ecigdis.co.nz
```

### Step 2: Download & Run Deployment Script
```bash
curl -O https://raw.githubusercontent.com/pearcestephens/lightspeed-vend-pos/main/deploy.sh
chmod +x deploy.sh
./deploy.sh
```

### Step 3: Update Credentials (when prompted)
Edit the `.env` file with your actual secrets:
```bash
nano .env
```

That's it! Your POS system will be live at **https://sell.ecigdis.co.nz** ✅

---

## What Gets Deployed

✅ **Complete POS System**
- POS Register with barcode scanning
- Web Order Fulfillment
- Customer Portal
- Inventory Management
- Real-time Xero sync
- Stripe payment processing
- Advanced auditing & reporting

✅ **Infrastructure**
- Docker containerization
- Automated CI/CD pipeline
- Database with 100+ tables
- 50+ API endpoints

✅ **Features**
- Multi-location support
- Staff management
- Discount & loyalty programs
- Click & Collect
- Hardware integration

---

## System Architecture

```
GitHub Repository
    ↓
GitHub Actions (Test & Build)
    ↓
Docker Image (ghcr.io)
    ↓
Your Server (Docker Compose)
    ↓
Live POS System
```

Every push to `main` automatically:
1. Runs tests
2. Builds Docker image
3. Pushes to registry
4. Ready for you to deploy

---

## Access After Deployment

- **POS Register**: https://sell.ecigdis.co.nz/pos
- **Dashboard**: https://sell.ecigdis.co.nz/dashboard
- **API**: https://sell.ecigdis.co.nz/api
- **Customer Portal**: https://sell.ecigdis.co.nz/portal

---

## Support

If you need help:
1. Check logs: `docker compose logs -f app`
2. Restart: `docker compose restart`
3. Redeploy: `./deploy.sh`

---

**Repository:** https://github.com/pearcestephens/lightspeed-vend-pos

**Ready to launch!** 🎉
