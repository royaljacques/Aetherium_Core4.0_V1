<?php
namespace royal\AetheriumCore\api;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use royal\AetheriumCore\api\jobs\Farmer;
use royal\AetheriumCore\api\jobs\Miner;
use royal\AetheriumCore\Main;
use royal\AetheriumCore\task\MysqlTask;
use royal\AetheriumCore\utils\Variables;

trait JobAPI{
	use Miner;
	private Main $plugin;

    public static function ConnectDb(): \mysqli
    {
        return new \mysqli("127.0.0.1", "root", "");
    }
    public function setupPlayer(Player $player){
        $name = $player->getName();
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("INSERT INTO `Farmer`(`pseudo`, `xp`, `lvl`) VALUES ('$name','0','0')", "Aetherium_Jobs"));
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("INSERT INTO `Miner`(`pseudo`, `xp`, `lvl`) VALUES ('$name','0','0')", "Aetherium_Jobs"));
        Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("INSERT INTO `Hunter`(`pseudo`, `xp`, `lvl`) VALUES ('$name','0','0')", "Aetherium_Jobs"));

        copy(dirname(__FILE__)."/jobs/JobTemplate.yml", $this->plugin->getDataFolder()."job/"."players/".$player->getName().".yml");
    }
    public function joinServer(Player $player){
        $name = $player->getName();
        $niveau = Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT niveau FROM Miner WHERE pseudo=" . $name , "Aetherium_Jobs"));
        $xp = Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT niveau FROM Miner WHERE pseudo=" . $name , "Aetherium_Jobs"));
        $niveauf = Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT niveau FROM Farmer WHERE pseudo=" . $name , "Aetherium_Jobs"));
        $xpf = Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT niveau FROM Farmer WHERE pseudo=" . $name , "Aetherium_Jobs"));
        $niveauh= Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT niveau FROM Farmer WHERE pseudo=" . $name , "Aetherium_Jobs"));
        $xph = Main::getInstance()->getServer()->getAsyncPool()->submitTask(new MysqlTask("SELECT niveau FROM Farmer WHERE pseudo=" . $name , "Aetherium_Jobs"));
        Variables::$MinerJob[$player->getName()] = array_merge(["xp" => $xp], ["niveau" => $niveau]);
        Variables::$FarmerJob[$player->getName()] = array_merge(["xp" => $xpf], ["niveau" => $niveauf]);
        Variables::$HunterJob[$player->getName()] = array_merge(["xp" => $xp], ["niveau" => $niveau]);
    }
    public function quitServer(Player $player){
        $xp = Variables::$MinerJob[$player->getName()]["xp"];
        $level = Variables::$MinerJob[$player->getName()]["level"];
        var_dump($xp);
        var_dump($level);
    }
	public function getConfig(Player $player): Config
	{
		return new Config(Main::getInstance()->getDataFolder()."job/"."players/".$player->getName().".yml", Config::YAML);
	}
	public function addXpMiner(Player $player, int $xp){
        $xpMiner = Variables::$MinerJob[$player->getName()]["xp"];
        $LevelMiner = Variables::$MinerJob[$player->getName()]["niveau"];
        $xpMiner = $xpMiner + $xp;
        switch($LevelMiner){
            case 0:
                if($xpMiner >= 7500){
                    ++$LevelMiner;
                }
                break;
            case 1:
                if($xpMiner >= 15000){
                    ++$LevelMiner;
                }
                break;
            case 2:
                if($xpMiner >= 21000){
                    ++$LevelMiner;
                }
                break;

        }
        Variables::$MinerJob[$player->getName()] = array_merge(["xp" => $xpMiner], ["niveau" => $LevelMiner]);

	}
	public function addXpFarmer(Player $player, int $xp){
        $xpFarmer = Variables::$FarmerJob[$player->getName()]["xp"];
        $LevelFarmer = Variables::$FarmerJob[$player->getName()]["niveau"];
	}
	public function addXpHunter(Player $player, int $xp){

	}
	public function openIndexForm(Player $player){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){
				case 0:
					$this->openMinerForm($player);
			}
			return true;
		});
		$form->addButton("Job Mineur");
		$player->sendForm($form);
	}

	protected function Template(){
		$form = new SimpleForm(function (Player $player, $data = null){
			if ($data === null){
				return true;
			}
			switch ($data){

				case 0:

			}
			return true;
		});
	}
}