<?php

namespace NoDrop;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class NoDrop extends PluginBase implements Listener {

    public function onLoad() {
        $this->getLogger()->info("§eDas noDrop Plugin wird geladen....");
    }

    public function onEnable() {
        $this->getLogger()->info("§aDas NoDrop Plugin wurde geladen!");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->onData();
    }

    public function onData() {
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
    }

    public function onDrop(PlayerDropItemEvent $event) {
        $config = new Config($this->getDataFolder() . "config.yml", 2);
        $player = $event->getPlayer();
        if ($config->get("Item-Drop") == false) {
            $event->setCancelled(true);
            $player->sendMessage($config->get("Message"));
        } elseif ($config->get("Item-Drop") == true) {
            if ($player->isOp()) {
                $event->setCancelled(false);
            }
        }
    }
}