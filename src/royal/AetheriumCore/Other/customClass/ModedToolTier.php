<?php
namespace royal\AetheriumCore\Other\customClass;


use pocketmine\utils\EnumTrait;

/**
 * This doc-block is generated automatically, do not modify it manually.
 * This must be regenerated whenever registry members are added, removed or changed.
 * @see build/generate-registry-annotations.php
 * @generate-registry-docblock
 *
 * @method static ModedToolTier DIAMOND()
 * @method static ModedToolTier GOLD()
 * @method static ModedToolTier IRON()
 * @method static ModedToolTier STONE()
 * @method static ModedToolTier WOOD()
 * @method static ModedToolTier ZINC()
 * @method static ModedToolTier OCTANITE()
 * @method static ModedToolTier DARKIUM()
 */
class ModedToolTier{
    use EnumTrait {
        __construct as Enum___construct;
    }
    protected static function setup() : void{
        self::registerAll(
            new self("wood", 1, 60, 5, 2),
            new self("gold", 2, 33, 5, 12),
            new self("stone", 3, 132, 6, 4),
            new self("iron", 4, 251, 7, 6),
            new self("diamond", 5, 1562, 8, 8),
            new self("zinc", 6, 1777, 9, 9),
            new self("octanite", 6, 1777, 9, 9),
            new self("darkium", 6, 1777, 9, 9)
        );
    }

    /** @var int */
    private $harvestLevel;
    /** @var int */
    private $maxDurability;
    /** @var int */
    private $baseAttackPoints;
    /** @var int */
    private $baseEfficiency;

    private function __construct(string $name, int $harvestLevel, int $maxDurability, int $baseAttackPoints, int $baseEfficiency){
        $this->Enum___construct($name);
        $this->harvestLevel = $harvestLevel;
        $this->maxDurability = $maxDurability;
        $this->baseAttackPoints = $baseAttackPoints;
        $this->baseEfficiency = $baseEfficiency;
    }

    public function getHarvestLevel() : int{
        return $this->harvestLevel;
    }

    public function getMaxDurability() : int{
        return $this->maxDurability;
    }

    public function getBaseAttackPoints() : int{
        return $this->baseAttackPoints;
    }

    public function getBaseEfficiency() : int{
        return $this->baseEfficiency;
    }
}