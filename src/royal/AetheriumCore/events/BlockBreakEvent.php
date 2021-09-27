<?php
namespace royal\AetheriumCore\events;

use JetBrains\PhpStorm\Pure;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use royal\AetheriumCore\api\JobAPI;
use royal\AetheriumCore\Main;
use pocketmine\event\block\BlockBreakEvent as BBE;

class BlockBreakEvent implements Listener{
	use JobAPI;
	private Main $plugin;
	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}
	#[Pure] public function onBreak(BBE $event){
		$block = $event->getBlock();
		$player = $event->getPlayer();
		switch ($block->getId()){
			case VanillaBlocks::DIAMOND_ORE():
				$this->addXpMiner($player, 10);
				break;
			case VanillaBlocks::GOLD_ORE():
				$this->addXpMiner($player, 5);
				break;
			case VanillaBlocks::IRON_ORE():
				$this->addXpMiner($player, 3);
				break;
			case VanillaBlocks::REDSTONE_ORE():
			case VanillaBlocks::COAL_ORE():
				$this->addXpMiner($player, 1);
				break;
			case VanillaBlocks::LAPIS_LAZULI_ORE():
				$this->addXpMiner($player,2);
				break;
		}
	}
}