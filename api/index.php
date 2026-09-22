<?php

error_reporting(E_ALL);
ini_set('display_errors', '0');

$_ENV['APP_DEBUG'] = 'true';
$_SERVER['APP_DEBUG'] = 'true';
putenv('APP_DEBUG=true');

require __DIR__ . '/../vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();

    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    http_response_code(500);

    echo '<!DOCTYPE html><html><head><title>Error</title></head><body>';
    echo '<h1>' . htmlspecialchars(get_class($e)) . '</h1>';
    echo '<h2>' . htmlspecialchars($e->getMessage()) . '</h2>';
    echo '<p><strong>File:</strong> ' . $e->getFile() . ':' . $e->getLine() . '</p>';
    $prev = $e->getPrevious();
    $i = 0;
    while ($prev && $i < 10) {
        echo '<hr><h3>Previous #' . ($i+1) . ': ' . htmlspecialchars(get_class($prev)) . '</h3>';
        echo '<p>' . htmlspecialchars($prev->getMessage()) . '</p>';
        echo '<p>' . $prev->getFile() . ':' . $prev->getLine() . '</p>';
        $prev = $prev->getPrevious();
        $i++;
    }
    echo '<hr><pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
    echo '</body></html>';
}
