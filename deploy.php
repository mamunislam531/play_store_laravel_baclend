<?php
$secret = 'H8f93K@2Ls!pQz7Wb1NhXy49';
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
$payload = file_get_contents('php://input');

// Verify GitHub secret
if ($signature !== 'sha1=' . hash_hmac('sha1', $payload, $secret)) {
    http_response_code(403);
    die('Forbidden');
}

// Project root path
$projectPath = '/home/classicit/playstore.citsolution.xyz';
chdir($projectPath);

// Run commands directly
$output = shell_exec('
git reset --hard &&
git clean -f -d &&
git pull origin main &&
composer install --no-dev --optimize-autoloader &&
php artisan migrate --force &&
php artisan config:cache &&
php artisan route:cache &&
php artisan view:cache
2>&1
');

// Log deployment output
file_put_contents($projectPath.'/deploy.log', date('Y-m-d H:i:s') . ":\n" . $output . "\n\n", FILE_APPEND);

echo "Deployment triggered. Check deploy.log for details.";
