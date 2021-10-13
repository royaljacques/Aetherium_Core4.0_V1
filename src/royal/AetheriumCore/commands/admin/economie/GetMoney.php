<?php
namespace royal\AetheriumCore\commands\admin\economie;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\utils\Config;
use royal\AetheriumCore\api\MonneyAPI;
use royal\AetheriumCore\Main;

class GetMoney extends Command{
    use MonneyAPI;
    public function __construct(Main $plugin)
    {
        parent::__construct("getmoney", "voir la monnaie a un joueur", '');

    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) < 1){
            throw new InvalidCommandSyntaxException();
        }
        $player = $sender->getServer()->getPlayerByPrefix($args[0]);
        $monnaie = $this->getMonnaie($player);
        $sender->sendMessage("Le joueur ". $player->getName()." a actuellement " . $monnaie);
    }
}