<?php
namespace royal\AetheriumCore\api\enchantments;


use pocketmine\block\Block;
use pocketmine\block\BlockLegacyIds;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;

trait Foreuse{

    public static function getLevelEnchant(int $level, Block $block){
        if ($level === 1){
            self::addBlock1($block);
        }elseif($level === 2){
            self::addBlock2($block);
        }elseif($level === 3){
            self::addBlock3($block);
        }elseif($level === 4){
            self::addBlock($block);
        }
    }
    private static function addBlock(Block $blocks)
    {
        $minX = $blocks->getPosition()->x - 1;
        $maxX = $blocks->getPosition()->x + 1;

        $minY = $blocks->getPosition()->y - 1;
        $maxY = $blocks->getPosition()->y + 1;

        $minZ = $blocks->getPosition()->z - 1;
        $maxZ = $blocks->getPosition()->z + 1;

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $block= $blocks->getPosition()->getWorld()->getBlockAt($x,$y,$z);
                    if ($block->getId() == BlockLegacyIds::OBSIDIAN or $block->getId() == BlockLegacyIds::BEDROCK) {
                        return;
                    } else {
                        if ($block->getPosition()->x === $blocks->getPosition()->x && $block->getPosition()->y === $blocks->getPosition()->y && $block->getPosition()->z === $blocks->getPosition()->z){
                        }else{
                            $pickaxe = VanillaItems::DIAMOND_PICKAXE();
                            $block->getPosition()->getWorld()->useBreakOn(new Vector3($x, $y, $z), $pickaxe);
                        }
                    }
                }
            }
        }
    }
    private static function addBlock3(Block $blocks)
    {
        $minX = $blocks->getPosition()->x - 3;
        $maxX = $blocks->getPosition()->x + 2;

        $minY = $blocks->getPosition()->y - 1;
        $maxY = $blocks->getPosition()->y + 4;

        $minZ = $blocks->getPosition()->z - 1;
        $maxZ = $blocks->getPosition()->z + 1;

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $block= $blocks->getPosition()->getWorld()->getBlockAt($x,$y,$z);
                    if ($block->getId() == BlockLegacyIds::OBSIDIAN or $block->getId() == BlockLegacyIds::BEDROCK) {
                        return;
                    } else {
                        if ($block->getPosition()->x === $blocks->getPosition()->x && $block->getPosition()->y === $blocks->getPosition()->y && $block->getPosition()->z === $blocks->getPosition()->z){
                        }else{
                            $pickaxe = VanillaItems::DIAMOND_PICKAXE();
                            $block->getPosition()->getWorld()->useBreakOn(new Vector3($x, $y, $z), $pickaxe);
                        }
                    }
                }
            }
        }
    }
    private static function addBlock2(Block $blocks)
    {
        $minX = $blocks->getPosition()->x - 2;
        $maxX = $blocks->getPosition()->x + 2;

        $minY = $blocks->getPosition()->y - 1;
        $maxY = $blocks->getPosition()->y + 3;

        $minZ = $blocks->getPosition()->z - 1;
        $maxZ = $blocks->getPosition()->z + 1;

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $block= $blocks->getPosition()->getWorld()->getBlockAt($x,$y,$z);
                    if ($block->getId() == BlockLegacyIds::OBSIDIAN or $block->getId() == BlockLegacyIds::BEDROCK) {
                        return;
                    } else {
                        if ($block->getPosition()->x === $blocks->getPosition()->x && $block->getPosition()->y === $blocks->getPosition()->y && $block->getPosition()->z === $blocks->getPosition()->z){
                        }else{
                            $pickaxe = VanillaItems::DIAMOND_PICKAXE();
                            $block->getPosition()->getWorld()->useBreakOn(new Vector3($x, $y, $z), $pickaxe);
                        }
                    }
                }
            }
        }
    }
    private static function addBlock1(Block $blocks)
    {
        $minX = $blocks->getPosition()->x - 2;
        $maxX = $blocks->getPosition()->x + 1;

        $minY = $blocks->getPosition()->y - 1;
        $maxY = $blocks->getPosition()->y + 2;

        $minZ = $blocks->getPosition()->z - 1;
        $maxZ = $blocks->getPosition()->z + 1;

        for ($x = $minX; $x <= $maxX; $x++) {
            for ($y = $minY; $y <= $maxY; $y++) {
                for ($z = $minZ; $z <= $maxZ; $z++) {
                    $block= $blocks->getPosition()->getWorld()->getBlockAt($x,$y,$z);
                    if ($block->getId() == BlockLegacyIds::OBSIDIAN or $block->getId() == BlockLegacyIds::BEDROCK) {
                        return;
                    } else {
                        if ($block->getPosition()->x === $blocks->getPosition()->x && $block->getPosition()->y === $blocks->getPosition()->y && $block->getPosition()->z === $blocks->getPosition()->z){
                        }else{
                            $pickaxe = VanillaItems::DIAMOND_PICKAXE();
                            $block->getPosition()->getWorld()->useBreakOn(new Vector3($x, $y, $z), $pickaxe);
                        }
                    }
                }
            }
        }
    }
}