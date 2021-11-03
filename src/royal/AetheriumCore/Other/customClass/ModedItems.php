<?php
namespace royal\AetheriumCore\Other\customClass;


use pocketmine\item\Item;
use pocketmine\utils\CloningRegistryTrait;

final class ModedItems{
    use CloningRegistryTrait;

    private function __construct(){
        //NOOP
    }

    protected static function register(string $name, Item $item) : void{
        self::_registryRegister($name, $item);
    }

    public static function fromString(string $name) : Item{
        $result = self::_registryFromString($name);
        assert($result instanceof Item);
        return $result;
    }

    /**
     * @return Item[]
     */
    public static function getAll() : array{
        //phpstan doesn't support generic traits yet :(
        /** @var Item[] $result */
        $result = self::_registryGetAll();
        return $result;
    }

    protected static function setup(): void
    {
        $factory = ModedItemFactory::getInstance();
    }
}