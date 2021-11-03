<?php
namespace royal\AetheriumCore\blocks\ores;

use pocketmine\block\Opaque;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\VanillaItems;
use Refaltor\Natof\CustomItem\CustomItem;
use royal\AetheriumCore\Other\customClass\ModedItems;
use royal\AetheriumCore\Other\customClass\ModedToolTier;

class ZincOre extends Opaque{
    public function getDrops(Item $item): array
    {
        if ($item->getId() === ItemIds::DIAMOND_PICKAXE){
            $rand = mt_rand(1,3);
            return [
                VanillaItems::DIAMOND_PICKAXE()->setCount($rand)
            ];
        }else{
            return [];
        }
    }

    public function isAffectedBySilkTouch() : bool{
        return false;
    }

    protected function getXpDropAmount() : int{
        return mt_rand(3, 7);
    }
}