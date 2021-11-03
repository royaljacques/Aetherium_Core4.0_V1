<?php

namespace royal\AetheriumCore\items;

use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ToolTier;
use royal\AetheriumCore\api\ItemAPI;
use royal\AetheriumCore\items\zinc\Zinc_Ingots;
use royal\AetheriumCore\Other\customClass\ModedToolTier;
use royal\AetheriumCore\Other\Pickaxe;
use royal\AetheriumCore\utils\ModedId;


class ItemsInit{
    public static function Init()
    {
        ItemFactory::getInstance()->register(new Pickaxe(new ItemIdentifier(ItemIds::DIAMOND_PICKAXE, 0), "Diamond Pickaxe", ModedToolTier::DIAMOND()), true);
        //ItemAPI::registerItem(new Zinc_Ingots(new ItemIdentifier(ModedId::ZINC_INGOTS, 0)));
        //ItemAPI::registerItem(new Shadow_Boots(new ItemIdentifier(1002, 0), "shadow_boots", new ArmorTypeInfo(10, 650, 5)));
    }
}