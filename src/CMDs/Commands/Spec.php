<?php

namespace CMDs\Commands;

use Cloud\Cloud;
use CMDs\Cmds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;

class Spec extends Command {

    private $main;

    public function __construct(Cmds $main) {
        parent::__construct("spec");
        $this->setPermission("cmd.spec");
        $this->setDescription("Spec Command");
        $this->setPermissionMessage("§bCmds §8» §f§c§cDu hast keine Rechte zu diesen Command");
        $this->main = $main;
    }


    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        $message = new Config($this->main->getDataFolder() . "messages.yml", 2);
        $perms = new Config($this->main->getDataFolder() . "permission.yml", 2);
        if ($sender instanceof Player) {
            if ($sender->hasPermission($perms->get("Spec"))) {
                $name = $sender->getName();
                if (!in_array($name, $this->main->command)) {
                    $this->main->command[] = $name;
                    $sender->sendMessage($message->get("Spec") ["SpecOn"]);
                    $sender->setGamemode(3);
                } else {
                    unset($this->main->command[array_search($name, $this->main->command)]);
                    $player = $sender->getPlayer();
                    $sender->sendMessage($message->get("Spec") ["SpecOff"]);
                    $sender->setGamemode(0);
                    $sender->setAllowFlight(true);
                }
            } else {
                $sender->sendMessage($message->get("Spec") ["NoPerm"]);
            }
        }
        return true;
    }
}