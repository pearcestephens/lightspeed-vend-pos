# GitHub Actions Setup Instructions

Your CI/CD workflows are now fully configured and ready to deploy!

## 📋 Required Repository Secrets

Add these 6 secrets to GitHub: https://github.com/pearcestephens/lightspeed-vend-pos/settings/secrets/actions

### 1. DATABASE_URL (Already Added ✅)
```
mysql://[USERNAME]:[PASSWORD]@[HOST]:3306/[DATABASE]
```
(Your MariaDB connection string)

### 2. XERO_TOKEN (Already Added ✅)
Your long-term JWT token with all necessary scopes.

### 3. STRIPE_SECRET_KEY (Already Added ✅)
```
sk_test_[YOUR_STRIPE_KEY]
```
(Your test mode secret key from Stripe dashboard)

### 4. JWT_SECRET (Already Added ✅)
```
[YOUR_BASE64_ENCODED_SECRET]
```
(A randomly generated base64-encoded secret string)

### 5. DEPLOY_SSH_KEY (⚠️ NEED TO ADD)
Your SSH private key for deployment:
```
-----BEGIN OPENSSH PRIVATE KEY-----
[Your private key here]
-----END OPENSSH PRIVATE KEY-----
```

Get your SSH key:
```bash
cat ~/.ssh/id_rsa
```

Or generate a new one:
```bash
ssh-keygen -t rsa -b 4096 -f ~/.ssh/deploy_key
```

### 6. DEPLOY_HOST (⚠️ NEED TO ADD)
Your production server hostname or IP:
```
sell.ecigdis.co.nz
```

### 7. DEPLOY_USER (⚠️ NEED TO ADD)
Your SSH user on the production server:
```
master_apdnjwdpkt
```

### 8. SLACK_WEBHOOK_URL (Optional)
For Slack notifications on deploy success/failure:
```
https://hooks.slack.com/services/YOUR/WEBHOOK/URL
```

Get your Slack webhook: https://api.slack.com/messaging/webhooks

---

## 🔧 How to Add Secrets to GitHub

1. Go to: https://github.com/pearcestephens/lightspeed-vend-pos/settings/secrets/actions
2. Click **"New repository secret"** for each one above
3. Paste the value
4. Click **"Add secret"**

---

## ✅ Your Workflows

### test.yml
**Runs on:** Every push to main/develop, all PRs
**Does:**
- Sets up PHP 8.2 and Node 20
- Starts MariaDB and Redis test services
- Installs dependencies (Composer + npm)
- Runs PHPUnit tests
- Runs ESLint linting
- Builds frontend (npm run build)
- Uploads coverage to Codecov

### deploy.yml
**Runs on:** Every push to main only
**Does:**
- Builds Docker image from your Dockerfile
- Pushes to GitHub Container Registry
- SSHes to your production server
- Pulls latest code
- Runs docker compose up
- Runs database migrations
- Health checks API
- Notifies Slack on success/failure

---

## 🚀 Workflow Execution Timeline

```
1. You: git push to main
         ↓
2. GitHub: Detects push, triggers workflows
         ↓
3. test.yml runs:
   - Checkout code (30s)
   - Setup PHP/Node (1m)
   - Install deps (1m)
   - Run tests (2-3m)
   - Build frontend (2m)
   ━━━━━━━━━━━━━ TOTAL: ~7-8 minutes
         ↓
4. If tests pass → deploy.yml runs:
   - Build Docker image (3-5m)
   - Push to registry (1m)
   - Deploy to production (2-3m)
   - Health checks (1m)
   - Slack notification
   ━━━━━━━━━━━━━ TOTAL: ~7-10 minutes
```

---

## 📊 Current Status

| Component | Status |
|-----------|--------|
| test.yml | ✅ Ready |
| deploy.yml | ✅ Ready |
| Docker build | ✅ Configured |
| SSH deployment | ⚠️ Needs DEPLOY_SSH_KEY |
| Slack notifications | ⚠️ Optional |

---

## 🎯 Quick Start

1. **Add missing secrets** (DEPLOY_SSH_KEY, DEPLOY_HOST, DEPLOY_USER)
2. **Push to main**:
   ```bash
   git push origin main
   ```
3. **Watch deployment**:
   https://github.com/pearcestephens/lightspeed-vend-pos/actions

---

## 🔍 Monitoring Deployment

### Real-time logs:
https://github.com/pearcestephens/lightspeed-vend-pos/actions

### Check specific workflow:
- Click the workflow run
- Click the job name (test or deploy)
- See live output

### If deployment fails:
1. Check the error in GitHub Actions logs
2. Common issues:
   - SSH key not found → add DEPLOY_SSH_KEY
   - Connection refused → add DEPLOY_HOST
   - Permission denied → check DEPLOY_USER
   - Docker not running → SSH to server and start Docker

---

## 🛠️ Manual Testing (If You Want)

Test your setup locally:

```bash
# Build Docker image
docker build -f deployment/Dockerfile -t lightspeed-vend-pos .

# Run locally
docker compose -f deployment/docker-compose.yml up

# Check health
curl http://localhost/api/health

# Logs
docker compose -f deployment/docker-compose.yml logs app
```

---

## 📞 Support

If workflows fail, common fixes:

| Error | Fix |
|-------|-----|
| `Permission denied (publickey)` | Add DEPLOY_SSH_KEY secret |
| `Connection refused` | Check DEPLOY_HOST and DEPLOY_USER |
| `Database connection failed` | Verify DATABASE_URL format |
| `Stripe/Xero integration error` | Check token expiration |
| `npm install fails` | Delete package-lock.json, re-push |

---

## ✨ Next Steps

1. Add the 3 missing deploy secrets
2. Push a test commit to main
3. Watch GitHub Actions run
4. Verify deployment succeeded
5. Test POS system at https://sell.ecigdis.co.nz/api/health

**Once configured, your CI/CD will automatically:**
- Test every push
- Build Docker images
- Deploy to production
- Send Slack notifications
- Keep your system live and updated

🎉 **Your LightSpeed Vend POS is now fully automated!**
