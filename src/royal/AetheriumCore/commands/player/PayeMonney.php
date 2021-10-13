<?php
namespace royal\AetheriumCore\commands\player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\InvalidCommandSyntaxException;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use royal\AetheriumCore\api\MonneyAPI;
use royal\AetheriumCore\Main;

class PayeMonney extends Command{
    use MonneyAPI;
    public function __construct(Main $plugin)
    {
        parent::__construct("pay", "payer un joueur","/pay <player>");
        $this->plugin = $plugin;
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) < 1){
            throw new InvalidCommandSyntaxException();
        }

        $player = $sender->getServer()->getPlayerByPrefix($args[0]);
        $payement = $args[1];

        if($player === null){
            $sender->sendMessage("le joueur n'éxiste pas ou n'est pas connecter");
            return true;
        }
        if($sender instanceof Player){
            $monnaie = $this->getMonnaie($sender);
            if($monnaie <= $payement){
                $sender->sendMessage("tu n'as pas assez d'argent pour payer ". $player->getName());
            }else{
                $this->delmonnaie($sender, $payement);
                $this->addMonnaie($player, $payement);
                $sender->sendMessage("tu as bien payer " . $player->getName())." avec la somme de ". $payement;
                $player->sendMessage("tu as été payer " . $player->getName())." avec la somme de ". $payement;
            }

        }
    }
}