#!/bin/bash

# LightSpeed Vend POS - GitHub Push Script
# This script helps you push your POS system to GitHub with proper configuration

set -e

echo "╔════════════════════════════════════════════════════════════════╗"
echo "║    LightSpeed Vend POS - GitHub Deployment Setup              ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""

# Check if git is configured
if [ -z "$(git config user.name)" ]; then
    echo "⚠️  Git not configured. Setting up..."
    git config user.email "dev@lightspeedpos.local"
    git config user.name "LightSpeed POS Team"
fi

# Display current status
echo "📊 Current Status:"
echo "   Repository: $(git rev-parse --git-dir 2>/dev/null && echo 'Initialized' || echo 'Not initialized')"
echo "   Commits: $(git rev-list --count HEAD 2>/dev/null || echo '0')"
echo "   Current branch: $(git branch --show-current)"
echo ""

# Check for uncommitted changes
if [ -n "$(git status --porcelain)" ]; then
    echo "⚠️  Uncommitted changes detected. Adding to commit..."
    git add .
    git commit -m "Update: System configuration and documentation"
    echo "✅ Changes committed"
fi

# Ask for GitHub username
echo ""
echo "📝 GitHub Configuration:"
read -p "   Enter your GitHub username: " GITHUB_USERNAME
read -p "   Repository name (default: lightspeed-vend-pos): " REPO_NAME
REPO_NAME=${REPO_NAME:-lightspeed-vend-pos}

# Confirm setup
echo ""
echo "🔗 Ready to push to:"
echo "   https://github.com/$GITHUB_USERNAME/$REPO_NAME"
echo ""
read -p "   Is this correct? (y/n): " CONFIRM

if [ "$CONFIRM" != "y" ]; then
    echo "❌ Cancelled"
    exit 1
fi

# Setup remote
echo ""
echo "📡 Configuring GitHub remote..."
GITHUB_URL="https://github.com/$GITHUB_USERNAME/$REPO_NAME.git"

if git remote get-url origin > /dev/null 2>&1; then
    echo "   Updating existing remote..."
    git remote remove origin
fi

git remote add origin "$GITHUB_URL"
echo "✅ Remote configured: $GITHUB_URL"

# Rename branch if needed
CURRENT_BRANCH=$(git branch --show-current)
if [ "$CURRENT_BRANCH" != "main" ]; then
    echo ""
    echo "🔄 Renaming branch to 'main' (GitHub default)..."
    git branch -M main
    echo "✅ Branch renamed to 'main'"
fi

# Push to GitHub
echo ""
echo "🚀 Pushing to GitHub..."
git push -u origin main

echo ""
echo "╔════════════════════════════════════════════════════════════════╗"
echo "║              ✅ Successfully pushed to GitHub!                 ║"
echo "╚════════════════════════════════════════════════════════════════╝"
echo ""
echo "📊 Next Steps:"
echo "   1. Go to: https://github.com/$GITHUB_USERNAME/$REPO_NAME"
echo "   2. Enable GitHub Actions:"
echo "      → Settings → Actions → Enable"
echo "   3. Add secrets:"
echo "      → Settings → Secrets and variables → Actions"
echo "      → Add DATABASE_URL, XERO_*, STRIPE_*, JWT_SECRET"
echo "   4. Configure deployment:"
echo "      → Edit deployment/scripts/deploy.sh with your server info"
echo "   5. Monitor deployments:"
echo "      → Go to Actions tab to see CI/CD status"
echo ""
echo "📚 Documentation:"
echo "   → See GITHUB_DEPLOYMENT.md in your repository"
echo "   → See README.md for system overview"
echo ""
echo "🎉 Your POS system is now on GitHub with automatic CI/CD!"
echo ""
