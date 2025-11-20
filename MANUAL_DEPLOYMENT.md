# Manual Deployment Guide

Your Docker image is now automatically built and pushed to GitHub Container Registry on every push to `main`.

## Deploy to Your Server (sell.ecigdis.co.nz)

### 1. SSH to Your Server

```bash
ssh master_apdnjwdpkt@sell.ecigdis.co.nz
```

### 2. Create App Directory

```bash
mkdir -p ~/lightspeed-vend-pos
cd ~/lightspeed-vend-pos
```

### 3. Clone the Repository

```bash
git clone https://github.com/pearcestephens/lightspeed-vend-pos.git .
```

### 4. Create Environment File

```bash
cat > .env << 'EOF'
DATABASE_URL=mysql://[USERNAME]:[PASSWORD]@localhost:3306/[DATABASE]
XERO_TOKEN=[YOUR_XERO_JWT_TOKEN]
STRIPE_SECRET_KEY=[YOUR_STRIPE_SECRET_KEY]
JWT_SECRET=[YOUR_JWT_SECRET]
APP_ENV=production
APP_DEBUG=false
EOF
```

### 5. Update docker-compose.yml (if needed)

Edit `docker-compose.yml` to match your server setup:
- Database host (currently `localhost`)
- Port mappings
- Volume mounts

### 6. Pull Latest Image

```bash
docker login ghcr.io
docker pull ghcr.io/pearcestephens/lightspeed-vend-pos:latest
```

### 7. Start Services

```bash
docker compose up -d
```

### 8. Run Migrations

```bash
docker compose exec app php bin/migrate.php
```

### 9. Verify Deployment

```bash
curl http://localhost/api/health
# Should return: {"status":"ok"}
```

## Access Your POS System

Once deployed:

- **POS Register**: https://sell.ecigdis.co.nz/pos
- **Dashboard**: https://sell.ecigdis.co.nz/dashboard
- **API Health**: https://sell.ecigdis.co.nz/api/health

## Auto-Deployment on Push

Every time you push to `main`, GitHub Actions will:
1. Run tests
2. Build Docker image
3. Push to GitHub Container Registry

You can then pull the latest image and redeploy.

## Troubleshooting

### Check logs
```bash
docker compose logs -f app
```

### Restart services
```bash
docker compose restart
```

### Full reset
```bash
docker compose down
docker compose up -d
```

## Files Generated

Your repository includes:

- **`Dockerfile`** - Multi-stage build for PHP + Node
- **`docker-compose.yml`** - Complete service stack
- **`.github/workflows/`** - Automated CI/CD
- **`database/`** - Database schema and migrations
- **`api/`** - REST API endpoints
- **`app/`** - Application code

Everything is ready to deploy! 🚀
