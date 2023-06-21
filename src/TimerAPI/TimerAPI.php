<?php

declare(strict_types = 1);

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
        $this->getLogger()->info("§aSuccessfully enabled TimerAPI!");
    }

    // TODO: Add task scheduling methods and task cancellation

    /**
    * Waits for a specified duration and then executes a callback function.
    *
    * @param callable $callback The callback function to execute.
    * @param int      $duration The duration to wait in seconds.
    */
    public static function wait(callable $callback, int $duration): void {
        TimerAPI::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask($callback), $duration * 20);
    }

    /**
    * Schedules a task to be repeated at a specified interval for a specific number of repetitions.
    *
    * @param callable $callback     The callback function to execute.
    * @param int      $interval     The interval between each repetition in seconds.
    * @param int      $repetitions  The number of times the task should be repeated.
    */
    public static function repeat(callable $callback, int $interval, int $repetitions): void {
        $task = new ClosureTask($callback);
        $scheduler = TimerAPI::getInstance()->getScheduler();
        $scheduler->scheduleRepeatingTask($task, $interval * 20, $repetitions);
    }

    /**
    * Schedules a task to be repeated at a specified interval for a specific number of repetitions.
    *
    * @param callable $callback     The callback function to execute.
    * @param int      $delay        The delay in seconds before the first execution.
    * @param int      $repetitions  The number of times the task should be repeated.
    */
    public static function repeatWait(callable $callback, int $delay, int $repetitions): void {
        $scheduler = TimerAPI::getInstance()->getScheduler();
        $task = new ClosureTask($callback);
        $delayTicks = $delay * 20;

        // Schedule a delayed repeating task
        $taskHandler = $scheduler->scheduleDelayedRepeatingTask($task, $delayTicks, $delayTicks);
    }
    /**
    * Cancels all scheduled tasks.
    */
    public static function killall(): void {
        // Get the scheduler instance
        $scheduler = TimerAPI::getInstance()->getScheduler();

        // Cancel all tasks
        $scheduler->cancelAllTasks();
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