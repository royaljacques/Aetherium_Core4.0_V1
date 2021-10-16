<?php
namespace royal\AetheriumCore\task;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\scheduler\Task;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use royal\AetheriumCore\{Main, commands\player\home\Home, utils\Variables};

class HomeTask extends Task {
    private Main $core;
    private int $time = 5;
    private string $nom;
    private Player $player;
    private int $Px;
    private int $Py;
    private int $Pz;

    public function __construct(Home $c, Player $player, $x, $y, $z, $nom){
        $this->core = $c->plugin;
        $this->player = $player;
        $this->Px = $x;
        $this->Py = $y;
        $this->Pz = $z;
        $this->nom = $nom;
    }
    public function onRun(): void
    {
        $player = $this->player;
        if($this->core->getServer()->getPlayerByPrefix($player->getName()) === false){
            unset(Variables::$Teleportation[$player->getName()]);
            $this->getHandler()?->cancel();
            return ;
        }

        $Px = round($player->getPosition()->getX());
        $Py = round($player->getPosition()->getY());
        $Pz = round($player->getPosition()->getZ());
        $x = $this->Px;
        $y = $this->Py;
        $z = $this->Pz;
        if (($Px != $x) or ($Py != $y) or ($Pz != $z)) {
            $player->getEffects()->remove(VanillaEffects::BLINDNESS());
            $son = new PlaySoundPacket();
            $son->soundName = "note.bass";
            $son->volume = 100;
            $son->pitch = 1;
            $son->x = $player->getPosition()->x;
            $son->y = $player->getPosition()->y;
            $son->z = $player->getPosition()->z;
            $player->getNetworkSession()->sendDataPacket($son);
            $player->sendPopup("§d- §4Téléportation annulée §d-");
            unset(Variables::$Teleportation[$player->getName()]);
            $this->getHandler()?->cancel();
            return;
        }

        if ($this->time == 0) {
            $son = new PlaySoundPacket();
            $son->soundName = "note.flute";
            $son->volume = 100;
            $son->pitch = 1;
            $son->x = $player->getPosition()->x;
            $son->y = $player->getPosition()->y;
            $son->z = $player->getPosition()->z;
            $player->getNetworkSession()->sendDataPacket($son);
            $son = new PlaySoundPacket();
            $son->soundName = "note.bass";
            $son->volume = 100;
            $son->pitch = 1;
            $son->x = $player->getPosition()->x;
            $son->y = $player->getPosition()->y;
            $son->z = $player->getPosition()->z;
            $player->getNetworkSession()->sendDataPacket($son);
            unset(Variables::$Teleportation[$player->getName()]);
            $player->sendPopup("§d- §bVous avez été téléporté au home §b{$this->nom} §d-");
            $home = new Config($this->core->getDataFolder() . "Homes/" . strtolower($player->getName()) . ".json", Config::JSON);
            $pos = $home->get($this->nom);
            $pos = explode(":", $pos);

            if(isset($pos[3])){
                $this->core->getServer()->getWorldManager()->loadWorld($pos[3]);
                $level = Server::getInstance()->getWorldManager()->getWorldByName($pos[3]);
            } else {
                $level = Server::getInstance()->getWorldManager()->getDefaultWorld();
            }
            if(isset($pos[0]) and isset($pos[1]) and isset($pos[2])) {
                $home = new Position(intval($pos[0]), intval($pos[1]), intval($pos[2]), $level);
                $player->teleport($home);
                $this->getHandler()?->cancel();
            } else {
                $this->getHandler()?->cancel();
                $player->sendMessage("[§4!!§r]§r". "Votre home est corrompu.");
            }
        } else {
            $this->player->sendPopup("§d- §bTéléportation dans §b{$this->time} seconde(s) §d-");
            $son = new PlaySoundPacket();
            $son->soundName = "note.harp";
            $son->volume = 100;
            $son->pitch = 1;
            $son->x = $player->getPosition()->x;
            $son->y = $player->getPosition()->y;
            $son->z = $player->getPosition()->z;
            $player->getNetworkSession()->sendDataPacket($son);
        }
        $this->time --;

    }
}
