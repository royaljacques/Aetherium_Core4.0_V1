<?php
namespace royal\AetheriumCore\commands\rank;



use muqsit\invmenu\InvMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\AetheriumCore\utils\Permissions;
use royal\AetheriumCore\utils\Variables;

class Craft extends Command{
	public function __construct()
	{
		parent::__construct("craft", "ouvire la table de craft");
		$this->setPermission(Permissions::CRAFT);
	}
	public static function WORKBENCH() : InvMenu{
		return InvMenu::create(Variables::INV_MENU_TYPE_WORKBENCH);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if (!$sender->hasPermission(Permissions::CRAFT))$sender->sendMessage("Tu n'as pas les permissions");
		if ($sender instanceof Player){
			self::WORKBENCH()->send($sender);
		}
	}
}