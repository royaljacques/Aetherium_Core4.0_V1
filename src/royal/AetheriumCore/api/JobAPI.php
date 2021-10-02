<?php
namespace royal\AetheriumCore\api;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\api\jobs\Farmer;
use royal\AetheriumCore\api\jobs\Miner;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Variables;

trait JobAPI{
	use Miner;
	private Main $plugin;

	public function getConfig(Player $player): Config
	{
		return new Config(Main::getInstance()->getDataFolder()."job/"."players/".$player->getName().".yml", Config::YAML);
	}
	public function addXpMiner(Player $player, int $xp){
        $config = $this->getConfig($player);
        $config->setNested("miner.xp", $xp);
	}
	public function addXpFarmer(Player $player, int $xp){

	}
	public function addXpHunter(Player $player, int $xp){

	}
	public function setupPlayer(Player $player){
		copy(dirname(__FILE__)."/jobs/JobTemplate.yml", $this->plugin->getDataFolder()."job/"."players/".$player->getName().".yml");
	}
	public function joinServer(Player $player){
		$config = $this->getConfig($player);
		Variables::$minerJob[$player->getName()] = array_merge(["xp" => $config->getNested("miner.xp")], ["level" => $config->getNested("miner.level")]);
	}
	public function quitServer(Player $player){
		$xp = Variables::$minerJob[$player->getName()]["xp"];
		$level = Variables::$minerJob[$player->getName()]["level"];
		var_dump($xp);
		var_dump($level);
	}
	public function openIndexForm(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){
				case 0:
					$this->openMinerForm($player);
			}
			return true;
		});
		$form->addButton("Job Mineur");
		$player->sendForm($form);
	}

	protected function Template(){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){

				case 0:

			}
			return true;
		});
	}
}