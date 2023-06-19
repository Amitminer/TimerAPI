# TimerAPI

TimerAPI is a plugin that helps you easily schedule delayed tasks in your PocketMine-MP plugins. It provides a simple and convenient way to execute commands or code snippets after a specified delay.

## Features

- `scheduleDelayedTask`: Schedule a task to be executed after a specified delay.

## Usage

Here's an example of how to use the TimerAPI's `scheduleDelayedTask` method:

```php
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use TimerAPI\TimerAPI;

class MyPlugin extends PluginBase {

    public function onEnable() {
        // ...

        $duration = 5;
        TimerAPI::wait(function() use ($player, $duration) {
            $player->sendMessage("Command executed after delay!");
        }, $duration);
    }

    // ...
}
