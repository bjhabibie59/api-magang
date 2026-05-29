<?php

namespace App\Helpers;

class GeoHelper
{
    private const EARTH_RADIUS_METERS = 6371000;

    /**
     * Haversine formula — hitung jarak dua koordinat dalam meter
     */
    public static function distanceInMeters(
        float $lat1, float $lon1,
        float $lat2, float $lon2
    ): float {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2))
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return self::EARTH_RADIUS_METERS * $c;
    }

    /**
     * Cek apakah koordinat dalam radius tertentu (meter)
     */
    public static function isWithinRadius(
        float $lat1, float $lon1,
        float $lat2, float $lon2,
        float $radiusInMeters = 100
    ): bool {
        return self::distanceInMeters($lat1, $lon1, $lat2, $lon2) <= $radiusInMeters;
    }
}
