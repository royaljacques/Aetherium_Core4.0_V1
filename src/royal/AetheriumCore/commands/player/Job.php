<?php
namespace royal\AetheriumCore\commands\player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\VanillaCommand;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\api\JobAPI;
use royal\AetheriumCore\utils\Permissions;

class Job extends VanillaCommand {
	use JobAPI;
	public function __construct()
	{
		parent::__construct(
			"job",
			"permet de voir les jobs",
			"/job");
	}
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if ($sender instanceof Player){
			$this->openIndexForm($sender);
		}
	}
}