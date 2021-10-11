<?php

namespace royal\AetheriumCore\items\CustomClass;

use pocketmine\item\Item;

class AetheriumItem extends Item{
    public function getLore(): array
    {
        return ["§8aetherium:" . $this->getName(), "§8NBT: 2 tag(s)"];
    }
}