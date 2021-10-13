<?php
namespace royal\AetheriumCore\commands\player\home;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\data\bedrock\EffectIdMap;
use pocketmine\data\bedrock\EffectIds;
use pocketmine\entity\effect\Effect;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\entity\effect\EffectManager;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\Living;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\task\HomeTask;
use royal\AetheriumCore\utils\Permissions;
use royal\AetheriumCore\utils\Variables;

class Home extends Command{

    public Main $plugin;
    public function __construct(Main $plugin)
    {
        parent::__construct("home", "se tp a un home", "/home <name>");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $home = new Config($this->plugin->getDataFolder() . "Homes/" . strtolower($sender->getName()) . ".json", Config::JSON);

        if ($sender instanceof Player) {
            if (isset($args[0])) {
                if (substr($args[0], -1, 1) == ':') {
                    $joueur = explode(":", $args[0]);
                    if ($sender->hasPermission(Permissions::ADMIN_HOME)) {
                        if (file_exists($this->plugin->getDataFolder() . "Homes/" . strtolower($joueur[0]) . ".json")) {
                            $home = new Config($this->plugin->getDataFolder() . "Homes/" . strtolower($joueur[0]) . ".json", Config::JSON);
                            $allHomes = $home->getAll(true);
                            $homes = implode(", ", $allHomes);
                            $count = count($allHomes);
                            $sender->sendMessage("§1[§dAetherium§1]  §bVous devez faire §d/home (nom du joueur):(nom du home) §bpour se téléporter au home d'un joueur, voici la liste des homes du joueur §d{$joueur[0]} ({$count}) : {$homes}");
                        } else {
                            $sender->sendMessage("§1[§dAetherium§1]  §bLe joueur §d{$joueur[0]} §bn'existe pas.");
                        }
                    } else {
                        $sender->sendMessage("§1[§dAetherium§1]  §cVous n'avez pas la permission d'utiliser cette commande, seul les personnes OP peuvent se téléporter aux homes d'un joueur");
                    }
                    return;
                } else {
                    $search = strpos($args[0], ":");
                    if ($search) {
                        if ($sender->hasPermission(Permissions::ADMIN_HOME)) {
                            if (substr_count($args[0], ':') == 1) {
                                $admin = explode(":", $args[0]);
                                $joueur = $admin[0];
                                $homename = $admin[1];
                                if (file_exists($this->plugin->getDataFolder() . "Homes/" . strtolower($joueur) . ".json")) {
                                    $home = new Config($this->plugin->getDataFolder() . "Homes/" . strtolower($joueur) . ".json", Config::JSON);
                                    if ($home->exists($homename)) {
                                        $home = new Config($this->plugin->getDataFolder() . "Homes/" . strtolower($joueur) . ".json", Config::JSON);
                                        $pos = $home->get($homename);
                                        $pos = explode(":", $pos);
                                        $this->plugin->getServer()->getWorldManager()->loadWorld($pos[3]);
                                        $level = Server::getInstance()->getWorldManager()->getWorldByName($pos[3]);
                                        $teleport = new Position(intval($pos[0]), intval($pos[1]), intval($pos[2]), $level);
                                        $sender->teleport($teleport);
                                        $sender->sendMessage("§1[§dAetherium§1]  §bVous avez été téléporté au home §d{$homename} §bdu joueur §d{$joueur} §b!");
                                        return;
                                    } else {
                                        $sender->sendMessage("§1[§dAetherium§1]  §bLe home §d{$homename} §bn'existe pas.");
                                        return;
                                    }
                                } else {
                                    $sender->sendMessage("§1[§dNitro§5] §bLe joueur §d{$joueur} §bn'existe pas.");
                                    return;
                                }
                            } else {
                                $sender->sendMessage("§1[§dAetherium§1]  §bVous devez faire §d/home (nom du joueur):(nom du home) §bpour se téléporter au home d'un joueur !");
                                return;
                            }
                        } else {
                            $sender->sendMessage("§1[§dAetherium§1]  §cVous n'avez pas la permission d'utiliser cette commande, seul les personnes OP peuvent se téléporter aux homes d'un joueur");
                            return;
                        }
                    } else {

                    }
                }

                $pos = $home->get($args[0]);
                if (!$home->exists($args[0])) {
                    $sender->sendMessage("§1[§dAetherium§1]  §bLe home §d{$args[0]} §bn'existe pas.");
                } else {
                    $sender->getEffects()->add(new EffectInstance(VanillaEffects::BLINDNESS(), 20 * 5, 10));
                    $x = round($sender->getPosition()->getX());
                    $y = round($sender->getPosition()->getY());
                    $z = round($sender->getPosition()->getZ());
                    Variables::$Teleportation[$sender->getName()] = true;
                    $this->plugin->getScheduler()->scheduleRepeatingTask(new HomeTask($this, $sender, $x, $y, $z, $args[0]), 20);
                }
            } else {
                $allHomes = $home->getAll(true);
                $homes = implode(", ", $allHomes);
                $count = count($allHomes);
                $sender->sendMessage("§1[§dAetherium§1]  §bVous devez faire §d/home (nom du home) §bpour te téléporter à un home, voici la liste de tes homes §d({$count}) : {$homes}");
            }
        } else {
            $sender->sendMessage("[§4!!§r]" . "§bVous ne pouvez pas utiliser cette commande depuis la console.");
        }
    }

}