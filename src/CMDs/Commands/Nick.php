<?php

namespace CMDs\Commands;

use CMDs\Cmds;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Event;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\Player;
use pocketmine\utils\Config;

class Nick extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("nick");
        $this->setDescription("Nick Command");
        $this->main = $main;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        $nicks = new Config($this->main->getDataFolder() . "nicks.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Nick"))) {
                $api = $this->main->getServer()->getPluginManager()->getPlugin("FormAPI");
                $form = $api->createCustomForm(function (Player $player, array $data = null) {
                    $result = $data;
                    if ($result === null) {
                        return true;
                    }

                    if ($data[1] === true) {
                        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
                        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
                        $nicks = new Config($this->main->getDataFolder() . "nicks.yml", 2);
                        $zahl = mt_rand(0, count($nicks->get("random-nicks")) -1 );
                        $player->setDisplayName($nicks->get("random-nicks")[$zahl]);
                        $player->setNameTag($nicks->get("random-nicks")[$zahl]);
                        $msg = $message->get("Nick") ["SetNick"];
                        $player->sendMessage(str_replace("{nick}", $nicks->get("random-nicks")[$zahl], $msg));
                        return true;
                    }

                    if ($data[2] === true) {
                        $player->setNameTag($player->getName());
                        $player->setDisplayName($player->getName());
                        return true;
                    }
                    return true;
                });
                $form->setTitle("§6NickUI");
                $form->addLabel("§aWähle aus was du Nutzen möchtest");
                $form->addToggle("§bRandom Nick");
                $form->addToggle("§cReset");
                $form->sendToPlayer($sender);
            } else {
                $sender->sendMessage($message->get("Nick") ["NoPerm"]);
            }
        }
    }

    public function onNickChat(PlayerChatEvent $event) {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        $nicks = new Config($this->main->getDataFolder() . "nicks.yml", 2);
    }
}