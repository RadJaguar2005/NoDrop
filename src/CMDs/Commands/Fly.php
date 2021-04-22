<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Fly extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("fly");
        $this->setDescription("Fly Command, Deaktiviere oder Aktiviere dein Fly Mode");
        $this->main = $main;
    }


    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Fly"))) {
                if (empty($args[0])) {
                    $name = $sender->getName();
                    if (!in_array($name, $this->main->command)) {
                        $this->main->command[] = $name;
                        $sender->sendMessage($message->get("Fly") ["FlyOn"]);
                        $sender->setAllowFlight(true);
                    } else {
                        unset($this->main->command[array_search($name, $this->main->command)]);
                        $player = $sender->getPlayer();
                        $sender->sendMessage($message->get("Fly") ["FlyOff"]);
                        $sender->setAllowFlight(false);
                        $sender->setFlying(false);
                    }
                }
            } else {
                $sender->sendMessage($message->get("Fly") ["NoPerm"]);
            }
        }
        return true;
    }
}