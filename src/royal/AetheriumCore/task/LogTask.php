<?php
namespace royal\AetheriumCore\task;

use pocketmine\scheduler\Task;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\utils\Variables;

class LogTask extends Task {
    static int $time = 600;
    public function __construct(Main $plugin)
    {
    }
    public function getEverySecond(): int
    {
        return 1;
    }
    public function onRun(): void
    {
        if (self::$time === 0){
            $i = 0;
            foreach(Variables::$logPlayerBlockPlaced as $logs){
                var_dump(Variables::$logPlayerBlockPlaced);
                $array = explode(':', $logs["position"]);
                $x = $array[0];
                $y = $array[1];
                $z = $array[2];
                $pseudo = $logs["pseudo"];
                $date = $logs["date"];
                Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("INSERT INTO `Block`(`position`, `pseudo`, `date`) VALUES ('" . $x . ":" . $y . ":" . $z . "','" . $pseudo . "','" . $date . "')", "Aetherium_Logs"));
                ++$i;
                unset(Variables::$logPlayerBlockPlaced[$logs["position"]]);
            }

            self::$time = 600;
        }
        --self::$time;

    }
}