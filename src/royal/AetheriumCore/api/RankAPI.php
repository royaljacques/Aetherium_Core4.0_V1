<?php
namespace royal\AetheriumCore\api;

use JetBrains\PhpStorm\Pure;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\Main;

class RankAPI {
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}
	public function firstJoin(Player $player){
		$config = new Config($this->plugin->getDataFolder()."ranks/"."players/"."players.yml");
		$config->set($player->getName(), "aetherien");
		$config->save();
	}
	public function playerJoinServer(Player $player){
		$config = new Config($this->plugin->getDataFolder()."ranks/"."players/"."players.yml");
		$rank = $config->get($player->getName());
		$config2 = new Config($this->plugin->getDataFolder()."ranks/"."ranks.yml");
		$perms = $config2->getNested($rank.".perms");
		if ($perms === null){
			return;
		}
		foreach ($perms as $perm){
			$player->setBasePermission($perm, true);
		}
	}
	public function addRank(string $groups){
		$group = strtolower($groups);
		$config = new Config($this->plugin->getDataFolder()."ranks/"."ranks.yml");
		$config->set($group.".name", $group);
		$config->save();
	}
	public function delRank(string $groups){
		$group = strtolower($groups);
		$config = new Config($this->plugin->getDataFolder()."ranks/"."ranks.yml");
		$config->remove($group);
		$config->save();
	}
	public function setRankPlayer(Player $player, string $groups){
		$config = new Config($this->plugin->getDataFolder()."ranks/"."players/"."players.yml");
		$config->set($player->getName(), $groups);
		$config->save();
		$config2 = new Config($this->plugin->getDataFolder()."ranks/"."ranks.yml");
		$perms = $config2->getNested($groups.".perms");
		if ($perms === null){
			return;
		}
		foreach ($perms as $perm){
			$player->setBasePermission($perm, true);
		}
	}
    public function onChatAPI(Player $player, string $message)
    {
        $rank = new Config($this->plugin->getDataFolder()."ranks/"."players/"."players.yml");
        $rankConfig = new Config($this->plugin->getDataFolder()."ranks/"."ranks.yml");
        $faction = "faction";
        $rankName =$rankConfig->getNested($rank->get($player->getName()).".chat");
        $prestige = 1;
        $ranklol = str_replace( ["{rank}", "{faction}", "{prestige}","{player}"],[$rank->get($player->getName()), $faction,$prestige, $player->getName()],$rankName. $message);
        return $modif = $ranklol;
    }


}
