<?php

declare(strict_types = 1);

namespace TimerAPI;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Server;

class TimerAPI extends PluginBase {

    protected static $instance;
    private array $cooldowns = [];

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
    * Schedules a task to be executed when a specified condition is met.
    *
    * @param callable $callback The callback function to execute.
    * @param callable $conditionCheck The condition check function. Should return true to execute the task.
    */
    /**
    * Schedules a task to be executed when a specified condition is met.
    *
    * @param callable $callback The callback function to execute.
    * @param callable $conditionCheck The condition check function. Should return true to execute the task.
    */
    public static function conditionalTask(callable $callback, callable $conditionCheck): void {
        $task = new ClosureTask(function (int $currentTick) use ($callback, $conditionCheck) {
            if (call_user_func($conditionCheck)) {
                call_user_func($callback, $currentTick);
            }
        });

        // Schedule the ClosureTask as a delayed repeating task with a delay of 1 tick (immediate execution) and an interval of 1 tick.
        self::getInstance()->getScheduler()->scheduleDelayedRepeatingTask($task,
            1,
            1);
    }
    /**
    * Starts a cooldown for the specified player.
    *
    * @param Player $player   The player to start the cooldown for.
    * @param int    $duration The duration of the cooldown in seconds.
    */
    private function startCooldown(Player $player,
        int $duration): void {
        $this->cooldowns[$player->getName()] = time() + $duration;
    }

    /**
    * Checks if the specified player has an active cooldown.
    *
    * @param Player $player The player to check for cooldown.
    *
    * @return bool True if the player has an active cooldown, false otherwise.
    */
    private function hasCooldown(Player $player): bool {
        return isset($this->cooldowns[$player->getName()]) && time() < $this->cooldowns[$player->getName()];
    }

    /**
    * Gets the remaining time in seconds for the cooldown of the specified player.
    *
    * @param Player $player The player to get the cooldown time for.
    *
    * @return int The remaining time in seconds for the cooldown.
    */
    private function getCooldownTimeRemaining(Player $player): int {
        $timeRemaining = $this->cooldowns[$player->getName()] - time();
        return max(0,
            $timeRemaining);
    }
    /**
    * Stops the time in the specified world.
    *
    * @param string $world The name of the world where the time should be stopped.
    */
    public static function stopWorldTime(string $world): void {
        $worldManager = Server::getInstance()->getWorldManager();
        $world = $worldManager->getWorldByName($world);

        if ($world !== null) {
            $world->stopTime();
        }
    }
    /**
    * Starts the time in the specified world.
    *
    * @param string $world The name of the world where the time should be started.
    */
    public static function startWorldTime(string $world): void {
        $worldManager = Server::getInstance()->getWorldManager();
        $world = $worldManager->getWorldByName($world);

        if ($world !== null) {
            $world->startTime();
        }
    }
    /**
    * Stops the specified player from moving and interacting.
    *
    * @param Player $player The player to stop.
    */
    public static function stopPlayer(Player $player): void {
        $player->setNoClientPredictions(true);
    }
    /**
    * Allows the specified player to move and interact again.
    *
    * @param Player $player The player to start.
    */
    public static function startPlayer(Player $player): void {
        $player->setNoClientPredictions(false);
    }

    /**
    * Sets the specified player invincible for a given duration.
    *
    * @param Player $player The player to make invincible.
    * @param int $duration The duration of invincibility in seconds.
    */
    public static function setPlayerInvincibility(Player $player, int $duration): void {
        $originalHealth = $player->getHealth();
        $player->setHealth($player->getMaxHealth()); // Set health to maximum to make the player invincible.

        TimerAPI::wait(function () use ($player, $originalHealth) {
            $player->setHealth($originalHealth); // Restore the player's original health after the duration.
        }, $duration);
    }

    /**
    * Broadcasts a message to all players with a specified delay.
    *
    * @param string $message The message to broadcast.
    * @param int $delay The delay in seconds before broadcasting the message.
    */
    public static function broadcastMessage(string $message, int $delay): void {
        TimerAPI::wait(function () use ($message) {
            Server::getInstance()->broadcastMessage($message);
        }, $delay);
    }

    /**
    * Executes a server command with a specified delay.
    *
    * @param string $command The command to execute.
    * @param int $delay The delay in seconds before executing the command.
    */
    public static function executeCommand(string $command, int $delay): void {
        TimerAPI::wait(function () use ($command) {
            Server::getInstance()->dispatchCommand(new ConsoleCommandSender(), $command);
        }, $delay);
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