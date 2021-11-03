<?php
namespace royal\AetheriumCore\Other\customClass;


use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use royal\AetheriumCore\items\CustomClass\AetheriumItem;
use royal\AetheriumCore\utils\ModedId;

class ModedItemFactory extends ItemFactory{
    public function __construct()
    {
        parent::__construct();
        $this->register(new AetheriumItem(new ItemIdentifier(ModedId::ZINC_INGOTS, 0), "Zinc Ingots"));
        $this->register(new AetheriumItem(new ItemIdentifier(ModedId::OCTANITE_INGOTS, 0), "Octanite Ingots"));
    }
}