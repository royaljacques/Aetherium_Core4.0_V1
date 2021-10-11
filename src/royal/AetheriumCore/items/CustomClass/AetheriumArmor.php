<?php

namespace royal\AetheriumCore\items\CustomClass;

use pocketmine\item\Armor;

class AetheriumArmor extends Armor {
    public function getLore(): array
    {
        return ["§8aetherium:" . $this->getName(), "§8NBT: 2 tag(s)"];
    }
}