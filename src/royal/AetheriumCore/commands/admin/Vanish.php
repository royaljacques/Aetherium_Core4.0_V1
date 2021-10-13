<?php
namespace royal\AetheriumCore\commands\admin;

use pocketmine\command\CommandSender;
use pocketmine\command\defaults\PluginsCommand;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\command\utils\CommandException;
use pocketmine\inventory\transaction\TransactionBuilderInventory;
use pocketmine\lang\KnownTranslationKeys;
use royal\AetheriumCore\utils\Permissions;

class Vanish extends VanillaCommand {
	public function __construct()
	{
		parent::__construct(
			"vanish",
			"permet de se cacher de la vue des autres joueurs,",
		"/vanish");
		$this->setPermission(Permissions::vanish);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if(!$sender->hasPermission($sender)){
			return true;
		}

	}
}