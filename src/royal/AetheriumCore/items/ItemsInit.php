<?php

namespace royal\AetheriumCore\items;

use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\item\ToolTier;
use royal\AetheriumCore\api\ItemAPI;
use royal\AetheriumCore\Other\Pickaxe;


class ItemsInit{
    public static function Init()
    {
        ItemFactory::getInstance()->register(new Pickaxe(new ItemIdentifier(ItemIds::DIAMOND_PICKAXE, 0), "Diamond Pickaxe", ToolTier::DIAMOND()), true);
        ItemAPI::registerItem(new Aetherium_ingot(new ItemIdentifier(1000, 0)));
        ItemAPI::registerItem(new Shadow_Boots(new ItemIdentifier(1002, 0), "shadow_boots", new ArmorTypeInfo(10, 650, 5)));
    }
}