<?php
namespace royal\AetheriumCore\api;

use jojoe77777\FormAPI\SimpleForm;
use pocketmine\player\Player;

class WikiAPI{

    public static function IndexWiki(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if ($data === null){
                return true;
            }
            switch($data){
                case 0:
                    self::EnchantementsWiki($player);
            }
        });
        $form->setTitle("Wiki");
        $form->addButton("Enchantements");
    }
    public static function EnchantementsWiki(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            if ($data === null){
                return true;
            }
            switch($data){
                case 0:
                    $content = [
                        "Nom: Foreuse",
                        "Niveau max: 3",
                        "Item Enchantable: Hammer\n",
                        "incompatible: Trefle",
                        "Description: Cet enchantement vous permet de casser plus de block en 1 seul coup avec le hammeur",
                    ];
                    self::sendWikiTexte($player, $content);
                    break;
                case 1:
                    $content = [
                        "Status: ",
                        "Nom: Trefle",
                        "Niveau max: 2",
                        "Item Enchantable: hache, houe\n",
                        "incompatible: Foreuse",
                        "Description: Cet enchantement vous permet d'avoir un taux de spawn plus élevé en cassant un block",
                    ];
            }
            return true;
        });
        $form->setTitle("Wiki");
        $form->setContent("Bienvenue dans le wiki des enchantements, choisis un enchantements pour voir ce que il fais . \nattention , vérifier bien le status de l'enchantement , il peut etre en dev mais être afficher , ou que vous puissiez enchantez l'item . mais en jeux il ne fera absolument rien ");
        $form->addButton("Foreuse");
        $form->addButton("Trefle");
        $player->sendForm($form);
    }

    public static function sendWikiTexte(Player $player, array $content){
        $form = new SimpleForm(function(Player $player, int $data = null){
        });
        $form->setTitle("Wiki");
        $form->setContent(implode("\n", $content));
        $form->addButton("Quitter");
        $player->sendForm($form);

    }
}