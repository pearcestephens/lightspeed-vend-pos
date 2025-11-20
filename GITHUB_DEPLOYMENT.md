# GitHub Deployment Guide

Your LightSpeed Vend POS system is ready to deploy to GitHub with automatic CI/CD.

## 🚀 Quick Setup (5 minutes)

### Step 1: Create GitHub Repository

1. Go to https://github.com/new
2. Repository name: `lightspeed-vend-pos`
3. Description: `Enterprise POS system with web order fulfillment, customer portal, and Xero integration`
4. Choose: **Public** or **Private** (your choice)
5. **DO NOT** initialize with README (we already have one)
6. Click **Create repository**

### Step 2: Add Remote and Push

```bash
cd /home/master/applications/hdgwrzntwa/public_html/generator/output

# Add GitHub as remote (replace YOUR_USERNAME)
git remote add origin https://github.com/YOUR_USERNAME/lightspeed-vend-pos.git

# Rename branch to main (GitHub default)
git branch -M main

# Push to GitHub
git push -u origin main
```

After pushing, your repository will be live at:
```
https://github.com/YOUR_USERNAME/lightspeed-vend-pos
```

### Step 3: Enable GitHub Actions (CI/CD)

GitHub Actions are already configured in `.github/workflows/`:

1. Go to your repo on GitHub
2. Click **Actions** tab
3. You should see workflows listed:
   - `test.yml` - Runs tests on every push
   - `deploy.yml` - Deploys to production

They're ready to go!

## 🔧 Configuration

### Step 1: Add Secrets for Deployment

1. Go to repo → **Settings** → **Secrets and variables** → **Actions**
2. Click **New repository secret** and add:

```
DATABASE_URL=mysql://user:password@host/dbname
XERO_CLIENT_ID=your_xero_client_id
XERO_CLIENT_SECRET=your_xero_client_secret
STRIPE_SECRET_KEY=sk_live_your_key
JWT_SECRET=your_jwt_secret_min_32_chars
```

### Step 2: Update Deployment Script

Edit `deployment/scripts/deploy.sh`:

```bash
#!/bin/bash

# Your production server details
DEPLOY_USER=your_user
DEPLOY_HOST=your.production.server
DEPLOY_PATH=/var/www/lightspeed-vend-pos

# Deploy
ssh $DEPLOY_USER@$DEPLOY_HOST << EOF
  cd $DEPLOY_PATH
  git pull origin main
  docker-compose up -d --build
  ./deployment/scripts/health-check.sh
EOF
```

## 📊 Deployment Options

### Option A: GitHub-Hosted (Recommended)

Every push to `main` automatically:
1. Runs tests
2. Builds Docker image
3. Pushes to Docker registry
4. Deploys to your server

Edit `.github/workflows/deploy.yml`:

```yaml
name: Deploy

on:
  push:
    branches: [ main ]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Run tests
        run: npm test

  deploy:
    needs: test
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - name: Deploy to production
        env:
          DEPLOY_KEY: ${{ secrets.DEPLOY_KEY }}
          DEPLOY_HOST: ${{ secrets.DEPLOY_HOST }}
        run: |
          bash deployment/scripts/deploy.sh
```

### Option B: Docker Hub

1. Create Docker Hub account: https://hub.docker.com
2. Add secrets:
   - `DOCKER_USERNAME`
   - `DOCKER_PASSWORD`
3. GitHub Actions will build and push Docker image:
   ```
   docker.io/YOUR_USERNAME/lightspeed-vend-pos:latest
   ```

### Option C: Self-Hosted Runner

For maximum control, use a GitHub self-hosted runner on your server:

```bash
# On your production server:
cd /home/runner
curl -o actions-runner-linux-x64-2.311.0.tar.gz https://github.com/actions/runner/releases/download/v2.311.0/actions-runner-linux-x64-2.311.0.tar.gz
tar xzf actions-runner-linux-x64-2.311.0.tar.gz
./config.sh --url https://github.com/YOUR_USERNAME/lightspeed-vend-pos --token YOUR_TOKEN
./run.sh
```

## 📈 Monitoring Deployments

### View GitHub Actions Log

1. Go to repo → **Actions** tab
2. Click workflow run to see detailed logs
3. View deployment status in real-time

### Health Checks

After deployment, health check runs automatically:

```bash
bash deployment/scripts/health-check.sh
```

Checks:
- ✅ Database connectivity
- ✅ API response time
- ✅ Frontend assets
- ✅ Xero integration
- ✅ Payment processors

## 🔐 Security Best Practices

### 1. Protect Main Branch

1. Go to repo → **Settings** → **Branches**
2. Click **Add rule** and protect `main`:
   - ✅ Require pull request reviews before merging
   - ✅ Dismiss stale pull request approvals
   - ✅ Require status checks to pass before merging

### 2. Regular Updates

```bash
# On your local machine
git pull origin main
git merge upstream/main
git push origin main
```

### 3. Secrets Rotation

Every 3 months:
1. Regenerate OAuth tokens (Xero, Stripe, etc.)
2. Update GitHub secrets
3. Re-deploy

### 4. Environment-Specific Config

Create separate branches for different environments:

```
main (production) → auto-deploys
staging → manual approval
develop → testing only
```

## 🐛 Troubleshooting

### Deployment Failed

1. Check GitHub Actions logs:
   - Go to **Actions** tab
   - Click failed workflow
   - View error details

2. Common issues:
   - Database connection failed → Check `DATABASE_URL` secret
   - Docker build failed → Check `Dockerfile`
   - Health check failed → Check deployment script

### Rollback

If something goes wrong, rollback is one click:

```bash
git revert HEAD~1
git push origin main
# GitHub Actions auto-deploys previous version
```

## 📚 Documentation

Inside your repo:
- **README.md** - System overview and quick start
- **LIGHTSPEED_POS_ECOSYSTEM_COMPLETE.md** - Complete guide
- **LIGHTSPEED_POS_DEPLOYMENT_GUIDE.md** - Deployment instructions
- **database/database.sql** - Database schema

## 🎯 Next Steps

1. ✅ Create GitHub repository
2. ✅ Push code to main branch
3. ✅ Add secrets
4. ✅ Configure deployment script
5. ✅ Enable branch protection
6. ✅ Deploy!

## 📞 Support

For GitHub-specific issues:
- GitHub Docs: https://docs.github.com/actions
- Docker Hub: https://docs.docker.com/
- GitHub Community: https://github.community/

For POS system questions:
- See LIGHTSPEED_POS_ECOSYSTEM_COMPLETE.md

---

**Your system is ready to deploy. Push to GitHub now!**

```bash
git push -u origin main
```

Monitor deployment at: https://github.com/YOUR_USERNAME/lightspeed-vend-pos/actions
