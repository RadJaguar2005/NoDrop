<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Gamemode1 extends Command {

    private $main;

    public function __construct(Cmds $main ){
        parent::__construct("gm 1");
        $this->setAliases(["gmc", "gm1"]);
        $this->setDescription("Setze dich in den gm 1");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Gamemode") ["1"])) {
                $sender->setGamemode(1);
                $sender->sendMessage($message->get("GM1") ["Message"]);
            } else {
                $sender->sendMessage($message->get("GM1") ["NoPerm"]);
            }
        }
        return true;
    }
}