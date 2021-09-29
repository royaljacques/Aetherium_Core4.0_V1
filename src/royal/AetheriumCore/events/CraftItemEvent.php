<?php
namespace royal\AetheriumCore\events;

use pocketmine\event\Listener;
use pocketmine\event\inventory\CraftItemEvent as CIE;
use royal\AetheriumCore\api\JobAPI;
use royal\AetheriumCore\Main;

class CraftItemEvent implements Listener{
    use JobAPI;
    private Main $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }
    public function onCrat(CIE $event){
        $player = $event->getPlayer();
        $config = $this->getConfig($player);
        $player = $event->getPlayer();
        foreach ($event->getOutputs() as $craft) {
            if ($craft->getId() === 1001 ){
                if ($config->getNested("miner.reward.2") === 2) {
                    $event->cancel();
                    $player->sendMessage("tu n'a pas encore le niveau requis pour crafter le hammer");
                }
            }
        }
    }
}
