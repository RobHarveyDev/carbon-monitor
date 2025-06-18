<?php

namespace App\Services;

class LowCarbonPeriodFinder
{
    /**
     * Find all 3-hour periods where all bands are 'low' or 'very low'.
     */
    public static function findLowPeriods(array $forecast): array
    {
        $periods = [];
        $datetimes = array_keys($forecast);
        $n = count($datetimes);
        $start = 0;
        while ($start < $n) {
            $window = [];
            for ($i = $start; $i < $n; $i++) {
                $band = $forecast[$datetimes[$i]]['band'] ?? null;
                if (in_array($band, ['low', 'very low'])) {
                    $window[] = $datetimes[$i];
                } else {
                    break;
                }
            }
            // 3 hours = 6 consecutive 30-min increments
            if (count($window) >= 6) {
                $periods[] = [
                    'start' => $window[0],
                    'end' => $window[count($window) - 1],
                ];
                $start += count($window); // skip to after this window
            } else {
                $start++;
            }
        }
        return $periods;
    }
}
