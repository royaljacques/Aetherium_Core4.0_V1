<?php
namespace royal\AetheriumCore\events;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent as PIE;
use pocketmine\item\ItemIds;
use royal\AetheriumCore\entity\GolemEntity;
use royal\AetheriumCore\Main;

class PlayerInteractEvent implements Listener
{

    private Main $plugin;

    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function OnInteract(PIE $event)
    {

            $nbt = new GolemEntity($event->getPlayer()->getLocation());
            $nbt->spawnToAll();
    }
}