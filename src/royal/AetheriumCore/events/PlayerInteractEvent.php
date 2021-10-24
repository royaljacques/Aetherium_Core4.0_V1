<?php
namespace royal\AetheriumCore\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent as PIE;
use royal\AetheriumCore\api\LogAPI;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Variables;

class PlayerInteractEvent implements Listener{
    private Main $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function OnInteract(PIE $event){
        if (!isset(Variables::$logAdminBlocPlacedEnabled[$event->getPlayer()->getName()])){
        }else{
            LogAPI::getLogBlockPlaced($event->getBlock(), $event->getPlayer());
        }
    }
}