<?php
namespace royal\AetheriumCore\api\jobs;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use royal\AetheriumCore\api\JobAPI;
use royal\AetheriumCore\Main;

trait Farmer{
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}
	private function openFarmerForm(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){
				case 0:
					$this->openFarmerFormCommentXP($player);
					break;
				case 2:
				case 1:
					break;
			}
			return true;
		});
		$form->addButton("comment xp ?");
		(int)$level = $this->getConfig($player)->getNested("farmer.level");
		(int)$xp = $this->getConfig($player)->getNested("farmer.xp");
		$form->addButton("§5Niveaux:§d\n".$level);
		$form->addButton("§5xp:§d\n".$xp);

	}
	private function openFarmerFormCommentXP(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			return true;
		});
		TextFormat::DARK_PURPLE;
		$form->setTitle("Aetherium-Jobs");
		$form->addButton("Fermer");

	}
}