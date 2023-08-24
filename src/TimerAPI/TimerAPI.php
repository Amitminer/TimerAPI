<?php

declare(strict_types = 1);

namespace TimerAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\item\Item;
use pocketmine\player\Player;

class TimerAPI extends PluginBase
{
    /**
    * @var self The TimerAPI instance.
    */
    private static self $instance;
    
    /**
    * @var array<string, array<string, mixed>> Cooldown data.
    */
    private array $cooldowns = [];

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getLogger()->info("§aSuccessfully enabled TimerAPI!");
    }

    /**
    * Waits for a specified duration and then executes a callback function.
    *
    * @param \Closure $callback The callback function to execute.
    * @param int $duration The duration to wait in seconds.
    */
    public static function wait(\Closure $callback, int $duration): void
    {
        TimerAPI::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask($callback), $duration * 20);
    }

    /**
    * Schedules a task to be repeated at a specified interval for a specific number of repetitions.
    *
    * @param \Closure $callback The callback function to execute.
    * @param int $interval The interval between each repetition in seconds.
    */
    public static function repeat(\Closure $callback, int $interval): void
    {
        $task = new ClosureTask($callback);
        $scheduler = TimerAPI::getInstance()->getScheduler();
        $scheduler->scheduleRepeatingTask($task, $interval * 20);
    }

    /**
    * Schedules a task to be repeated at a specified interval for a specific number of repetitions.
    *
    * @param \Closure $callback The callback function to execute.
    * @param int $delay The delay in seconds before the first execution.
    * @param int $repetitions The number of times the task should be repeated.
    */
    public static function repeatWait(\Closure $callback, int $delay, int $repetitions): void
    {
        $scheduler = TimerAPI::getInstance()->getScheduler();
        $task = new ClosureTask($callback);
        $delayTicks = $delay * 20;

        // Schedule a delayed repeating task
        $taskHandler = $scheduler->scheduleDelayedRepeatingTask($task, $delayTicks, $delayTicks);
    }

    /**
    * Cancels all scheduled tasks.
    */
    public static function killall(): void
    {
        // Get the scheduler instance
        $scheduler = TimerAPI::getInstance()->getScheduler();

        // Cancel all tasks
        $scheduler->cancelAllTasks();
    }

    /**
    * Starts a cooldown for the specified player for a given item.
    *
    * @param Player $player The player for whom the cooldown is started.
    * @param int $duration The duration of the cooldown in seconds.
    * @param Item $item The item associated with the cooldown.
    */
    public static function startCooldown(Player $player, int $duration, Item $item): void
    {
        if ($item->hasCustomName()) {
            $itemName = $item->getCustomName();
        } else {
            $itemName = $item->getName();
        }
        $itemTypeId = $item->getTypeId();
        $playerName = $player->getName();

        if (!isset(TimerAPI::$cooldowns[$playerName])) {
            TimerAPI::$cooldowns[$playerName] = [];
        }

        TimerAPI::$cooldowns[$player->getName()][$itemName] = [
            'time' => time() + $duration,
            'itemTypeId' => $itemTypeId,
        ];
    }

    /**
    * Checks if the player has an active cooldown for a specific item.
    *
    * @param Player $player The player to check the cooldown for.
    * @param Item $item The item to check the cooldown for.
    * @return bool Whether the player has an active cooldown for the item.
    */
    public static function hasCooldown(Player $player, Item $item): bool
    {
        // Check if the player's data exists and if the item is on cooldown
        if ($item->hasCustomName()) {
            $itemName = $item->getCustomName();
        } else {
            $itemName = $item->getName();
        }
        $itemTypeId = $item->getTypeId();
        if (isset(TimerAPI::$cooldowns[$player->getName()][$itemName])) {
            $cooldownData = TimerAPI::$cooldowns[$player->getName()][$itemName];

            if (time() < $cooldownData['time'] && $itemTypeId === $cooldownData['itemTypeId']) {
                return true;
            }
        }

        return false;
    }

    /**
    * Gets the remaining time in seconds for the player's cooldown for a specific item.
    *
    * @param Player $player The player for whom to retrieve the cooldown time.
    * @param Item $item The item associated with the cooldown.
    * @return int The remaining time in seconds for the cooldown.
    */
    public static function getCooldownTimeRemaining(Player $player, Item $item): int
    {
        // Check if the player's data exists and if the item is on cooldown
        if ($item->hasCustomName()) {
            $itemName = $item->getCustomName();
        } else {
            $itemName = $item->getName();
        }
        if (isset(TimerAPI::$cooldowns[$player->getName()][$itemName])) {
            $timeRemaining = TimerAPI::$cooldowns[$player->getName()][$itemName]['time'] - time();
            return intval(max(0, $timeRemaining));
        }

        return 0;
    }

    /**
    * Gets the instance of the TimerAPI plugin.
    *
    * @return TimerAPI The TimerAPI instance.
    */
    public static function getInstance(): self
    {
        return TimerAPI::$instance;
    }
}