<?php

declare(strict_types=1);

namespace Krishvy;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Durable;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

class RepairCommand extends Command
{
    public function __construct()
    {
        parent::__construct("repair", "Repair all items in your inventory or repair the item in ur hand");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if(!$sender instanceof Player){
            return true;
        }
        if(count($args) < 1) {
            $sender->sendMessage(TextFormat::RED . "Usage: /repair [all/hand/armor]");
            return true;
        }
        switch($args[0]){
            case "all":
                if($sender->hasPermission("repairall.use")) {
                    foreach ($sender->getInventory()->getContents() as $index => $item) {
                        if ($item instanceof Durable) {
                            $sender->getInventory()->setItem($index, $item->setDamage(0));
                        }
                    }
                    $sender->sendMessage(TextFormat::GREEN . "Successfully repaired all items in your inventory.");
                } else $sender->sendMessage(TextFormat::RED."You do not have the permission to use this command.");
                break;
            case "hand":
                if($sender->hasPermission("repairhand.use")) {
                    $index = $sender->getInventory()->getHeldItemIndex();
                    $item = $sender->getInventory()->getItem($index);
                    if ($item instanceof Durable) {
                        $sender->getInventory()->setItem($index, $item->setDamage(0));
                    }
                } else $sender->sendMessage(TextFormat::RED."You do not have the permission to use this command.");
                break;
            case "armor":
                if($sender->hasPermission("repairarmor.use")) {
                    foreach ($sender->getArmorInventory()->getContents() as $index => $item) {
                        if ($item instanceof Durable) {
                            $sender->getArmorInventory()->setItem($index, $item->setDamage(0));
                        }
                    }
                    $sender->sendMessage(TextFormat::GREEN . "Successfully repaired all your equipped armor.");
                } else $sender->sendMessage(TextFormat::RED."You do not have the permission to use this command.");
                break;
        }
        return true;
    }
}
