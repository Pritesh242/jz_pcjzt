<?php

class DB
{
    protected $pdo;

    function __construct()
    {
    	/*
        $serverName = env("MYSQL_PORT_3306_TCP_ADDR", "localhost");
        $databaseName = env("MYSQL_INSTANCE_NAME", "homestead");
        $username = env("MYSQL_USERNAME", "homestead");
        $password = env("MYSQL_PASSWORD", "secret");
        */
        $serverName = getenv("MYSQL_PORT_3306_TCP_ADDR");
        $databaseName = getenv("MYSQL_INSTANCE_NAME");
        $username = getenv("MYSQL_USERNAME");
        $password = getenv("MYSQL_PASSWORD");

        try {
            $this->pdo = new PDO("mysql:host=$serverName;dbname=$databaseName", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 检测数据库是否存在表
            $isInstall = $this->pdo->query("SHOW TABLES like 'jizhetuan';")
                ->rowCount();

            if (!$isInstall) {
                $sql = "
            CREATE TABLE jizhetuan (
            id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name CHAR(50) NOT NULL,
            longnum CHAR(100) NOT NULL,
            shortnum CHAR(100) NOT NULL,
            department CHAR(100) NOT NULL,
            content VARCHAR(5000) NOT NULL)
            ";
                $this->pdo->exec($sql);
            }
        } catch (PDOException $e) {
            echo "数据库链接失败: " . $e->getMessage();
            die();
        }
    }

    public function all()
    {
        return $this->pdo->query('SELECT * from jizhetuan')
            ->fetchAll();
    }

    public function find($id)
    {
        return $this->pdo->query("SELECT * from jizhetuan WHERE id = $id ")
            ->fetch();
    }

    public function remove($id)
    {
        return $this->pdo->exec("DELETE from jizhetuan WHERE id = $id ");
    }

    public function add($name, $longnum, $shortnum, $department, $content)
    {
        $sql = "INSERT INTO jizhetuan (name, longnum, shortnum, department, content) VALUES ('$name','$longnum', '$shortnum', '$department', '$content')";
        return $this->pdo->exec($sql);
    }
}
