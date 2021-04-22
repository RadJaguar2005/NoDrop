<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Gamemode3 extends Command {

    private $main;

    public function __construct(Cmds $main ){
        parent::__construct("gm 3");
        $this->setAliases(["gms", "gm3"]);
        $this->setDescription("Setze dich in den gm 3");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Gamemode") ["3"])) {
                $sender->setGamemode(0);
                $sender->sendMessage($message->get("GM3") ["Message"]);
            } else {
                $sender->sendMessage($message->get("GM3") ["NoPerm"]);
            }
        }
        return true;
    }
}
