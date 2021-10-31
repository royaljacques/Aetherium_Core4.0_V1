<?php
namespace royal\AetheriumCore\events;

use pocketmine\block\Chest;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent as BPE;
use royal\AetheriumCore\api\LogAPI;
use royal\AetheriumCore\Main;

class BlockPlaceEvent implements Listener{
    private Main $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onPlace(BPE $event){
        if ($event->getBlock() instanceof Chest) {
            LogAPI::InsertLogBlockPlaced($event->getBlock(), $event->getPlayer());
        }
    }
}