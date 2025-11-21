# Auto-Deployment Setup

The GitHub Actions workflow will automatically deploy to your Cloudways server on every push to `main`.

## Required GitHub Secrets

Add these secrets in your GitHub repository settings:
**Settings → Secrets and variables → Actions → New repository secret**

### 1. SSH_PRIVATE_KEY
Your SSH private key for accessing the server.

```bash
# Generate if you don't have one:
ssh-keygen -t ed25519 -f ~/.ssh/lightspeed_deploy -N ""

# Copy the PRIVATE key (entire contents including BEGIN/END lines):
cat ~/.ssh/lightspeed_deploy

# Copy the PUBLIC key to server:
ssh-copy-id -i ~/.ssh/lightspeed_deploy.pub master_apdnjwdpkt@104.156.232.62
```

**Add to GitHub Secret:** Copy entire private key content

### 2. SERVER_IP
```
104.156.232.62
```

### 3. SERVER_USER
```
master_apdnjwdpkt
```

## Deployment Process

When you push to `main`:
1. ✅ Docker image builds and pushes to GitHub Container Registry
2. ✅ SSH connects to Cloudways server
3. ✅ Backs up current version (if exists)
4. ✅ Clones/pulls latest code from GitHub
5. ✅ Installs Composer dependencies
6. ✅ Builds frontend (npm install + build)
7. ✅ Sets permissions
8. ✅ Live at https://sell.ecigdis.co.nz/pos

## Manual Deployment (if needed)

```bash
ssh master_apdnjwdpkt@104.156.232.62

cd ~/applications/nsvmswhebv/public_html

# First time setup
git clone https://github.com/pearcestephens/lightspeed-vend-pos.git pos
cd pos

# Or update existing
cd pos
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
cd frontend && npm install --legacy-peer-deps && npm run build

# Access at: https://sell.ecigdis.co.nz/pos
```

## Verification

After deployment, check:
- https://sell.ecigdis.co.nz/pos/routes/health.php
- Should return JSON with database connection status

## Rollback

If something goes wrong:
```bash
ssh master_apdnjwdpkt@104.156.232.62
cd ~/applications/nsvmswhebv/public_html
rm -rf pos
mv lightspeed-pos-backup pos
```

## Logs

View deployment logs:
- GitHub Actions: https://github.com/pearcestephens/lightspeed-vend-pos/actions
- Server logs: `~/applications/nsvmswhebv/logs/`
