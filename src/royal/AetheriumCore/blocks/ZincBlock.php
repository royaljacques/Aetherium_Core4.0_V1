<?php
namespace royal\AetheriumCore\blocks;

use pocketmine\block\Opaque;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;

class ZincBlock extends Opaque{
    public function getDropsForCompatibleTool(Item $item) : array{
        return [
            VanillaItems::DIAMOND()
        ];
    }

    public function isAffectedBySilkTouch() : bool{
        return true;
    }

    protected function getXpDropAmount() : int{
        return mt_rand(3, 7);
    }
}