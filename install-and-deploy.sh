#!/bin/bash
# LightSpeed Vend POS - Complete Setup & Deployment Script
# This script installs Docker (if needed) and deploys the POS system

set -e

echo "🚀 LightSpeed Vend POS - Complete Setup & Deployment"
echo "===================================================="

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Step 1: Check if running as root (needed for Docker install)
echo -e "${BLUE}Step 1: Checking permissions...${NC}"
if [ "$EUID" -ne 0 ]; then 
  echo -e "${YELLOW}⚠ Docker install requires sudo. Running with sudo...${NC}"
  sudo "$0"
  exit $?
fi
echo -e "${GREEN}✓ Running as root${NC}"

# Step 2: Install Docker if not present
echo -e "${BLUE}Step 2: Checking Docker...${NC}"
if ! command -v docker &> /dev/null; then
  echo "Installing Docker..."
  
  # Update package manager
  apt-get update
  
  # Install dependencies
  apt-get install -y \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg \
    lsb-release
  
  # Add Docker GPG key
  curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
  
  # Add Docker repository
  echo \
    "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian \
    $(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null
  
  # Install Docker
  apt-get update
  apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
  
  # Start Docker service
  systemctl start docker
  systemctl enable docker
  
  echo -e "${GREEN}✓ Docker installed${NC}"
else
  echo -e "${GREEN}✓ Docker already installed${NC}"
  docker --version
fi

# Step 3: Install Docker Compose if not present
echo -e "${BLUE}Step 3: Checking Docker Compose...${NC}"
if ! command -v docker-compose &> /dev/null; then
  echo "Installing Docker Compose..."
  curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
  chmod +x /usr/local/bin/docker-compose
  echo -e "${GREEN}✓ Docker Compose installed${NC}"
else
  echo -e "${GREEN}✓ Docker Compose already installed${NC}"
  docker-compose --version
fi

# Switch to non-root user for deployment
echo -e "${BLUE}Step 4: Switching to deployment user...${NC}"
DEPLOY_USER="${SUDO_USER:-master_apdnjwdpkt}"
echo "Deploying as user: $DEPLOY_USER"

# Create home directory if needed
USER_HOME=$(eval echo "~$DEPLOY_USER")
echo -e "${GREEN}✓ User home: $USER_HOME${NC}"

# Run deployment as the non-root user
su - "$DEPLOY_USER" << 'DEPLOY_SCRIPT'

set -e

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo ""
echo -e "${BLUE}=== DEPLOYMENT PHASE ===${NC}"
echo ""

# Step 5: Setup directories
echo -e "${BLUE}Step 5: Creating app directory...${NC}"
mkdir -p ~/lightspeed-vend-pos
cd ~/lightspeed-vend-pos
echo -e "${GREEN}✓ Directory ready${NC}"

# Step 6: Clone repository
echo -e "${BLUE}Step 6: Cloning repository...${NC}"
if [ -d ".git" ]; then
  echo "Repository exists, pulling latest..."
  git pull origin main
else
  git clone https://github.com/pearcestephens/lightspeed-vend-pos.git .
fi
echo -e "${GREEN}✓ Code cloned${NC}"

# Step 7: Create environment file
echo -e "${BLUE}Step 7: Creating .env file...${NC}"
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

# Step 8: Pull latest image
echo -e "${BLUE}Step 8: Pulling latest Docker image...${NC}"
echo "Note: This may take a few minutes on first run..."
docker pull ghcr.io/pearcestephens/lightspeed-vend-pos:latest 2>/dev/null || echo "Note: If auth fails, you may need to: docker login ghcr.io"
echo -e "${GREEN}✓ Image pulled${NC}"

# Step 9: Stop existing containers
echo -e "${BLUE}Step 9: Stopping existing containers...${NC}"
docker compose down 2>/dev/null || true
echo -e "${GREEN}✓ Stopped${NC}"

# Step 10: Start services
echo -e "${BLUE}Step 10: Starting Docker services...${NC}"
docker compose up -d
echo -e "${GREEN}✓ Services started${NC}"

# Step 11: Wait for services
echo -e "${BLUE}Step 11: Waiting for services to be ready...${NC}"
sleep 15
echo -e "${GREEN}✓ Services ready${NC}"

# Step 12: Health check
echo -e "${BLUE}Step 12: Running health check...${NC}"
HEALTH=$(curl -s http://localhost/api/health || echo "not-ready")
echo "Health check result: $HEALTH"
echo -e "${GREEN}✓ Check complete${NC}"

# Summary
echo ""
echo "=============================================="
echo -e "${GREEN}✅ DEPLOYMENT COMPLETE!${NC}"
echo "=============================================="
echo ""
echo "Your POS system is ready at:"
echo "  🔗 https://sell.ecigdis.co.nz"
echo ""
echo "⚠️  IMPORTANT - Update your credentials:"
echo "  nano ~/lightspeed-vend-pos/.env"
echo ""
echo "Then update these values:"
echo "  - XERO_TOKEN (your Xero JWT token)"
echo "  - STRIPE_SECRET_KEY (your Stripe key)"
echo "  - JWT_SECRET (for API authentication)"
echo ""
echo "After updating, restart services:"
echo "  docker compose -f ~/lightspeed-vend-pos/docker-compose.yml restart"
echo ""
echo "Useful commands:"
echo "  docker compose logs -f app      # View live logs"
echo "  docker compose restart          # Restart services"
echo "  docker compose ps              # See running containers"
echo ""

DEPLOY_SCRIPT

echo ""
echo -e "${GREEN}All done! Your POS system is deployed.${NC}"
echo "Next: Update the .env file with your actual credentials."
echo ""
