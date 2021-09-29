<?php
namespace royal\AetheriumCore\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent as PQE;
use pocketmine\player\Player;
use royal\AetheriumCore\Main;

class PlayerQuitEvent implements Listener
{
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public function playerQuit(PQE $event){
		$player = $event->getPlayer();
        if ($player instanceof Player){
            $name = $player->getName();
            $this->plugin->getServer()->broadcastPopup('§d - §r'.$name.' -');
        }
	}
}