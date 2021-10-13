<?php

declare(strict_types=1);

namespace royal\AetheriumCore;
use royal\AetheriumCore\api\ItemAPI;
use royal\AetheriumCore\blocks\inventory\CraftingGridInvMenuType;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\crafting\CraftingGrid;
use pocketmine\item\ItemFactory;
use pocketmine\permission\{
	Permission,
	PermissionManager
};
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use royal\AetheriumCore\api\RankAPI;
use royal\AetheriumCore\utils\{
	Permissions,
	Variables
};
use royal\AetheriumCore\items\ItemsInit;

class Main extends PluginBase{
	private static self $instance;
	private static RankAPI $RankAPI;
	/**
	 * @var Config
	 */
	private Config $rank;

	protected function onEnable(): void
	{
		self::$instance = $this;
        ItemAPI::Init();
		self::$RankAPI = new RankAPI($this);
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
        $this->getServer()->getNetwork()->setName("§dAetherium ");
		InvMenuHandler::getTypeRegistry()->register(Variables::INV_MENU_TYPE_WORKBENCH, new CraftingGridInvMenuType(CraftingGrid::SIZE_BIG));
		foreach (Permissions::$permissionsall as $perms){
			PermissionManager::getInstance()->addPermission(new Permission($perms));
			$this->getLogger()->info("§2 La permission: ".$perms." a bien été load");
		}
		$this->register(dirname(__FILE__) . "/commands", "Command");
		$this->register(dirname(__FILE__) . "/events", "Event");
		@mkdir($this->getDataFolder()."ranks/");
		@mkdir($this->getDataFolder()."job/");
		@mkdir($this->getDataFolder()."home/");
		@mkdir($this->getDataFolder()."job/"."players");
		@mkdir($this->getDataFolder()."ranks/"."players/");
	}
	public static function getInstance(){
		return self::$instance;
	}
	public static function getRankAPI(): RankAPI{
		return self::$RankAPI;
	}

    public function removeTask(int $id) {
        $this->removeTask($id);
    }
	private function register(string $dir, string $type)
	{
		foreach (scandir($dir) as $file) {
			if(!in_array($file, [".", "..", "Tool"])) {
				if(is_dir($dir . "/" . $file)) $this->register($dir . "/" . $file, $type);
				else {
					$name = "\\" . str_replace([dirname(__FILE__), "/", ".php"], ["", "\\", ""], __NAMESPACE__ . $dir . "/" . $file);
					$class = new $name($this);
					switch ($type) {
						case "Item":
							(new ItemFactory)->register($class, true);
							$this->getLogger()->info("§5adresse de l'item: ".$name);
							break;
						case "Command":
							$this->getServer()->getCommandMap()->register($this->getName(), $class);
							$this->getLogger()->info("§1adresse de la commande: ".$name);
							break;
						case "Event":
							$this->getServer()->getPluginManager()->registerEvents($class, $this);
							$this->getLogger()->info("§3adresse de l'event: ".$name);
							break;
						case"Task":
							$this->getScheduler()->scheduleRepeatingTask($class, $class->getEverySecond() * 20);
							$this->getLogger()->info("§6adresse de la task: ".$name);
							break;
					}
				}
			}
		}
	}


    protected function onLoad(): void
    {
        ItemsInit::Init();
    }
}
