<?php
namespace royal\AetheriumCore\events;

use pocketmine\event\Listener;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use royal\AetheriumCore\api\EnchantAPI;
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
	public function onBreak(BBE $event)
    {
        $block = $event->getBlock();
        $player = $event->getPlayer();
        $item = $event->getItem();
        EnchantAPI::getEnchantmentHammer($item,$block);
        /**
         * switch ($block->getId()){
         * case BlockLegacyIds::DIAMOND_ORE:
         * $this->addXpMiner($player, 10);
         * break;
         * case BlockLegacyIds::GOLD_ORE:
         * $this->addXpMiner($player, 5);
         * break;
         * case BlockLegacyIds::IRON_ORE:
         * $this->addXpMiner($player, 3);
         * break;
         * case BlockLegacyIds::REDSTONE_ORE:
         * case BlockLegacyIds::COAL_ORE:
         * $this->addXpMiner($player, 1);
         * break;
         * case BlockLegacyIds::LAPIS_ORE:
         * $this->addXpMiner($player,2);
         * break;
         * case BlockLegacyIds::BEETROOT_BLOCK:
         * if ($block->getMeta() === 7){
         * $random = mt_rand(1, 1000);
         * if ($random <= 50){
         *
         *}
		}*/
	}

    public function getEnchantement(Item $item){
        $enchantments = $item->getEnchantments();
        foreach ($enchantments as $enchant) {
          if($enchant->getType()->getName() === VanillaEnchantments::UNBREAKING()){
              return;
          }
        }
    }
}