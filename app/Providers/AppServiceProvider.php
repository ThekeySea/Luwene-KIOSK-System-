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
        $sslCa = config('database.connections.mysql.options.' . \PDO::MYSQL_ATTR_SSL_CA);

        if ($sslCa && !file_exists($sslCa)) {
            $caPath = '/tmp/tidb-ca.pem';
            if (!file_exists($caPath)) {
                file_put_contents($caPath, $sslCa);
            }
            config(['database.connections.mysql.options' => [
                \PDO::MYSQL_ATTR_SSL_CA => $caPath,
            ]]);
        }
    }
}
