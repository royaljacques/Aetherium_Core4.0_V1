<?php
namespace royal\AetheriumCore\task;


use pocketmine\scheduler\Task;
use royal\AetheriumCore\Main;

class RedemTask extends Task
{
    static int $time = 10;
    static string $type;
    public function __construct($time, $type)
    {
        self::$time = $time;
        self::$type = $type;
    }
    public function onRun(): void
    {

        switch (self::$time){
            case 10:
            case 9:
            case 7:
            case 5:
            case 3:
            case 2:
            case 1:
                Main::getInstance()->getServer()->broadcastMessage("Redémarage du serveur dans ". self::$time);
                break;
            case 0:
                if (self::$type === "maintenance"){
                    Main::getInstance()->getServer()->getConfigGroup()->setConfigBool("white-list", true);
                    foreach (Main::getInstance()->getServer()->getOnlinePlayers() as $player){
                        $player->kick("§d Serveur en maintenance\ndésoler pour la gène occasionné");
                    }
                }else{
                    foreach (Main::getInstance()->getServer()->getOnlinePlayers() as $player){
                        $player->transfer("127.0.0.1", 55555, "Le serveur redémare , nous vous tranférons ");
                    }
                    Main::getInstance()->getServer()->shutdown();
                }
                break;
        }
        self::$time= self::$time -1;
    }
}