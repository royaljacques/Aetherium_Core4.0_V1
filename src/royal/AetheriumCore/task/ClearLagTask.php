<?php
namespace royal\AetheriumCore\task;

use pocketmine\entity\Human;
use pocketmine\entity\object\ExperienceOrb;
use pocketmine\entity\object\ItemEntity;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use royal\AetheriumCore\entity\GolemEntity;
use royal\AetheriumCore\Main;

class ClearLagTask extends Task
{
    public $plugin;
    public static $time = 40;

    public function __construct(Main $plugin, $time = 40)
    {
        $this->plugin = $plugin;
        self::$time = $time;
    }

    public function onRun(): void
    {
        $time = self::$time;
        if ($time == 30 or $time == 15 or $time == 10 or $time == 5) {
            foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
                if ($player instanceof player) {
                    $player->sendMessage("§1[§l§9!!!§r§1] §fUn clearlag sera effectué dans §9{$time} seconde(s) §f!");
                }
            }
        }
        if ($time == 0) {
            $count = 0;
            foreach ($this->plugin->getServer()->getWorldManager()->getWorlds() as $level) {
                foreach ($level->getEntities() as $entity) {
                    if ($entity instanceof Player) continue;
                    if ($entity instanceof ItemEntity or $entity instanceof ExperienceOrb or $entity instanceof GolemEntity) {
                        $entity->flagForDespawn();
                        $count++;
                    }
                }
            }

            foreach ($this->plugin->getServer()->getOnlinePlayers() as $player) {
                $player->sendMessage("§1[§l§9!!!§r§1] §9{$count} item(s) §font été supprimé(s) !");
            }

            self::$time = 300;
        }
        --self::$time;
    }
}