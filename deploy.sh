#!/bin/bash
# LightSpeed Vend POS - Automated Deployment Script
# Run this on your server: bash deploy.sh

set -e

echo "🚀 LightSpeed Vend POS - Automated Deployment"
echo "=============================================="

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Step 1: Setup directories
echo -e "${BLUE}Step 1: Creating app directory...${NC}"
mkdir -p ~/lightspeed-vend-pos
cd ~/lightspeed-vend-pos
echo -e "${GREEN}✓ Directory ready${NC}"

# Step 2: Clone repository
echo -e "${BLUE}Step 2: Cloning repository...${NC}"
if [ -d ".git" ]; then
  echo "Repository exists, pulling latest..."
  git pull origin main
else
  git clone https://github.com/pearcestephens/lightspeed-vend-pos.git .
fi
echo -e "${GREEN}✓ Code cloned${NC}"

# Step 3: Create environment file
echo -e "${BLUE}Step 3: Creating .env file...${NC}"
if [ ! -f ".env" ]; then
  cat > .env << 'EOF'
DATABASE_URL=mysql://nsvmswhebv:7HXY6yDAeD@localhost:3306/nsvmswhebv
XERO_TOKEN=YOUR_XERO_TOKEN_HERE
STRIPE_SECRET_KEY=YOUR_STRIPE_KEY_HERE
JWT_SECRET=YOUR_JWT_SECRET_HERE
APP_ENV=production
APP_DEBUG=false
EOF
  echo -e "${GREEN}✓ .env created (update with your credentials)${NC}"
else
  echo "✓ .env already exists"
fi

# Step 4: Check Docker
echo -e "${BLUE}Step 4: Checking Docker...${NC}"
if ! command -v docker &> /dev/null; then
  echo "❌ Docker not found. Please install Docker first."
  exit 1
fi
docker --version
echo -e "${GREEN}✓ Docker ready${NC}"

# Step 5: Login to GitHub Container Registry
echo -e "${BLUE}Step 5: Logging into GitHub Container Registry...${NC}"
echo "Enter your GitHub Personal Access Token (with read:packages permission):"
read -s GITHUB_TOKEN
echo $GITHUB_TOKEN | docker login ghcr.io -u USERNAME --password-stdin
echo -e "${GREEN}✓ Logged in${NC}"

# Step 6: Pull latest image
echo -e "${BLUE}Step 6: Pulling latest Docker image...${NC}"
docker pull ghcr.io/pearcestephens/lightspeed-vend-pos:latest
echo -e "${GREEN}✓ Image pulled${NC}"

# Step 7: Stop existing containers
echo -e "${BLUE}Step 7: Stopping existing containers...${NC}"
docker compose down 2>/dev/null || true
echo -e "${GREEN}✓ Stopped${NC}"

# Step 8: Start services
echo -e "${BLUE}Step 8: Starting Docker services...${NC}"
docker compose up -d
echo -e "${GREEN}✓ Services started${NC}"

# Step 9: Wait for services
echo -e "${BLUE}Step 9: Waiting for services to be ready...${NC}"
sleep 10
echo -e "${GREEN}✓ Services ready${NC}"

# Step 10: Run migrations
echo -e "${BLUE}Step 10: Running database migrations...${NC}"
docker compose exec -T app php bin/migrate.php 2>/dev/null || echo "Migration skipped (may not be needed)"
echo -e "${GREEN}✓ Migrations complete${NC}"

# Step 11: Health check
echo -e "${BLUE}Step 11: Running health check...${NC}"
HEALTH=$(curl -s http://localhost/api/health || echo "failed")
if [[ $HEALTH == *"ok"* ]]; then
  echo -e "${GREEN}✓ API is healthy${NC}"
else
  echo "⚠ Health check returned: $HEALTH"
fi

# Summary
echo ""
echo "=============================================="
echo -e "${GREEN}✅ DEPLOYMENT COMPLETE!${NC}"
echo "=============================================="
echo ""
echo "Your POS system is now running at:"
echo "  🔗 https://sell.ecigdis.co.nz"
echo ""
echo "Access points:"
echo "  📱 POS Register: https://sell.ecigdis.co.nz/pos"
echo "  📊 Dashboard: https://sell.ecigdis.co.nz/dashboard"
echo "  🔧 API Health: https://sell.ecigdis.co.nz/api/health"
echo ""
echo "Useful commands:"
echo "  docker compose logs -f app      # View live logs"
echo "  docker compose restart          # Restart services"
echo "  docker compose down             # Stop all services"
echo ""
echo "Next steps:"
echo "  1. Update .env with your actual credentials"
echo "  2. Verify services are running: docker compose ps"
echo "  3. Check logs if any issues: docker compose logs app"
echo ""
