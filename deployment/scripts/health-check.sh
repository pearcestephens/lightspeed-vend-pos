#!/bin/bash

# Health check script
HEALTH_ENDPOINT="http://localhost/health"
TIMEOUT=5

response=$(curl -s -o /dev/null -w "%{http_code}" --max-time $TIMEOUT "$HEALTH_ENDPOINT")

if [ $response -eq 200 ]; then
    echo "✅ Health check passed"
    exit 0
else
    echo "❌ Health check failed with status $response"
    exit 1
fi