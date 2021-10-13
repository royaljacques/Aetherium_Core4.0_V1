<?php

namespace royal\AetheriumCore\commands\player\home;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\Main;

class Delhome extends Command{
    public Main $plugin;
    public function __construct(Main $plugin)
    {
        parent::__construct("delhome", "suprimer un home", "/delhome <name>");
        $this->plugin = $plugin;
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                $home = new Config($this->plugin->getDataFolder() . "Homes/" . strtolower($sender->getName()) . ".json", Config::JSON);
                if ($home->exists($args[0])) {
                    $home->remove($args[0]);
                    $home->save();
                    $home->reload();
                    $sender->sendMessage("§1[§dAetherium§1] §bVotre home a été supprimé avec succès !");
                } else {
                    $sender->sendMessage("§1[§dAetherium§1] §bLe home §9{$args[0]} §bn'existe pas.");
                }
            } else {
                $sender->sendMessage("§1[§dAetherium§1] §bVous devez faire §9/delhome (nom du home) §bpour supprimer un home !");
            }
        } else {
            $sender->sendMessage("[§4!!§r]" . "§bVous ne pouvez pas utiliser cette commande depuis la console.");
        }
    }
}
