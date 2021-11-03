<?php
namespace royal\AetheriumCore\items\octanite;


use pocketmine\item\ItemIdentifier;
use pocketmine\nbt\tag\CompoundTag;
use royal\AetheriumCore\items\CustomClass\AetheriumItem;

class Octanite_Ingots extends AetheriumItem{
    public function __construct(ItemIdentifier $identifier, string $name = "Octanite Ingots")
    {
        parent::__construct($identifier, $name);
    }

    public function getNbt(): CompoundTag
    {
        return $components = CompoundTag::create()
            ->setTag("components", CompoundTag::create()
                ->setTag("item_properties", CompoundTag::create()
                    ->setInt("max_stack_size", 64)
                )
                ->setTag("minecraft:icon", CompoundTag::create()
                    ->setString("texture", "minecraft:stick")
                )
                ->setShort("minecraft:identifier", $this->getId() + ($this->getId() > 0 ? 5000 : -5000))
                ->setTag("minecraft:display_name", CompoundTag::create()
                    ->setString("value", strtolower($this->getName()))
                )
            );
    }

    public function getLore(): array
    {
        return ["§8aetherium:" . $this->getName(), "§8NBT: 2 tag(s)"];
    }
}