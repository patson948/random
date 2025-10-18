<?php
/**
 * Temporary cache clearing script for production
 * Upload this to your public_html folder and access via browser
 * DELETE THIS FILE after use for security!
 */

// Navigate to the Laravel root directory
chdir(__DIR__);

// Clear configuration cache
if (file_exists('bootstrap/cache/config.php')) {
    unlink('bootstrap/cache/config.php');
    echo "✓ Config cache cleared<br>";
} else {
    echo "• No config cache found<br>";
}

// Clear route cache
if (file_exists('bootstrap/cache/routes-v7.php')) {
    unlink('bootstrap/cache/routes-v7.php');
    echo "✓ Route cache cleared<br>";
} else {
    echo "• No route cache found<br>";
}

// Clear view cache
$viewCachePath = 'storage/framework/views';
if (is_dir($viewCachePath)) {
    $files = glob($viewCachePath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ View cache cleared<br>";
}

// Clear application cache
$cachePath = 'storage/framework/cache/data';
if (is_dir($cachePath)) {
    $files = glob($cachePath . '/*/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ Application cache cleared<br>";
}

echo "<br><strong style='color: green;'>All caches cleared successfully!</strong><br>";
echo "<br><strong style='color: red;'>⚠️ IMPORTANT: Delete this file (clear-cache.php) now for security!</strong>";
?>

