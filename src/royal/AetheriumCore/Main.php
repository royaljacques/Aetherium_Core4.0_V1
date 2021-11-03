<?php

declare(strict_types=1);

namespace royal\AetheriumCore;
use pocketmine\data\bedrock\EntityLegacyIds;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\entity\Human;
use pocketmine\entity\Zombie;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\world\World;
use royal\AetheriumCore\api\EnchantAPI;
use royal\AetheriumCore\api\ItemAPI;
use royal\AetheriumCore\api\LogAPI;
use royal\AetheriumCore\api\MysqlAPI;
use royal\AetheriumCore\blocks\inventory\CraftingGridInvMenuType;
use muqsit\invmenu\InvMenuHandler;
use pocketmine\crafting\CraftingGrid;
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
use royal\AetheriumCore\entity\GolemEntity;
use royal\AetheriumCore\items\ItemsInit;
use royal\AetheriumCore\Other\CustomEnchantments;
use royal\AetheriumCore\task\ClearLagTask;
use royal\AetheriumCore\task\LogTask;

class Main extends PluginBase{
	private static self $instance;
	private static RankAPI $RankAPI;
	private static LogAPI $logAPI;
	private static EnchantAPI $enchantAPI;
	/**
	 * @var Config
	 */
	private Config $rank;



    protected function onLoad(): void
    {

        @mkdir($this->getDataFolder()."ranks/");
        @mkdir($this->getDataFolder()."job/");
        @mkdir($this->getDataFolder()."home/");
        @mkdir($this->getDataFolder()."job/"."players");
        @mkdir($this->getDataFolder()."ranks/"."players/");

        ItemsInit::Init();
        CustomEnchantments::setup();
        ItemAPI::Init();
        foreach (Permissions::$permissionsall as $perms){
            PermissionManager::getInstance()->addPermission(new Permission($perms));
            $this->getLogger()->info("§2 La permission: ".$perms." a bien été load");
        }
        $this->LoadEntity();
    }
	protected function onEnable(): void
	{
		self::$instance = $this;
        self::$RankAPI = new RankAPI($this);
        self::$logAPI = new LogAPI();
        self::$enchantAPI = new EnchantAPI($this);
        //MysqlAPI::Init();
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
        /*
        MysqlTask::createAsyncRequest(function(MysqlTask $var, \mysqli $db){
            $query = $db->query("");
            $var->setResult($query);
            $db->close();
        });
        */
		$this->register(dirname(__FILE__) . "/commands", "Command");
		$this->register(dirname(__FILE__) . "/events", "Event");
        $this->LoadTask();

        InvMenuHandler::getTypeRegistry()->register(Variables::INV_MENU_TYPE_WORKBENCH, new CraftingGridInvMenuType(CraftingGrid::SIZE_BIG));

    }
	public static function getInstance(){
		return self::$instance;
	}
	public static function getRankAPI(): RankAPI{
		return self::$RankAPI;
	}
	public static function getLogAPI(): LogAPI{
		return self::$logAPI;
	}
	public static function getEnchantAPI(): EnchantAPI{
		return self::$enchantAPI;
	}

    public function LoadEntity(){
        EntityFactory::getInstance()->register(GolemEntity::class,function(World $world, CompoundTag $nbt) : GolemEntity{
            return new GolemEntity(EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ["golemEntity"]);
    }
    public function LoadTask() {
        $this->getScheduler()->scheduleRepeatingTask(new LogTask($this), 20);
        $this->getScheduler()->scheduleRepeatingTask(new ClearLagTask($this), 20);
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
						case "Command":
							$this->getServer()->getCommandMap()->register($this->getName(), $class);
							$this->getLogger()->info("§1adresse de la commande: ".$name);
							break;
						case "Event":
							$this->getServer()->getPluginManager()->registerEvents($class, $this);
							$this->getLogger()->info("§3adresse de l'event: ".$name);
							break;
					}
				}
			}
		}
	}
}
