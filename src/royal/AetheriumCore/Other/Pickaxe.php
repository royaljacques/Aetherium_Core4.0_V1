<?php
namespace royal\AetheriumCore\Other;


use pocketmine\item\Item;
use pocketmine\utils\Utils;

class Pickaxe extends TieredTool{
    public function setName(string $name) : Item{
        $this->name = $name;
        return $this;
    }
}