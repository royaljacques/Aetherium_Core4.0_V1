<?php
namespace royal\AetheriumCore\api;


use pocketmine\player\Player;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\task\MysqlTask;

class MysqlAPI{

    public static function Init(){
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("CREATE TABLE IF NOT EXISTS`Aetherium_Bot`.`discord_api` ( `discord_id` INT NOT NULL , `pseudo` INT NOT NULL , `token` INT NOT NULL , `recup` INT NOT NULL ) ENGINE = InnoDB", "discord_api"));
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("CREATE TABLE IF NOT EXISTS`Aetherium_stats`.`Stats` ( `pseudo` TEXT NOT NULL , `ratio` INT NOT NULL , `money` INT NOT NULL , `miner_level` INT NOT NULL , `farmer_level` INT NOT NULL , `hunter_level` INT NOT NULL , `online_time` INT NOT NULL , `messages` INT NOT NULL , `prestige` INT NOT NULL , `grade` INT NOT NULL , `faction` INT NOT NULL ) ENGINE = InnoDB", "Aetherium_stats"));
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("CREATE TABLE IF NOT EXISTS`Aetherium_Job`.`Farmer` ( `pseudo` TEXT NOT NULL , `xp` INT NOT NULL , `lvl` INT NOT NULL ) ENGINE = InnoDB", "Aetherium_Job"));
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("CREATE TABLE IF NOT EXISTS`Aetherium_Job`.`Miner` ( `pseudo` TEXT NOT NULL , `xp` INT NOT NULL , `lvl` INT NOT NULL ) ENGINE = InnoDB", "Aetherium_Job"));
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("CREATE TABLE IF NOT EXISTS`Aetherium_Job`.`Hunter` ( `pseudo` TEXT NOT NULL , `xp` INT NOT NULL , `lvl` INT NOT NULL ) ENGINE = InnoDB", "Aetherium_Job"));
    }

    public static function ConnectDb(): \mysqli
    {
        return new \mysqli("127.0.0.1", "root", "");
    }
    public static function setupPlayer(Player $player){

    }
}