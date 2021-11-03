<?php
namespace royal\AetheriumCore\blocks;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\BlockToolType;
use pocketmine\item\ToolTier;
use royal\AetheriumCore\blocks\ores\ZincOre;
use royal\AetheriumCore\Other\customClass\ModedToolTier;

class InitBlocks {
    public static function Init(){
        BlockFactory::getInstance()->register(new ZincOre(new BlockIdentifier(221, 0), "Zinc Ore",new BlockBreakInfo(4.0, BlockToolType::PICKAXE, ModedToolTier::DIAMOND()->getHarvestLevel())), true);
    }
}