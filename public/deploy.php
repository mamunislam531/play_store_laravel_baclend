<?php
$secret = 'H8f93K@2Ls!pQz7Wb1NhXy49';
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
$payload = file_get_contents('php://input');

if ($signature !== 'sha1=' . hash_hmac('sha1', $payload, $secret)) {
    http_response_code(403);
    die('Forbidden');
}


$projectPath = '/home/classicit/playstore.citsolution.xyz';
chdir($projectPath);

// Run deployment commands
$output = shell_exec('
git reset --hard &&
git clean -f -d &&
git pull origin main &&
composer install --no-dev --optimize-autoloader &&
php artisan migrate --force &&
php artisan config:cache &&
php artisan route:cache &&
php artisan view:clear
2>&1
');

file_put_contents($projectPath.'/deploy.log', date('Y-m-d H:i:s') . ":\n" . $output . "\n\n", FILE_APPEND);

echo "Deployment triggered. Check deploy.log for details.";
