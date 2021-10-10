<?php
namespace royal\AetheriumCore\events;


use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent as PCE;
use royal\AetheriumCore\Main;

class PlayerChatEvent implements Listener
{
    public Main $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onChat(PCE $event)
    {
        if ($event->isCancelled()) return;
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $modif = Main::getRankAPI()->onChatAPI($player, $message);
        $event->setFormat($modif);
    }
}