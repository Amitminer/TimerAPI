<?php

declare(strict_types=1);

namespace TimerAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;

class TimerAPI extends PluginBase {

    protected static $instance;

    public function onLoad(): void {
        self::$instance = $this;
    }

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("§aSuccessfully enabled TimerAPI!");
    }

    /**
     * Waits for a specified duration and then executes a callback function.
     *
     * @param callable $callback The callback function to execute.
     * @param int      $duration The duration to wait in seconds.
     */
    public static function wait(callable $callback, int $duration): void {
        timer::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask($callback), $duration * 20);
    }

    /**
     * Gets the instance of the TimerAPI plugin.
     *
     * @return TimerAPI The TimerAPI instance.
     */
    public static function getInstance(): self {
        return self::$instance;
    }
}
