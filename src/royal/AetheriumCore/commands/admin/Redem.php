<?php
namespace royal\AetheriumCore\commands\admin;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\Permissible;
use pocketmine\permission\PermissibleBase;
use pocketmine\permission\PermissionAttachment;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\task\RedemTask;
use royal\AetheriumCore\utils\Permissions;

class Redem extends Command{
    public function __construct(Main $plugin)
    {
        parent::__construct("redem", "ajouter de la monnaie a un joueur", '', ["/am"]);
        $this->setPermission(Permissions::ADMIN);
        $this->setPermission(DefaultPermissions::ROOT_OPERATOR);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)){
            return true;
        }
        if (!isset($args[0])){
            $sender->sendMessage("tu dois fais : /redem maintenance|basic raison");
        }else{


            if ($args[0] === "maintenance"){
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new RedemTask($args[1], "maintenance"), 20);
            }elseif ($args[0] === "basic"){
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new RedemTask($args[1], "basic"), 20);
            }
        }
    }
}