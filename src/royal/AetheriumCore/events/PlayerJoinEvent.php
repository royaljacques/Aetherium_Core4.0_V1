<?php
namespace royal\AetheriumCore\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use royal\AetheriumCore\api\ItemAPI;
use royal\AetheriumCore\api\JobAPI;
use royal\AetheriumCore\api\MysqlAPI;
use royal\AetheriumCore\Main;
use pocketmine\event\player\PlayerJoinEvent as PJE;
class PlayerJoinEvent implements Listener{
use JobAPI;
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}
	public function onJoin(PJE $event){
		$player = $event->getPlayer();
		if (!$player->hasPlayedBefore()){
			Main::getRankAPI()->firstJoin($player);
            $this->setupPlayer($player);
            MysqlAPI::PlayerNotPlayedBefore($player);
		}
		$this->joinServer($player);
		Main::getRankAPI()->playerJoinServer($player);
        $player->getNetworkSession()->syncGameMode($player->getGamemode());
        $player->getNetworkSession()->sendDataPacket(ItemAPI::$packet);
        $this->plugin->getServer()->broadcastPopup('§d - §r'.$player->getName().' -');
	}

}