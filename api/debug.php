<?php

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '0');

echo '<h1>LUWENE Debug</h1>';

echo '<h2>PHP Info</h2>';
echo '<p>PHP Version: ' . phpversion() . '</p>';
echo '<p>Extensions: ' . implode(', ', get_loaded_extensions()) . '</p>';
echo '<p>Memory Limit: ' . ini_get('memory_limit') . '</p>';
echo '<p>Max Execution Time: ' . ini_get('max_execution_time') . '</p>';
echo '<p>Server Software: ' . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A') . '</p>';
echo '<p>Document Root: ' . ($_SERVER['DOCUMENT_ROOT'] ?? 'N/A') . '</p>';
echo '<p>Script Filename: ' . ($_SERVER['SCRIPT_FILENAME'] ?? 'N/A') . '</p>';

echo '<h2>Filesystem Check</h2>';
$root = dirname(__DIR__);
echo '<p>Root dir: ' . $root . '</p>';
echo '<p>vendor/autoload.php exists: ' . (file_exists($root . '/vendor/autoload.php') ? 'YES' : 'NO') . '</p>';
echo '<p>cacert.pem exists: ' . (file_exists($root . '/cacert.php') ? 'YES' : 'NO') . ' (php) / ';
echo (file_exists($root . '/cacert.pem') ? 'YES' : 'NO') . ' (pem)</p>';
echo '<p>bootstrap/app.php exists: ' . (file_exists($root . '/bootstrap/app.php') ? 'YES' : 'NO') . '</p>';
echo '<p>.env exists: ' . (file_exists($root . '/.env') ? 'YES' : 'NO') . '</p>';

echo '<h2>Required Extensions Check</h2>';
$required = ['pdo_mysql', 'mbstring', 'openssl', 'curl', 'json', 'xml', 'bcmath', 'gd', 'fileinfo', 'session', 'tokenizer'];
foreach ($required as $ext) {
    $loaded = extension_loaded($ext);
    echo '<p>' . $ext . ': ' . ($loaded ? '✅ loaded' : '❌ MISSING') . '</p>';
}

echo '<h2>Environment Check</h2>';
echo '<p>APP_DEBUG: ' . (env('APP_DEBUG') ? 'true' : 'false/null') . '</p>';
echo '<p>DB_CONNECTION: ' . env('DB_CONNECTION') . '</p>';
echo '<p>DB_HOST: ' . env('DB_HOST') . '</p>';
echo '<p>DB_PORT: ' . env('DB_PORT') . '</p>';

echo '<h2>Laravel Bootstrap Test</h2>';
try {
    require $root . '/vendor/autoload.php';
    echo '<p>✅ vendor/autoload.php loaded</p>';
} catch (\Throwable $e) {
    echo '<p>❌ autoloader failed: ' . htmlspecialchars($e->getMessage()) . '</p>';
    die();
}

try {
    $app = require $root . '/bootstrap/app.php';
    echo '<p>✅ bootstrap/app.php loaded</p>';
} catch (\Throwable $e) {
    echo '<p>❌ bootstrap failed: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    die();
}

try {
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo '<p>✅ HTTP Kernel resolved</p>';
} catch (\Throwable $e) {
    echo '<p>❌ Kernel resolution failed: ' . htmlspecialchars(get_class($e)) . '</p>';
    echo '<p>Message: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p>File: ' . $e->getFile() . ':' . $e->getLine() . '</p>';

    $prev = $e->getPrevious();
    $depth = 0;
    while ($prev && $depth < 5) {
        echo '<p><strong>Previous #' . ($depth+1) . ':</strong> ' . htmlspecialchars(get_class($prev)) . ' — ' . htmlspecialchars($prev->getMessage()) . '</p>';
        echo '<p>File: ' . $prev->getFile() . ':' . $prev->getLine() . '</p>';
        $prev = $prev->getPrevious();
        $depth++;
    }

    echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    die();
}

echo '<p>✅ All checks passed — kernel handles request normally</p>';
