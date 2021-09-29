<?php
namespace royal\AetheriumCore\events;

use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
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
            case VanillaBlocks::BEETROOTS():
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

                    if ($block->getId() == VanillaBlocks::OBSIDIAN() or $block->getId() == VanillaBlocks::BEDROCK()) {
                        return;
                    } else {

                        $block->getPosition()->getWorld()->setBlock(new Vector3($x, $y, $z), VanillaBlocks::AIR());

                        $item = $this->onTransform($block);
                        $block->getPosition()->getWorld()->dropItem(new Vector3($x, $y, $z), $item);

                    }
                }
            }
        }
    }
    private function onTransform(Block $block)
    {
        return match ($block->getId()) {
            VanillaBlocks::DIAMOND_ORE() => VanillaItems::DIAMOND(),
            VanillaBlocks::GOLD_ORE() => VanillaItems::GOLD_INGOT(),
            VanillaBlocks::REDSTONE_ORE() => VanillaItems::REDSTONE_DUST(),
            VanillaBlocks::LAPIS_LAZULI_ORE() => VanillaItems::LAPIS_LAZULI(),
            VanillaBlocks::EMERALD_ORE() => VanillaItems::EMERALD(),
            default => $block->getId(),
        };
    }

}