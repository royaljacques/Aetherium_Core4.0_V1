<?php
namespace royal\AetheriumCore\commands\player\home;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Permissions;

class SetHome extends Command{
    public Main $plugin;
    public function __construct(Main $plugin)
    {
        parent::__construct("sethome", "mettre un nouveau home", "/sethome <name>");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if ($this->alphanum($args[0])) {
                    if ($sender->getWorld()->getFolderName() == "Faction") {
                        $home = new Config($this->plugin->getDataFolder() . "Homes/" . strtolower($sender->getName()) . ".json", Config::JSON);
                        $allHomes = $home->getAll(true);
                        $homes = implode(", ", $allHomes);
                        $count = count($allHomes);
                        if ($sender->hasPermission(Permissions::HOME_MAITRE)) {
                            $hcount = 25;
                        } else if ($sender->hasPermission(Permissions::HOME_ELITE)) {
                            $hcount = 20;
                        } else if ($sender->hasPermission(Permissions::HOME_VETERANT)) {
                            $hcount = 15;
                        } else if ($sender->hasPermission(Permissions::HOME_PRO)) {
                            $hcount = 10;
                        }else {
                            $hcount = 8;
                        }
                        if($home->exists($args[0])){
                            $sender->sendMessage("§1[§bJoueurs§1] §bCe home existe déjà, veuillez le supprimer pour le replacer.");
                        }
                        if($count >= $hcount){
                            $sender->sendMessage("§1[§bJoueurs§1] §bVous n'avez plus de place disponible pour poser plus de homes (tu ne peux placer seulement  : {$hcount} homes §b) !");
                        }
                        if(strlen($args[0]) > 10){
                            $sender->sendMessage("§1[§bJoueurs§1] §bVous ne pouvez utiliser que 10 caractères maximum !");
                        }
                        $player = $sender;
                        $x = round($player->getPosition()->getX(), 0);
                        $y = round($player->getPosition()->getY() + 0.5, 0);
                        $z = round($player->getPosition()->getZ(), 0);
                        $world = $player->getWorld()->getFolderName();
                        $home->set($args[0], "{$x}:{$y}:{$z}:{$world}");
                        $home->save();
                        $sender->sendMessage("§1[§bJoueurs§1] §aVotre home a été défini avec succès !");
                    } else {
                        $sender->sendMessage("§1[§bJoueurs§1] §bVous ne pouvez pas poser de homes ici !");
                    }
                } else {
                    $sender->sendMessage("§1[§bJoueurs§1] §cLe nom de votre home est invalide, veuillez utiliser seulement des lettres et des numéros.");
                }

            } else {
                $sender->sendMessage("§1[§bJoueurs§1] §bVous devez faire §9/sethome (nom du home) §bpour définir un nouveau home !");
            }
        } else {
            $sender->sendMessage("§1[§bJoueurs§1] §cVous ne pouvez pas utiliser cette commande depuis la console.");
        }
        return true;
    }

    public function alphanum($string): bool
    {
        if (function_exists('ctype_alnum')) {
            $return = ctype_alnum($string);
        } else {
            $return = preg_match('/^[a-z0-9]+$/i', $string) > 0;
        }
        return $return;
    }
}