<?php

namespace royal\AetheriumCore\items;

use pocketmine\inventory\ArmorInventory;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemIdentifier;
use royal\AetheriumCore\api\ItemAPI;

class ItemsInit{
    public static function Init()
    {
        ItemAPI::registerItem(new Aetherium_ingot(new ItemIdentifier(1000, 0)));
        ItemAPI::registerItem(new Shadow_Boots(new ItemIdentifier(1002, 0), "shadow_boots", new ArmorTypeInfo(10, 650, 5)));
    }
}