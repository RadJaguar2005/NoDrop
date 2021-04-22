<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class TpAll extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("tpall");
        $this->setDescription("Telepotiere alle Online Spieler zu dir");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("TpAll"))) {
                if (($count = count($this->main->getServer()->getOnlinePlayers())) < 1 || ($sender instanceof Player && $count < 2)) {
                    $sender->sendMessage(str_replace('{max}', "2", $message->get("TpAll") ["MaxPlayers"]));
                    return false;
                }
                foreach ($this->main->getServer()->getOnlinePlayers() as $players) {
                    if ($players !== $sender) {
                        $players->teleport($sender);
                        $players->sendMessage(str_replace('{sender}', $sender->getName(), $message->get("TpAll") ["Players"]));
                    }
                }
                $sender->sendMessage($message->get("TpAll") ["Sender"]);
            } else {
                $sender->sendMessage($message->get("TpAll") ["NoPerm"]);
            }
        }
        return true;
    }
}