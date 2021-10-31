<?php
namespace royal\AetheriumCore\api;

use CortexPE\DiscordWebhookAPI\Message;
use jojoe77777\FormAPI\CustomForm;
use pocketmine\block\Block;
use pocketmine\player\Player;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\task\MysqlTask;
use royal\AetheriumCore\utils\Variables;

class LogAPI{
    public static function InsertLogBlockPlaced(Block $block, Player $player)
    {
        $x = $block->getPosition()->x;
        $y = $block->getPosition()->y;
        $z = $block->getPosition()->z;
        $position = $x.":".$y.":".$z;
        var_dump($position);
        Variables::$logPlayerBlockPlaced[$position]= array_merge(Variables::$logPlayerBlockPlaced[$position]["pseudo"] = $player->getName(),Variables::$logPlayerBlockPlaced[$position]["date"] = Date("Y-m-d H:i:s"), Variables::$logPlayerBlockPlaced[$position]["position"] = $position);
    }

    public static function getLogBlockPlaced(Block $block, Player $player){
        $x = $block->getPosition()->x;
        $y = $block->getPosition()->y;
        $z = $block->getPosition()->z;
        $position = $x.":".$y.":".$z;
        if (!isset(Variables::$logPlayerBlockPlaced[$position])){
            $pseudo = Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT `pseudo` FROM `Block` WHERE `position` = '$position'"));
        }else{
            $pseudo = Variables::$logPlayerBlockPlaced[$position]["pseudo"];
        }

        $player->sendMessage("Le block a la position : ". $position." , il a été placé par " . `$pseudo`);
    }
    public static function onSendFormLogsAdminPlayer(Player $player){
        $form = new CustomForm(function (Player $player, array $data = null){
            if($data === null){
            return true;
            }
            if ($data[0] === true){
                Variables::$logAdminBlocPlacedEnabled[$player->getName()] = true;
            }elseif ($data[0] === false){
                unset(Variables::$logAdminBlocPlacedEnabled[$player->getName()]);
            }
            var_dump($data);
            return true;
        });
        $form->setTitle("Admin Logs Form");
        $form->addToggle("Block placé");
    }
}