<?php
namespace royal\AetheriumCore\commands\admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use royal\AetheriumCore\api\LogAPI;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Permissions;

class SetupLogAdmin extends Command{

    public function __construct(Main $plugin)
    {
        //coter bleux pluto coter vert azuna
        parent::__construct("setuplogsadmin", "choisir quel option de log on veut ", '', ["sla"]);
        $this->setPermission(Permissions::LOGS_BLOCK);
        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if ($sender instanceof Player)LogAPI::onSendFormLogsAdminPlayer($sender);
    }
}