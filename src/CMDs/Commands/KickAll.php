<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class KickAll extends Command { # Coming Soon
    
    private $main;
    
    public function __construct(Cmds $main) {
        parent::__construct("kickall");
        $this->setDescription("Kicke alle Spieler vom Server");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("KickAll"))) {
                if(($count = count($this->main->getServer()->getOnlinePlayers())) < 1 || ($sender instanceof Player && $count < 2)){
                    $sender->sendMessage(str_replace("{max}", "2", $message->get("KickAll") ["MaxPlayers"]));
                    return false;
                }
                if(count($args) < 1){
                    $reason = "Unknown";
                }else{
                    $reason = implode(" ", $args);
                }
                foreach($this->main->getServer()->getOnlinePlayers() as $p){
                    if($p !== $sender){
                        $p->kick($reason, false);
                    }
                }
                $players = count($this->main->getServer()->getOnlinePlayers());
                $sender->sendMessage(str_replace("{players}", $players, $message->get("KickAll") ["Sender"]));
                return true;
            } else{
                $message->get("KickAll") ["NoPerm"];
            }
        }
        return true;
    }
}