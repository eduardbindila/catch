<?php
/**
 * Auto-load Docker secrets from a folder (default: /run/secrets)
 * Each file becomes an entry in the SECRETS constant array.
 *
 * Example:
 *   /run/secrets/core_url  -> SECRETS['core_url'] = "https://core.example.com"
 *   /run/secrets/redis_pass -> SECRETS['redis_pass'] = "super-secret"
 */

// Path to secrets folder
$secretsDir =  '/run/secrets';

// Defensive check
if (!is_dir($secretsDir) || !is_readable($secretsDir)) {
    http_response_code(500);
    die("Secrets folder not found or not readable: $secretsDir");
}

$secrets = [];

// Iterate through all files in the folder
foreach (scandir($secretsDir) as $file) {
    if ($file === '.' || $file === '..') {
        continue; // skip system entries
    }

    $path = $secretsDir . DIRECTORY_SEPARATOR . $file;

    // Only handle readable files
    if (is_file($path) && is_readable($path)) {
        // File content (trim to remove newlines)
        $content = trim(file_get_contents($path));

        // Add to array (key = filename)
        $secrets[$file] = $content;
    }
}

// Define the global constant once
if (!defined('SECRETS')) {
    define('SECRETS', $secrets);
}

/* === Example usage anywhere ===
echo SECRETS['core_url'];
echo SECRETS['redis_pass'];
*/
