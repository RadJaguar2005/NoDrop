<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use jojoe77777\FormAPI\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class NetworkStats extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("networkstats");
        $this->setAliases(["nt"]);
        $this->setDescription("Schaue die NetzwerkStats ein");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $ui = new Config($this->main->getDataFolder() . "ui.yml", 2);
        # $regist = count($this->main->getServer()->)
        if ($sender instanceof Player) {
            $api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $player, int $data = null) {
                $result = $data;
                if ($result === null) {
                    return true;
                }
                switch ($result) {
                    case 0:
                        $player->sendMessage("Coole nachrricht1"); #ändere hier deine message oder was frag mich
                        break;
                    case 1:
                        $player->kick("Du hast den Button 2 gedrückt ohoh :O", false); #wenn auf true steht Kicket by admin! bei false nicht.

                }
            });
            $form->setTitle("Hier ist der Titel");
            $form->setContent($regist);
            $form->addButton("Button 1", 0); #ändere hier dein Buttonname in ""
            $form->addButton("Button 2", 0); #ändere hier dein Buttonname in ""
            $form->sendToPlayer($sender);
            return $form; #wiederholt die Form
        }
        return true;
    }
}