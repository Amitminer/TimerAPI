# TimerAPI

TimerAPI is a plugin that allows you to schedule delayed tasks and repeating tasks in your PocketMine-MP plugins. It provides a convenient way to execute commands or code snippets after a specified delay or at regular intervals.

## Features

- Schedule delayed tasks with `TimerAPI::wait`.
- Schedule repeating tasks with `TimerAPI::repeat`.
- Schedule delayed repeating tasks with `TimerAPI::repeatWait`.
- Cancel all scheduled tasks with `TimerAPI::killall`.
- Manage cooldowns for players with the CooldownAPI.
- Add Cooldown to player with
`TimerAPI::startCooldown($player,$duration,$item);`
- Check Player has Cooldown or not with
`TimerAPI::hasCooldown($player,$duration,$item);`
- Get remaining time of cooldown with
`TimerAPI::getCooldownTimeRemaining($player,$item);`

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
}, $interval);
```

Replace `$interval` with the desired interval in seconds. task should be repeated.

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
TimerAPI::startCooldown($player, $duration,$item);

// Check if a player has an active cooldown
$hasCooldown = TimerAPI::hasCooldown($player,$item);

// Get the remaining time of a player's cooldown
$remainingTime = TimerAPI::getCooldownTimeRemaining($player,$item);
```

Please note that TimerAPI is an external plugin that you need to install and depend on in your PocketMine-MP project. Refer to the TimerAPI documentation for installation instructions and further details.
