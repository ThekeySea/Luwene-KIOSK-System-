<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('database.default') !== 'mysql') {
            return;
        }

        $currentCa = config('database.connections.mysql.options.' . \PDO::MYSQL_ATTR_SSL_CA);

        if ($currentCa && file_exists($currentCa)) {
            return;
        }

        $caPath = '/tmp/tidb-ca.pem';
        if (!file_exists($caPath)) {
            $candidates = [
                base_path('cacert.pem'),
                base_path('vendor/guzzlehttp/guzzle/src/cacert.pem'),
            ];
            foreach ($candidates as $candidate) {
                if (file_exists($candidate)) {
                    file_put_contents($caPath, file_get_contents($candidate));
                    break;
                }
            }
        }

        if (file_exists($caPath)) {
            config(['database.connections.mysql.options' => array_merge(
                config('database.connections.mysql.options', []),
                [\PDO::MYSQL_ATTR_SSL_CA => $caPath]
            )]);
        }
    }
}
