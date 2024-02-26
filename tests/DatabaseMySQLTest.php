<?php

namespace JsonRpc\JsonRpc\Tests;

use PHPUnit\Framework\TestCase;
use JsonRpc\Driver\DatabaseMySQL as DBDriver;

class DatabaseMySQLTest extends TestCase
{
    public function testSelect()
    {
        $db = new DBDriver();
        $escapedCode = "RO";
        $result = $db->runQuery("SELECT `prefix`, `name` FROM `locations_countries` WHERE `code`='$escapedCode'");
        $output = ["prefix" => "+40", "name" => "Romania"];
        $this->assertSame($result[0], $output);
    }

    public function testInsertDelete()
    {
        $db = new DBDriver();
        $escapedCode = "RO";
        $id = $db->runQuery("INSERT INTO `locations_countries` (`id`, `name`, `code`, `prefix`) VALUES
          (5000, 'Romania', 'RO', '+40')");
        $this->assertIsInt($id);
        $affectedRows = $db->runQuery("DELETE from `locations_countries` WHERE id=$id");
        $this->assertSame($affectedRows, 1);
    }

    public function testUpdate()
    {
        $db = new DBDriver();
        $escapedCode = "RO";
        $affectedRows = $db->runQuery("UPDATE `locations_countries` SET `prefix`='+44' WHERE `code`='$escapedCode'");
        $this->assertSame($affectedRows, 1);
        $db->runQuery("UPDATE `locations_countries` SET `prefix`='+40' WHERE `code`='$escapedCode'");
        $escapedCode = "ZZZ";
        $affectedRows = $db->runQuery("UPDATE `locations_countries` SET `prefix`='+44' WHERE `code`='$escapedCode'");
        $this->assertSame($affectedRows, 0);
    }
}
