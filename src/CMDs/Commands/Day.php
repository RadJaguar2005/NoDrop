<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Day extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("day");
        $this->setAliases(["tag"]);
        $this->setDescription("Setze die Zeit auf tag");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        $name = $sender->getName();
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Day"))) {
                $sender->getLevel()->setTime("10000");
                $sender->sendMessage($message->get("Day") ["Message"]);
            } else{
                $sender->sendMessage($message->get("Day") ["NoPerm"]);
            }
        }
        return true;
    }
}