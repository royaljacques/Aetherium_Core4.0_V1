<?php

namespace royal\AetheriumCore\task;


use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;

class MysqlTask extends AsyncTask{


    private string $text;
    private string $database;

    public function __construct(string $text, string $database)
    {
        $this->text = $text;
        $this->database = $database;
    }
    public function getTaskLoader(){
        return null;
    }

    /**
     * @throws \Exception
     */

    public function onRun(): void
    {
        $db = match ($this->database) {
            "Aetherium_Job" => new \MySQLi("127.0.0.1", "root", "", "Aetherium_Job"),
            "discord_api" => new \MySQLi("127.0.0.1", "root", "", "Aetherium_Bot"),
            "Aetherium_stats" => new \MySQLi("127.0.0.1", "root", "", "Aetherium_stats"),
            "Aetherium_Logs" => new \MySQLi("127.0.0.1", "root", "", "Aetherium_Logs"),
        };
        $db->query($this->text);
        if ($db->error) throw new \Exception($db->error);
        $db->close();
    }
    public function onCompletion(): void
    {

    }


}
