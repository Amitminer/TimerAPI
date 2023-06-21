# TimerAPI

TimerAPI is a plugin that allows you to schedule delayed tasks and repeating tasks in your PocketMine-MP plugins. It provides a convenient way to execute commands or code snippets after a specified delay or at regular intervals.

## Features

- Schedule delayed tasks with `TimerAPI::wait`.
- Schedule repeating tasks with `TimerAPI::repeat`.
- Schedule delayed repeating tasks with `TimerAPI::repeatWait`.
- Cancel all scheduled tasks with `TimerAPI::killall`.

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

## Example

Here's an example of scheduling a delayed task, a repeating task, a delayed repeating task, and cancelling all tasks:

```php
use TimerAPI\TimerAPI;

TimerAPI::wait(function() {
    // Code to be executed after the delay
}, 10);

TimerAPI::repeat(function() {
    // Code to be executed repeatedly
}, 5, 10);

TimerAPI::repeatWait(function() {
    // Code to be executed repeatedly after the delay
}, 15, 8);

TimerAPI::killall();
```

In the example above, the first task will be executed after a delay of 10 seconds, the second task will be executed every 5 seconds for a total of 10 repetitions, the third task will be executed after a delay of 15 seconds and then repeated 8 times, and finally, all tasks will be cancelled.

Please note that TimerAPI is an external plugin that you need to install and depend on in your PocketMine-MP project. Refer to the TimerAPI documentation for installation instructions and further details.
