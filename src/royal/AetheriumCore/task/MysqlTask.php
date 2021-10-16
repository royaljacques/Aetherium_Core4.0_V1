<?php

namespace royal\AetheriumCore\task;


use pocketmine\scheduler\AsyncTask;

class MysqlTask extends AsyncTask{


    private string $text;
    private string $database;

    public function __construct(string $text, string $database)
    {
        $this->text = $text;
        $this->database = $database;
    }
    public function onRun(): void
    {

    }

    /**
     * @throws \Exception
     */
    public function onCompletion(): void
    {
        var_dump($this->database);
        switch ($this->database) {
            case "Aetherium_Job":
                var_dump($this->text);
                $db = new \MySQLi("127.0.0.1", "root", "", "Aetherium_Job");
                break;
            case "discord_api":
                $db = new \MySQLi("127.0.0.1", "root", "", "Aetherium_Bot");
                break;
            case "Aetherium_stats":
                $db = new \MySQLi("127.0.0.1", "root", "", "Aetherium_stats");
                break;
        }
        $db->query($this->text);
        if ($db->error) throw new \Exception($db->error);
        $db->close();
    }
}
