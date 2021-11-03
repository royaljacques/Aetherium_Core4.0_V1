<?php
namespace royal\AetheriumCore\commands\admin;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use royal\AetheriumCore\Main;

class ItemId extends Command{
    public function __construct(Main $plugin)
    {
        parent::__construct("id", "voir l'id ainsi que la meta de l'item", "/id");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player){
            $itemIsHand = $sender->getInventory()->getItemInHand();
            $id = $itemIsHand->getId();
            $meta = $itemIsHand->getMeta();
            $sender->sendMessage("ItemsId: ".$id.":".$meta);
        }
    }
}