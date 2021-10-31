<?php
namespace royal\AetheriumCore\entity;

use pocketmine\entity\Human;
use pocketmine\entity\Location;
use pocketmine\entity\Skin;
use pocketmine\nbt\tag\CompoundTag;
use Ramsey\Uuid\Uuid;
use royal\AetheriumCore\Main;

class GolemProprety extends Human {
    protected int $MaxLife = 30;

    public function __construct(Location $location, ?CompoundTag $nbt = null)
    {
        parent::__construct(
            $location,
            new Skin("FarmerGolem", $this->PNGtoBYTES(Main::getInstance()->getDataFolder() . "FarmerGolem.png"), "", "minecraft:iron_golem","geometry.irongolem"),
            $nbt);
        $this->uuid = Uuid::uuid3(Uuid::NIL, ((string) $this->getId()) . $this->skin->getSkinData() . $this->getNameTag());
    }
    public function PNGtoBYTES($path) : string
    {
        $img = @imagecreatefrompng($path);
        $bytes = "";
        for ($y = 0; $y < (int)@getimagesize($path)[1]; $y++) {
            for ($x = 0; $x < (int)@getimagesize($path)[0]; $x++) {
                $rgba = @imagecolorat($img, $x, $y);
                $bytes .= chr(($rgba >> 16) & 0xff) . chr(($rgba >> 8) & 0xff) . chr($rgba & 0xff) . chr(((~((int)($rgba >> 24))) << 1) & 0xff);
            }
        }
        @imagedestroy($img);
        return $bytes;
    }

    public function getMaxLife(): int
    {
        return $this->MaxLife;
    }
    public function addMaxLife(): int
    {
        $this->MaxLife = $this->MaxLife + 5;
        return true;
    }

}

