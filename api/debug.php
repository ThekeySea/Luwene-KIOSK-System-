<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

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
    echo '<pre>';
    echo 'ERROR: ' . get_class($e) . "\n";
    echo 'MESSAGE: ' . $e->getMessage() . "\n";
    echo 'FILE: ' . $e->getFile() . "\n";
    echo 'LINE: ' . $e->getLine() . "\n";
    echo "\n--- TRACE ---\n";
    echo $e->getTraceAsString();
    echo '</pre>';
}
