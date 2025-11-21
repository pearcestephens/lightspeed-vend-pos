<?php
// Redirect to public folder or serve from public
$requestUri = $_SERVER['REQUEST_URI'];

// If requesting /pos/ redirect to /pos/public/
if ($requestUri === '/pos' || $requestUri === '/pos/') {
    header('Location: /pos/public/');
    exit;
}

// If in /pos/public/ serve the frontend
if (strpos($requestUri, '/pos/public/') === 0) {
    $file = __DIR__ . '/public' . substr($requestUri, strlen('/pos/public'));
    if (file_exists($file) && is_file($file)) {
        // Serve static files
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimeTypes = [
            'html' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml'
        ];
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
        }
        readfile($file);
        exit;
    }
    // SPA fallback - serve index.html
    readfile(__DIR__ . '/public/index.html');
    exit;
}

// API requests
if (strpos($requestUri, '/pos/api/') === 0) {
    require_once __DIR__ . '/routes/api.php';
    exit;
}

// Default: redirect to public
header('Location: /pos/public/');
?>
