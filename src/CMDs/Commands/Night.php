<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Night extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("night"); # 181000
        $this->setAliases(["nacht"]);
        $this->setDescription("Setzte die Zeit auf Nacht");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        $name = $sender->getName();
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Night"))) {
                $sender->getLevel()->setTime("181000");
                $sender->sendMessage($message->get("Night") ["Message"]);
            } else{
                $sender->sendMessage($message->get("Night") ["NoPerm"]);
            }
        }
        return true;
    }
}
