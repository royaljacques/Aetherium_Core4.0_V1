<?php
namespace royal\AetheriumCore\api\jobs;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use royal\AetheriumCore\Main;

trait Miner{
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	private function openMinerForm(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){
				case 0:
					$this->openMinerFormCommentXP($player);
			}
			return true;
		});
		$form->addButton("comment xp ?");
		(int)$level = $this->getConfig($player)->getNested("miner.level");
		(int)$xp = $this->getConfig($player)->getNested("miner.xp");
		$form->addButton("§5Niveaux:§d\n".$level);
		$form->addButton("§5xp:§d\n".$xp);
		$player->sendForm($form);
	}
	private function openMinerFormCommentXP(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			return true;
		});
		TextFormat::DARK_PURPLE;
		$form->setTitle("Aetherium-Jobs");
		$form->setContent(
			"Afin de pouvoir xp, tu dois casser des block , ces block te donne pour : 
			\n §51 minerais de diamand: §d10xp
			\n §51 minerais d'azure: §d5xp
			\n §51 minerais de fer: §d3xp
			\n §51 minerais de charbon: §d1xp
			\n §51 minerais de redstone: §d1xp
			\n §51 minerais de lapis: §d2xp");
		$form->addButton("Fermer");

	}
}