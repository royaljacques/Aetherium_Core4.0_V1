<?php
namespace royal\AetheriumCore\commands\admin\economie;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\Translatable;
use royal\AetheriumCore\api\MonneyAPI;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Permissions;

class AddMonney extends Command{
use MonneyAPI;
    public function __construct(Main $plugin)
    {
        parent::__construct("addmoney", "ajouter de la monnaie a un joueur", '', ["/am"]);
        $this->setPermission(Permissions::MONNAIE);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) < 1){
            throw new InvalidCommandSyntaxException();
        }
        if(!$this->testPermission($sender)){
            return true;
        }
        $player = $sender->getServer()->getPlayerByPrefix($args[0]);
        $this->addMonnaie($player, $args[0]);
        return true;
    }
}