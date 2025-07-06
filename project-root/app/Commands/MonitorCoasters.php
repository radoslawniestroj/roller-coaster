<?php

namespace App\Commands;

use App\Controllers\Coaster;
use App\Libraries\RedisService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Services\CoasterStatsService;
use CodeIgniter\CLI\Commands;
use Psr\Log\LoggerInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;

class MonitorCoasters extends BaseCommand
{
    protected $group = 'App';
    protected $name = 'monitor:coasters';
    protected $description = 'Monitoruje stan kolejek górskich i wypisuje problemy.';

    protected RedisService $redis;
    protected LoopInterface $loop;
    protected CoasterStatsService $statsService;

    public function __construct(LoggerInterface $logger, Commands $commands)
    {
        $this->redis = service('redisService');
        $this->loop = Loop::get();
        $this->statsService = new CoasterStatsService();
        parent::__construct($logger, $commands);
    }

    public function run(array $params): void
    {
        $redis = $this->redis;
        $stats = $this->statsService;

        $this->loop->addPeriodicTimer(5, function () use ($redis, $stats) {
            $keys = $redis->keys(sprintf('%s:*', Coaster::ID_KEY));
            CLI::clearScreen();
            CLI::newLine(2);
            CLI::write("[Godzina " . date('H:i:s') . "]\n", 'green');

            foreach ($keys as $key) {
                $coaster = json_decode($redis->get($key), true);
                $status = $stats->evaluateCoaster($coaster);

                if (!empty($status['problemy'])) {
                    foreach ($status['problemy'] as $problem) {
                        $msg = '[' . date('Y-m-d H:i:s') . "] {$key} - Problem: $problem";
                        log_message('warning', $msg);
                    }

                    $message = "5. Problem";
                    $parameter = implode(' | ', $status['problemy']);
                    $color = "red";
                } else {
                    $message = "5. Status";
                    $parameter = "OK";
                    $color = "blue";
                }

                CLI::write(sprintf("[Kolejka %s]", $key), 'green');
                $this->cliWrite("1. Godziny działania", $status['godziny']);
                $this->cliWrite("2. Liczba wagonów:", $status['wagonow']);
                $this->cliWrite("3. Dostępny personel:", $status['personel']);
                $this->cliWrite("4. Klienci dziennie:", $status['klientow']);
                $this->cliWrite($message, $parameter, $color);
                CLI::newLine();
            }
        });

        $this->loop->run();
    }

    private function cliWrite($message, $parameter = null, $color = null): void
    {
        CLI::write(sprintf("    %s: %s", $message, $parameter), $color);
    }
}
