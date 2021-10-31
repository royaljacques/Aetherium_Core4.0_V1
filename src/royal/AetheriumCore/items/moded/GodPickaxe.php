<?php
namespace royal\AetheriumCore\items\moded;


use pocketmine\item\ItemIdentifier;
use pocketmine\nbt\tag\CompoundTag;
use royal\AetheriumCore\items\CustomClass\AetheriumItem;

class GodPickaxe extends AetheriumItem{

    public function __construct(ItemIdentifier $identifier, string $name = "coin_jobs")
    {
        parent::__construct($identifier, $name);
    }

    public function getNbt(){
        return $components = CompoundTag::create()
            ->setTag("components", CompoundTag::create()
                ->setTag("item_properties", CompoundTag::create()
                    ->setInt("max_stack_size", 64)
                )
                ->setTag("minecraft:icon", CompoundTag::create()
                    ->setString("texture", "coin_jobs")
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