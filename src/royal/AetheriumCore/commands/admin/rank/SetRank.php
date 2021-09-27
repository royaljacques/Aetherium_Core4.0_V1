<?php
namespace royal\AetheriumCore\commands\admin\rank;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use royal\AetheriumCore\api\RankAPI;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Permissions;

class SetRank extends Command{
	public function __construct()
	{
		parent::__construct("setrank", "donner un grade sur le serveur ", "/setrank <nom du grade>", ["/sr"]);
		$this->setPermission(Permissions::PERMISSIONS);
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args): bool
	{
		if (empty($args[0])){
			$sender->sendMessage("/setrank <nom du grade> > <nom du joueur>");
		}else{
			if ($args[1] instanceof Player){
				Main::getRankAPI()->setRankPlayer($args[1],$args[0]);
				$sender->sendMessage("tu as bien reussi a ajouter le grade: $args[0] au joueurs $args[1]");
			}


		}
		return true;
	}
}