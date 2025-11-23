<?php
$secret = 'mySuperSecretDeployKey123!';
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
$payload = file_get_contents('php://input');

if ($signature !== 'sha1=' . hash_hmac('sha1', $payload, $secret)) {
    http_response_code(403);
    die('Forbidden');
}

// Run deploy script
shell_exec('/home/classicit/playstore.citsolution.xyz/deploy.sh > /dev/null 2>&1 &');

echo "Deployment triggered";
