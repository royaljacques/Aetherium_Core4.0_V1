<?php
namespace royal\AetheriumCore\entity;

use pocketmine\nbt\tag\CompoundTag;

final class GolemEntity extends GolemProprety
{

    private static int $time = 60;

    public function onUpdate(int $currentTick): bool
    {
        return false;
    }

    protected function initEntity(CompoundTag $nbt): void
    {

        parent::initEntity($nbt);
        $this->setNameTag("Golem\n");
        $this->setMaxHealth($this->MaxLife);

    }

}