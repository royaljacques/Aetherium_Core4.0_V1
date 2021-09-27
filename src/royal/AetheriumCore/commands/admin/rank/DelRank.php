<?php
namespace royal\AetheriumCore\commands\admin\rank;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use royal\AetheriumCore\api\RankAPI;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Permissions;

class DelRank extends Command{
	public function __construct()
	{
		parent::__construct("delrank", "suprimer un grade sur le serveur ", "/delrank <nom du grade>", ["/dr"]);
		$this->setPermission(Permissions::PERMISSIONS);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool
	{
		if (empty($args[0])){
			$sender->sendMessage("/delrank <nom du grade>");
		}else{
			Main::getRankAPI()->delRank($args[0]);
			$sender->sendMessage("tu as bien reussi a suprimer le grade: $args[0]");
		}
		return true;
	}
}