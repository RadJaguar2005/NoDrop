<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Feed extends Command {

    private $main;

    public function __construct(Cmds $main ){
        parent::__construct("feed");
        $this->setDescription("Feed Command");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Feed"))) {
            $sender->setFood(20);
            $sender->sendMessage($message->get("Feed") ["Message"]);
            } else {
                $sender->sendMessage($message->get("Feed") ["NoPerm"]);
            }
        }
        return true;
    }
}