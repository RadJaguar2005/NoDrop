<?php

namespace CMDs;

use CMDs\Commands\ClearChat;
use CMDs\Commands\Day;
use CMDs\Commands\Feed;
use CMDs\Commands\Fly;
use CMDs\Commands\Gamemode0;
use CMDs\Commands\Gamemode1;
use CMDs\Commands\Gamemode2;
use CMDs\Commands\Gamemode3;
use CMDs\Commands\Heal;
use CMDs\Commands\KickAll;
use CMDs\Commands\NetworkStats;
use CMDs\Commands\Nick;
use CMDs\Commands\Night;
use CMDs\Commands\Spec;
use CMDs\Commands\TpAll;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Cmds extends PluginBase {

    public $command = [];

    public function onLoad() {
        $this->getLogger()->info("§eDas Plugin wird geladen....");
    }

    public function onEnable()
    {
        $this->getLogger()->info("§aDas Plugin wurde Aktivirt!");
        $this->onCommands();
        $this->onData();
    }

    public function onDisable()
    {
        $this->getLogger()->info("§cDas Plugin wurde Entladen!");
    }

    public function onCommands() {
        $this->getServer()->getCommandMap()->register('heal', new Heal($this));
        $this->getServer()->getCommandMap()->register('spec', new Spec($this));
        $this->getServer()->getCommandMap()->register('feed', new Feed($this));
        $this->getServer()->getCommandMap()->register('fly', new Fly($this));
        $this->getServer()->getCommandMap()->register('gamemode0', new Gamemode0($this));
        $this->getServer()->getCommandMap()->register('gamemode1', new Gamemode1($this));
        $this->getServer()->getCommandMap()->register('gamemode2', new Gamemode2($this));
        $this->getServer()->getCommandMap()->register('gamemode3', new Gamemode3($this));
        $this->getServer()->getCommandMap()->register('day', new Day($this));
        $this->getServer()->getCommandMap()->register('night', new Night($this));
        $this->getServer()->getCommandMap()->register('clearchat', new ClearChat($this));
        $this->getServer()->getCommandMap()->register('tpall', new TpAll($this));
        $this->getServer()->getCommandMap()->register('kickall', new KickAll($this));
        # $this->getServer()->getCommandMap()->register('networkstats', new NetworkStats($this));
        # $this->getServer()->getCommandMap()->register('nick', new Nick($this)); Coming Soon
    }

    public function onData() {
        @mkdir($this->getDataFolder());
        $this->saveResource("messages.yml");
        $this->saveResource("permission.yml");
        $this->saveResource("ui.yml");
        # $this->saveResource("nicks.yml");
    }

}