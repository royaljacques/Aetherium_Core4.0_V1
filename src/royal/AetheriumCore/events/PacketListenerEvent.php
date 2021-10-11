<?php

namespace royal\AetheriumCore\events;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\StartGamePacket;
use royal\AetheriumCore\api\ItemAPI;

class PacketListenerEvent implements Listener
{

    /** @var array  */
    public array $handlers = [];

    public function onPacketSend(DataPacketSendEvent $event) {
        $packets = $event->getPackets();
        $targets = $event->getTargets();
        foreach ($packets as $packet) {
            if ($packet instanceof StartGamePacket) {
                $packet->itemTable = ItemAPI::$entries;
            }
        }
    }
}