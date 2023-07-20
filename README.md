# TimerAPI

TimerAPI is a plugin that allows you to schedule delayed tasks and repeating tasks in your PocketMine-MP plugins. It provides a convenient way to execute commands or code snippets after a specified delay or at regular intervals.

## Features

- Schedule delayed tasks with `TimerAPI::wait`.
- Schedule repeating tasks with `TimerAPI::repeat`.
- Schedule delayed repeating tasks with `TimerAPI::repeatWait`.
- Cancel all scheduled tasks with `TimerAPI::killall`.
- Manage cooldowns for players with the CooldownAPI.
- Stop and start world time with `TimerAPI::stopWorldTime` and `TimerAPI::startWorldTime` methods.
- Stop and start player movement and interactions with `TimerAPI::stopPlayer` and `TimerAPI::startPlayer` methods.
- Set players invincible for a specified duration using `TimerAPI::setPlayerInvincibility` method.
- Broadcast messages to all players with a specified delay using `TimerAPI::broadcastMessage` method.
- Execute server commands with a specified delay using `TimerAPI::executeCommand` method.

## Usage
## Usage

### Scheduling Delayed Tasks

To schedule a task to be executed after a specified delay, use the `wait` method:

```php
use TimerAPI\TimerAPI;

TimerAPI::wait(function() {
    // Code to be executed after the delay
}, $delay);
```

Replace `$delay` with the desired delay in seconds.

### Scheduling Repeating Tasks

To schedule a task to be executed repeatedly at a specified interval, use the `repeat` method:

```php
use TimerAPI\TimerAPI;

TimerAPI::repeat(function() {
    // Code to be executed repeatedly
}, $interval, $repetitions);
```

Replace `$interval` with the desired interval in seconds and `$repetitions` with the number of times the task should be repeated.

### Scheduling Delayed Repeating Tasks

To schedule a task to be repeated at a specified interval for a specific number of repetitions, after a delay, use the `repeatWait` method:

```php
use TimerAPI\TimerAPI;

TimerAPI::repeatWait(function() {
    // Code to be executed repeatedly after the delay
}, $delay, $repetitions);
```

Replace `$delay` with the delay in seconds before the first execution, and `$repetitions` with the number of times the task should be repeated.

### Cancelling Tasks

To cancel all scheduled tasks, use the `killall` method:

```php
use TimerAPI\TimerAPI;

TimerAPI::killall();
```

This will cancel all tasks that have been scheduled using TimerAPI.

### Managing Cooldowns

You can manage cooldowns for players using the CooldownAPI. Here's how to start a cooldown for a player, check if a player has an active cooldown, and get the remaining time of a player's cooldown:

```php
use TimerAPI\TimerAPI;

// Start a cooldown for a player with the specified duration
TimerAPI::startCooldown($player, $duration);

// Check if a player has an active cooldown
$hasCooldown = TimerAPI::hasCooldown($player);

// Get the remaining time of a player's cooldown
$remainingTime = TimerAPI::getCooldownTimeRemaining($player);
```

### Stopping and Starting World Time

You can control the time in a specific world by stopping and starting it with the following methods:

```php
use TimerAPI\TimerAPI;

// Stop the time in the specified world
TimerAPI::stopWorldTime($world);

// Start the time in the specified world
TimerAPI::startWorldTime($world);
```

### Stopping and Starting Player Interactions

You can prevent a player from moving and interacting and then allow them to do so again using the following methods:

```php
use TimerAPI\TimerAPI;

// Stop the specified player from moving and interacting
TimerAPI::stopPlayer($player);

// Allow the specified player to move and interact again
TimerAPI::startPlayer($player);
```

### Setting Player Invincibility

You can make a player invincible for a specified duration using the `setPlayerInvincibility` method:

```php
use TimerAPI\TimerAPI;

// Make the player invincible for a given duration
TimerAPI::setPlayerInvincibility($player, $duration);
```

### Broadcasting Messages and Executing Commands

You can broadcast messages to all players with a specified delay and execute server commands after a delay using the following methods:

```php
use TimerAPI\TimerAPI;

// Broadcast a message to all players with a specified delay
TimerAPI::broadcastMessage($message, $delay);

// Execute a server command with a specified delay
TimerAPI::executeCommand($command, $delay);
```

Please note that TimerAPI is an external plugin that you need to install and depend on in your PocketMine-MP project. Refer to the TimerAPI documentation for installation instructions and further details.
