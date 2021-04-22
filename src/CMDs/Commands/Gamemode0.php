<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Gamemode0 extends Command {
    private $main;

    public function __construct(Cmds $main ){
        parent::__construct("gm 0");
        $this->setAliases(["gms", "gm0"]);
        $this->setDescription("Setzte dich in den gm 0");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Gamemode") ["0"])) {
                $sender->setGamemode(0);
                $sender->sendMessage($message->get("GM0") ["Message"]);
            } else {
                $sender->sendMessage($message->get("GM0") ["NoPerm"]);
            }
        }
        return true;
    }
}