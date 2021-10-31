<?php

namespace royal\AetheriumCore\items;

use pocketmine\inventory\ArmorInventory;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\Item;
use pocketmine\item\ItemIdentifier;
use pocketmine\nbt\tag\CompoundTag;
use royal\AetheriumCore\items\CustomClass\AetheriumArmor;
use royal\AetheriumCore\items\CustomClass\AetheriumItem;

class Shadow_Boots extends AetheriumArmor {

    public function __construct(ItemIdentifier $identifier, string $name, ArmorTypeInfo $info)
    {
        parent::__construct($identifier, $name, $info);
    }

    public function getNbt(){
        return $components = CompoundTag::create()
            ->setTag("components", CompoundTag::create()
                ->setTag("item_properties", CompoundTag::create()
                    ->setInt("max_stack_size", 1)
                    ->setInt("use_duration", 32)
                    ->setInt("creative_category", 3)
                    ->setString("creative_group", "itemGroup.name.boots")
                    ->setString("enchantable_slot", 5)
                    ->setInt("enchantable_value", 10)
                )
                ->setTag("minecraft:icon", CompoundTag::create()
                    ->setString("texture", "stick")
                )
                ->setTag("minecraft:durability", CompoundTag::create()
                    ->setInt("max_durability", $this->getMaxDurability())
                )
                ->setTag("minecraft:armor", CompoundTag::create()
                    ->setInt("protection", $this->getDefensePoints())
                )
                ->setTag("minecraft:wearable", CompoundTag::create()
                    ->setInt("slot", 5)
                )
                ->setShort("minecraft:identifier", $this->getId() + ($this->getId() > 0 ? 5000 : -5000))
                ->setTag("minecraft:display_name", CompoundTag::create()
                    ->setString("value", $this->getName())
                )
            );
    }

    public function getLore(): array
    {
        return ["§8aetherium:" . $this->getName(), "§8NBT: 2 tag(s)"];
    }
}