<?php
namespace royal\AetheriumCore\utils;


use pocketmine\item\ItemIdentifier;
use Refaltor\Natof\CustomItem\CustomItem;

class ItemLoader{
    public static function initItem(){
        $AetheriumCompress = CustomItem::createBasicItem(new ItemIdentifier(1000,0), "Atherium compréssé");
        $AetheriumCompress->setTexture("aetherium_compress");
        CustomItem::registerItem($AetheriumCompress);
        $hammer = CustomItem::createPickaxe(new ItemIdentifier(1001, 0), "Hammer en Aetherium", 2,1500, 4);
        $hammer->setTexture("aetherium_hammer");
        CustomItem::registerItem($hammer);
    }
}