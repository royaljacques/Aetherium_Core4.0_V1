<?php
namespace royal\AetheriumCore\items\zinc;


use pocketmine\item\ItemIdentifier;
use pocketmine\nbt\tag\CompoundTag;
use Refaltor\Natof\CustomItem\Items\BasicItem;
use royal\AetheriumCore\items\CustomClass\AetheriumItem;

class Zinc_Ingots extends AetheriumItem {

    public function __construct(ItemIdentifier $identifier, string $name = "Zinc_Ingots")
    {
        parent::__construct($identifier, $name);
    }

    public function getNbt()
    {
        return $components = CompoundTag::create()
            ->setTag("components", CompoundTag::create()
                ->setTag("item_properties", CompoundTag::create()
                    ->setInt("max_stack_size", 64)
                )
                ->setTag("minecraft:icon", CompoundTag::create()
                    ->setString("texture", "stick")
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