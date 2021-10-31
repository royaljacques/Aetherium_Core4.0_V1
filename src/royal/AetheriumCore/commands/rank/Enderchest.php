<?php
namespace royal\AetheriumCore\commands\rank;

use muqsit\invmenu\InvMenu;
use muqsit\invmenu\session\network\handler\ClosurePlayerNetworkHandler;
use muqsit\invmenu\transaction\DeterministicInvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransaction;
use muqsit\invmenu\transaction\InvMenuTransactionResult;
use muqsit\invmenu\type\InvMenuType;
use muqsit\invmenu\type\InvMenuTypeIds;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\inventory\Inventory;
use pocketmine\item\ItemFactory;
use pocketmine\item\VanillaItems;
use pocketmine\network\mcpe\convert\TypeConverter;
use pocketmine\player\Player;
use royal\AetheriumCore\utils\Permissions;
use royal\AetheriumCore\utils\Variables;

class Enderchest extends Command{
	public function __construct()
	{
		parent::__construct("enderchest", "ouvrirs l'enderchest", null, ["ec"]);
		$this->setPermission(Permissions::ENDERCHEST);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender->hasPermission(Permissions::ENDERCHEST)){
            if ($sender instanceof Player) {
                if ($sender->hasPermission(Permissions::ENDERCHEST)) {
                    $this->openEnderInventory($sender);
                }
            }
        }else{
            $sender->sendMessage("tu n'as pas les permissions");
        }
	}
	public function openEnderInventory(Player $player){
		$menu = InvMenu::create(InvMenuTypeIds::TYPE_CHEST);
		$menu->setName("Ender Chest de ". $player->getName() );
		$enderinv = $player->getEnderInventory()->getContents();
		$player->getEnderInventory()->clearAll();
        $menu->getInventory()->setContents($enderinv);

		$menu->setInventoryCloseListener(function(Player $player, Inventory $inventory) : void{
            $player->getEnderInventory()->setContents($inventory->getContents() );
		});
		$menu->send($player);
	}

}