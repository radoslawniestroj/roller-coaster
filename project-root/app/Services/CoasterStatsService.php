<?php

namespace App\Services;

use App\Libraries\RedisService;

class CoasterStatsService
{
    protected RedisService $redis;

    public function __construct()
    {
        $this->redis = service('redisService');
    }

    public function evaluateCoaster(array $coaster): array
    {
        $problems = [];
        $routeLength = $coaster['dl_trasy'] ?? 0;
        $from = $this->toMinutes($coaster['godziny_od'] ?? '00:00');
        $to = $this->toMinutes($coaster['godziny_do'] ?? '00:00');
        $availableTime = $to - $from;

        $wagons = $coaster['wagons'] ?? [];
        $customersAmount = $coaster['liczba_klientow'] ?? 0;
        $staffAmount = $coaster['liczba_personelu'] ?? 0;

        $totalCapacity = 0;
        $neededPersonnel = 1 + count($wagons) * 2;

        foreach ($wagons as $wagon) {
            $speed = $wagon['predkosc_wagonu'] ?? 0;
            $seatAmount = $wagon['ilosc_miejsc'] ?? 0;

            if ($speed <= 0) {
                continue;
            }

            $travelTime = ($routeLength / $speed) * 2 / 60;
            $travelTime += 5;
            $numberOfRides = (int) floor($availableTime / $travelTime);

            $totalCapacity += $numberOfRides * $seatAmount;
        }

        if ($staffAmount < $neededPersonnel) {
            $problems[] = sprintf('Brakuje %s pracowników', ($neededPersonnel - $staffAmount));
        } elseif ($staffAmount > $neededPersonnel * 2) {
            $problems[] = sprintf('Zbyt dużo personelu: nadmiar %s', ($staffAmount - $neededPersonnel));
        }

        if ($totalCapacity < $customersAmount) {
            $problems[] = sprintf('Brakuje wydajności: %s klientów nie zostanie obsłużony', ($customersAmount - $totalCapacity));
        } elseif ($totalCapacity > $customersAmount * 2) {
            $problems[] = sprintf('Zbyt duża moc przerobowa: nadmiar na %s klientów', ($totalCapacity - $customersAmount));
        }

        return [
            'godziny' => sprintf('%s - %s', $coaster['godziny_od'], $coaster['godziny_do']),
            'wagonow' => count($wagons),
            'personel' => "$staffAmount/$neededPersonnel",
            'klientow' => $customersAmount,
            'pojemnosc' => $totalCapacity,
            'problemy' => $problems,
        ];
    }

    protected function toMinutes(string $hhmm): int
    {
        [$h, $m] = explode(':', $hhmm);
        return ((int) $h) * 60 + (int) $m;
    }
}