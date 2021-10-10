<?php
namespace royal\AetheriumCore\events;

use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\types\command\CommandOutputMessage;
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
	public function onBreak(BBE $event){
		$block = $event->getBlock();
		$player = $event->getPlayer();
        $this->addBlock($block);
		switch ($block->getId()){
			case BlockLegacyIds::DIAMOND_ORE:
				$this->addXpMiner($player, 10);
				break;
			case BlockLegacyIds::GOLD_ORE:
				$this->addXpMiner($player, 5);
				break;
			case BlockLegacyIds::IRON_ORE:
				$this->addXpMiner($player, 3);
				break;
			case BlockLegacyIds::REDSTONE_ORE:
			case BlockLegacyIds::COAL_ORE:
				$this->addXpMiner($player, 1);
				break;
			case BlockLegacyIds::LAPIS_ORE:
				$this->addXpMiner($player,2);
				break;
            case BlockLegacyIds::BEETROOT_BLOCK:
                if ($block->getMeta() === 7){
                    $random = mt_rand(1, 1000);
                    if ($random <= 50){

                    }
                }
		}
	}
    private function addBlock(Block $blocks)
    {
        $minX = $blocks->getPosition()->x - 1;
        $maxX = $blocks->getPosition()->x + 1;

        $minY = $blocks->getPosition()->y - 1;
        $maxY = $blocks->getPosition()->y + 1;

        $minZ = $blocks->getPosition()->z - 1;
        $maxZ = $blocks->getPosition()->z + 1;

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {

                for ($z = $minZ; $z <= $maxZ; $z++) {

                    $block = $blocks->getPosition()->getWorld()->getBlockAt($x,$y,$z);

                    if ($block->getId() == BlockLegacyIds::OBSIDIAN or $block->getId() == BlockLegacyIds::BEDROCK) {
                        return;
                    } else {

                        $block->getPosition()->getWorld()->setBlock(new Vector3($x, $y, $z), VanillaBlocks::AIR());

                        $item = $this->onTransform($block);
                        if ($block instanceof Block) {
                            if ($item instanceof Item)
                            $block->getPosition()->getWorld()->dropItem(new Vector3($x, $y, $z), $item);
                        }

                    }
                }
            }
        }
    }
    private function onTransform(Block $block)
    {
        return match ($block->getId()) {
            VanillaBlocks::DIAMOND_ORE() => BlockLegacyIds::DIAMOND_ORE,
            VanillaBlocks::GOLD_ORE() => BlockLegacyIds::GOLD_ORE,
            VanillaBlocks::REDSTONE_ORE() => BlockLegacyIds::REDSTONE_ORE,
            VanillaBlocks::LAPIS_LAZULI_ORE() => BlockLegacyIds::LAPIS_ORE,
            VanillaBlocks::EMERALD_ORE() => BlockLegacyIds::EMERALD_ORE,
            default => $block->getId(),
        };
    }

}