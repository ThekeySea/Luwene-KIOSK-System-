<?php

namespace App\Services;

class DistanceService
{
    private const EARTH_RADIUS_KM = 6371;

    public static function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $lat1 = deg2rad($lat1);
        $lng1 = deg2rad($lng1);
        $lat2 = deg2rad($lat2);
        $lng2 = deg2rad($lng2);

        $dLat = $lat2 - $lat1;
        $dLng = $lng2 - $lng1;

        $a = sin($dLat / 2) ** 2 + cos($lat1) * cos($lat2) * sin($dLng / 2) ** 2;
        $c = 2 * asin(sqrt($a));

        return self::EARTH_RADIUS_KM * $c;
    }

    public static function distanceInKm(float $lat1, float $lng1, float $lat2, float $lng2): string
    {
        $km = self::haversine($lat1, $lng1, $lat2, $lng2);

        return $km < 1 ? round($km * 1000) . ' m' : round($km, 1) . ' km';
    }

    public static function estimateMinutes(float $distanceKm): int
    {
        $speedKmh = 30;
        $prepMinutes = 10;

        return (int) ceil(($distanceKm / $speedKmh) * 60) + $prepMinutes;
    }
}
