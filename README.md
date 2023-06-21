# TimerAPI

TimerAPI is a plugin that allows you to schedule delayed tasks and repeating tasks in your PocketMine-MP plugins. It provides a convenient way to execute commands or code snippets after a specified delay or at regular intervals.

## Features

- Schedule delayed tasks with `TimerAPI::wait`.
- Schedule repeating tasks with `TimerAPI::repeat`.

## Usage

### Scheduling Delayed Tasks

To schedule a task to be executed after a specified delay, use the `scheduleDelayedTask` method:

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

## Example

Here's an example of scheduling a delayed task and a repeating task:

```php
use TimerAPI\TimerAPI;

TimerAPI::wait(function() {
    // Code to be executed after the delay
}, 10);

TimerAPI::repeat(function() {
    // Code to be executed repeatedly
}, 5, 10);
```

In the example above, the first task will be executed after a delay of 10 seconds, and the second task will be executed every 5 seconds for a total of 10 repetitions.

Please note that TimerAPI is an external plugin that you need to install and depend on in your PocketMine-MP project. Refer to the TimerAPI documentation for installation instructions and further details.
