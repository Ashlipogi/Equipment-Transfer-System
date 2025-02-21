<?php

// Autoload dependencies
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel app
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Handle the incoming request through Laravel's Kernel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Send the response back to the browser
$response->send();

// Terminate the application (handle things like session cleanup)
$kernel->terminate($request, $response);
