<?php

/*
 *     /$$$$$$$           /$$               /$$
 *   | $$__  $$         | $$              | $$
 *   | $$  \ $$/$$$$$$ /$$$$$$   /$$$$$$ /$$$$$$   /$$$$$$  /$$$$$$  /$$$$$$$
 *   | $$$$$$$/$$__  $|_  $$_/  |____  $|_  $$_/  /$$__  $$/$$__  $$/$$_____/
 *   | $$____| $$  \ $$ | $$     /$$$$$$$ | $$   | $$  \ $| $$$$$$$|  $$$$$$
 *   | $$    | $$  | $$ | $$ /$$/$$__  $$ | $$ /$| $$  | $| $$_____/\____  $$
 *   | $$    |  $$$$$$/ |  $$$$|  $$$$$$$ |  $$$$|  $$$$$$|  $$$$$$$/$$$$$$$/
 *   |__/     \______/   \___/  \_______/  \___/  \______/ \_______|_______/
 *
 *  GNU General Public License v2.0
 *  Copyright (C) 1989, 1991 Free Software Foundation, Inc.
 *  51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
 *  Everyone is permitted to copy and distribute verbatim copies
 *  of this license document, but changing it is not allow
 */

namespace Refaltor\Natof\CustomItem\Items;

use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\item\Armor;
use pocketmine\item\ArmorTypeInfo;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemUseResult;
use pocketmine\math\Vector3;
use pocketmine\player\Player;

class HelmetItem extends Armor
{
    /** @var string  */
    private string $texturePath;

    /** @var string  */
    private string $armorGroup = "itemGroup.name.helmet";

    /** @var int */
    private int $creativeCategory = 3;

    /** @var null | callable */
    private $attackListener = null;

    /** @var null | callable */
    private $interactOnBlockListener = null;

    /** @var null | callable */
    private $destroyBlockListener = null;

    /** @var null | callable */
    private $clickAirListener = null;

    /** @var null | callable */
    private $releaseUsingListener = null;


    public function __construct(ItemIdentifier $identifier, ArmorTypeInfo $info, string $name)
    {
        $this->texturePath = 'blocks/barrier';
        parent::__construct($identifier, $name, $info);
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setTexture(string $path): self {
        $this->texturePath = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getTexture(): string {
        return $this->texturePath;
    }

    /**
     * @return string
     */
    public function getArmorGroup() : string {
        return $this->armorGroup;
    }

    /**
     * @return string
     */
    public function getCreativeCategory(): string {
        return $this->creativeCategory;
    }

    public function getArmorSlot(): int
    {
        return 2;
    }

    /**
     * Parameters: Entity $victim
     * @param callable $listener
     */
    public function setAttackEntityListener(callable $listener): void {
        $this->attackListener = $listener;
    }


    /**
     * @param Entity $victim
     * @return bool
     */
    public function onAttackEntity(Entity $victim): bool
    {
        if (!is_null($this->attackListener)) {
            call_user_func($this->attackListener, $victim);
        }
        return parent::onAttackEntity($victim);
    }


    /**
     * Parameters: Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector
     *
     * @param callable $listener
     */
    public function setInteractOnBlockListener(callable $listener): void {
        $this->interactOnBlockListener = $listener;
    }


    /**
     * @param Player $player
     * @param Block $blockReplace
     * @param Block $blockClicked
     * @param int $face
     * @param Vector3 $clickVector
     * @return ItemUseResult
     */
    public function onInteractBlock(Player $player, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector): ItemUseResult
    {
        if (!is_null($this->interactOnBlockListener)) {
            call_user_func($this->interactOnBlockListener, $player, $blockReplace, $blockClicked, $face, $clickVector);
        }
        return parent::onInteractBlock($player, $blockReplace, $blockClicked, $face, $clickVector);
    }


    /**
     * Parameters: Block $block
     *
     * @param callable $listener
     */
    public function setDestroyBlockListener(callable $listener): void {
        $this->destroyBlockListener = $listener;
    }

    public function onDestroyBlock(Block $block): bool
    {
        if (!is_null($this->destroyBlockListener)) call_user_func($this->destroyBlockListener, $block);
        return parent::onDestroyBlock($block);
    }


    /**
     * Parameters: Player $player, Vector3 $directionVector
     *
     * @param callable $listener
     */
    public function setClickAirListener(callable $listener): void {
        $this->clickAirListener = $listener;
    }


    /**
     * @param Player $player
     * @param Vector3 $directionVector
     * @return ItemUseResult
     */
    public function onClickAir(Player $player, Vector3 $directionVector): ItemUseResult
    {
        if (!is_null($this->clickAirListener)) call_user_func($this->clickAirListener, $player, $directionVector);

        $existing = $player->getArmorInventory()->getItem($this->getArmorSlot() - 2);
        $thisCopy = clone $this;
        $new = $thisCopy->pop();
        $player->getArmorInventory()->setItem($this->getArmorSlot() - 2, $new);
        if($thisCopy->getCount() === 0){
            $player->getInventory()->setItemInHand($existing);
        }else{ //if the stack size was bigger than 1 (usually won't happen, but might be caused by plugins
            $player->getInventory()->setItemInHand($thisCopy);
            $player->getInventory()->addItem($existing);
        }
        return ItemUseResult::SUCCESS();

    }


    /**
     * Parameters: Player $player
     *
     * @param callable $listener
     */
    public function setReleaseUsingListener(callable $listener): void {
        $this->releaseUsingListener = $listener;
    }


    /**
     * @param Player $player
     * @return ItemUseResult
     */
    public function onReleaseUsing(Player $player): ItemUseResult
    {
        if (!is_null($this->releaseUsingListener)) call_user_func($this->releaseUsingListener, $player);
        return parent::onReleaseUsing($player);
    }
}
