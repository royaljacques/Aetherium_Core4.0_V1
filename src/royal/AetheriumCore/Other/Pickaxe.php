<?php
namespace royal\AetheriumCore\Other;


use pocketmine\item\Item;

class Pickaxe extends TieredTool{
    public function setName(string $name) : Item{
        $this->name = $name;
        return $this;
    }
}