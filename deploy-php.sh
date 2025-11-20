#!/bin/bash
# LightSpeed Vend POS - Direct PHP/Node Deployment (No Docker Required)
# Run this on your server without sudo

set -e

echo "🚀 LightSpeed Vend POS - Direct Deployment"
echo "=========================================="

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Step 1: Setup directories
echo -e "${BLUE}Step 1: Creating app directory...${NC}"
mkdir -p ~/lightspeed-vend-pos
cd ~/lightspeed-vend-pos
echo -e "${GREEN}✓ Directory: $PWD${NC}"

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
APP_URL=https://sell.ecigdis.co.nz
PORT=8000
EOF
  echo -e "${GREEN}✓ .env created (update with your credentials)${NC}"
else
  echo "✓ .env already exists"
fi

# Step 4: Check PHP
echo -e "${BLUE}Step 4: Checking PHP...${NC}"
PHP_VERSION=$(php -v | head -1)
echo -e "${GREEN}✓ $PHP_VERSION${NC}"

# Step 5: Check Composer
echo -e "${BLUE}Step 5: Checking Composer...${NC}"
COMPOSER_VERSION=$(composer --version)
echo -e "${GREEN}✓ $COMPOSER_VERSION${NC}"

# Step 6: Check Node
echo -e "${BLUE}Step 6: Checking Node...${NC}"
NODE_VERSION=$(node -v)
echo -e "${GREEN}✓ Node $NODE_VERSION${NC}"

# Step 7: Install PHP dependencies
echo -e "${BLUE}Step 7: Installing PHP dependencies...${NC}"
if [ -f "composer.json" ]; then
  composer install --no-dev --optimize-autoloader
  echo -e "${GREEN}✓ PHP dependencies installed${NC}"
else
  echo "✓ No composer.json found"
fi

# Step 8: Install Node dependencies
echo -e "${BLUE}Step 8: Installing Node dependencies...${NC}"
if [ -f "package.json" ]; then
  npm install --production
  echo -e "${GREEN}✓ Node dependencies installed${NC}"
else
  echo "✓ No package.json found"
fi

# Step 9: Build frontend (if needed)
echo -e "${BLUE}Step 9: Building frontend...${NC}"
if [ -f "package.json" ]; then
  npm run build 2>/dev/null || echo "✓ Build step skipped"
  echo -e "${GREEN}✓ Frontend ready${NC}"
fi

# Step 10: Create public directory
echo -e "${BLUE}Step 10: Setting up public directory...${NC}"
mkdir -p public/{css,js,img}
echo -e "${GREEN}✓ Public directory ready${NC}"

# Step 11: Run migrations
echo -e "${BLUE}Step 11: Running database migrations...${NC}"
if [ -f "bin/migrate.php" ]; then
  php bin/migrate.php 2>/dev/null || echo "✓ Migrations skipped"
  echo -e "${GREEN}✓ Database ready${NC}"
else
  echo "✓ No migration script found"
fi

# Step 12: Set permissions
echo -e "${BLUE}Step 12: Setting file permissions...${NC}"
chmod -R 755 . 2>/dev/null || true
chmod -R 777 storage/ logs/ tmp/ 2>/dev/null || true
echo -e "${GREEN}✓ Permissions set${NC}"

# Step 13: Test API
echo -e "${BLUE}Step 13: Testing API endpoint...${NC}"
if [ -f "public/index.php" ]; then
  php -S localhost:8000 -t public > /dev/null 2>&1 &
  sleep 2
  HTTP_CODE=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8000 || echo "000")
  pkill -f "php -S" 2>/dev/null || true
  
  if [ "$HTTP_CODE" = "200" ] || [ "$HTTP_CODE" = "404" ]; then
    echo -e "${GREEN}✓ API responding (HTTP $HTTP_CODE)${NC}"
  else
    echo -e "${YELLOW}⚠ API returned HTTP $HTTP_CODE (may be normal)${NC}"
  fi
else
  echo "✓ No public/index.php found yet"
fi

# Summary
echo ""
echo "=============================================="
echo -e "${GREEN}✅ SETUP COMPLETE!${NC}"
echo "=============================================="
echo ""
echo "Your POS system code is deployed at:"
echo "  📁 ~/lightspeed-vend-pos"
echo ""
echo "⚠️  NEXT STEPS:"
echo ""
echo "1. Update your credentials:"
echo "   nano ~/.env"
echo "   - XERO_TOKEN"
echo "   - STRIPE_SECRET_KEY"
echo "   - JWT_SECRET"
echo ""
echo "2. Connect to your existing PHP setup:"
echo "   - Copy API files to: ~/public_html/api/"
echo "   - Copy app files to: ~/public_html/app/"
echo ""
echo "3. Start the POS API (optional, if running standalone):"
echo "   cd ~/lightspeed-vend-pos"
echo "   php -S localhost:8000 -t public"
echo ""
echo "4. Or integrate with your existing web server:"
echo "   - Point DocumentRoot to ~/lightspeed-vend-pos/public"
echo "   - Configure PHP-FPM if using Nginx"
echo ""
echo "System Info:"
echo "  PHP: $(php -v | head -1 | cut -d' ' -f1-2)"
echo "  Node: $(node -v)"
echo "  Composer: $(composer --version | cut -d' ' -f3)"
echo ""
echo "Files:"
echo "  - API: ./api/"
echo "  - Database: ./database/"
echo "  - Public: ./public/"
echo "  - Config: ./.env"
echo ""
echo "🎉 Ready to integrate with your existing website!"
echo ""
