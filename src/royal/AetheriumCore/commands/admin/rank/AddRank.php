<?php
namespace royal\AetheriumCore\commands\admin\rank;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use royal\AetheriumCore\api\RankAPI;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Permissions;

class AddRank extends Command{
	public function __construct()
	{
		parent::__construct("addrank", "ajouter un grade sur le serveur ", "/addrank <nom du grade>", ["/ar"]);
		$this->setPermission(Permissions::PERMISSIONS);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool
	{
        if(!$this->testPermission($sender)){
            return true;
        }
		if (empty($args[0])){
			$sender->sendMessage("/addrank <nom du grade>");
		}else{
			Main::getRankAPI()->addRank($args[0]);
			$sender->sendMessage("tu as bien reussi a ajouter le grade: $args[0]");
		}

		return true;
	}
}