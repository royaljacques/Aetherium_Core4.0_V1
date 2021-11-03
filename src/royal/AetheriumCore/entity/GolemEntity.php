<?php
namespace royal\AetheriumCore\entity;

use pocketmine\entity\Location;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\nbt\tag\CompoundTag;

final class GolemEntity extends GolemProprety
{

    private static int $tick = 20;
    private static int $secondes = 10;

    public function onUpdate(int $currentTick): bool
    {
        if (self::$tick === 0){
            $this->onUpdateBySeconde();
            self::$tick = 20;
        }
        --self::$tick;
        return false;
    }
    private function onUpdateBySeconde(){
        if (self::$secondes === 0){
            $location = $this->getLocation();
            $this->setDrops($location, VanillaItems::GOLD_INGOT());
            self::$tick = 60;
            var_dump($this->uuid);
            self::$secondes = 10;
        }
        var_dump(self::$secondes);
        --self::$secondes;
    }
    protected function initEntity(CompoundTag $nbt): void
    {

        parent::initEntity($nbt);
        $this->setNameTag(implode("\n", [
            "Golem",
            "Points de vies:" . $this->getMaxHealth()
        ]));
        $this->setMaxHealth(20);
    }

}