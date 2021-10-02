<?php
namespace royal\AetheriumCore\blocks;

use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\Crops;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;

class MinerBlock extends Crops{
    public function __construct()
    {
        parent::__construct(new BlockIdentifier(244,1),"Miner Plant", new BlockBreakInfo(2,5,6));
    }

    public function getDropsForCompatibleTool(Item $item) : array{
        if($this->age >= 7){
            if (mt_rand(1, 200)){
                return [VanillaItems::BEETROOT()];
            }else{
                return [
                    VanillaItems::EMERALD()
                ];
            }
            
        }

        return [
            VanillaItems::BEETROOT_SEEDS()->setCount(mt_rand(0, 2))
        ];
    }
}