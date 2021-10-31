<?php
namespace royal\AetheriumCore\Other\customClass;


use pocketmine\entity\Human;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\convert\SkinAdapterSingleton;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\network\mcpe\protocol\AddPlayerPacket;
use pocketmine\network\mcpe\protocol\AdventureSettingsPacket;
use pocketmine\network\mcpe\protocol\PlayerListPacket;
use pocketmine\network\mcpe\protocol\types\DeviceOS;
use pocketmine\network\mcpe\protocol\types\entity\EntityMetadataProperties;
use pocketmine\network\mcpe\protocol\types\entity\StringMetadataProperty;
use pocketmine\network\mcpe\protocol\types\inventory\ItemStackWrapper;
use pocketmine\network\mcpe\protocol\types\PlayerListEntry;
use pocketmine\player\Player;

class CustomHuman extends Human{
    protected function sendSpawnPacket(Player $player) : void{
        if(!($this instanceof Player)){
            $player->getNetworkSession()->sendDataPacket(PlayerListPacket::add([PlayerListEntry::createAdditionEntry($this->uuid, $this->id, $this->getName(), SkinAdapterSingleton::get()->toSkinData($this->skin))]));
        }

        $player->getNetworkSession()->sendDataPacket(AddPlayerPacket::create(
            $this->getUniqueId(),
            $this->getName(),
            $this->getId(), //TODO: actor unique ID
            $this->getId(),
            "",
            $this->location->asVector3(),
            $this->getMotion(),
            $this->location->pitch,
            $this->location->yaw,
            $this->location->yaw, //TODO: head yaw
            ItemStackWrapper::legacy(TypeConverter::getInstance()->coreItemStackToNet(VanillaItems::GOLD_INGOT())),
            $this->getAllNetworkData(),
            AdventureSettingsPacket::create(0, 0, 0, 0, 0, $this->getId()), //TODO
            [], //TODO: entity links
            "", //device ID (we intentionally don't send this - secvuln)
            DeviceOS::UNKNOWN //we intentionally don't send this (secvuln)
        ));

        //TODO: Hack for MCPE 1.2.13: DATA_NAMETAG is useless in AddPlayerPacket, so it has to be sent separately
        $this->sendData([$player], [EntityMetadataProperties::NAMETAG => new StringMetadataProperty($this->getNameTag())]);

        $player->getNetworkSession()->onMobArmorChange($this);
        $player->getNetworkSession()->onMobOffHandItemChange($this);

        if(!($this instanceof Player)){
            $player->getNetworkSession()->sendDataPacket(PlayerListPacket::remove([PlayerListEntry::createRemovalEntry($this->uuid)]));
        }
    }
}