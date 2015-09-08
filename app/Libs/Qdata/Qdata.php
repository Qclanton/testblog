<?php
namespace Testblog\Libs\Qdata;

class Qdata {
    private $Database;
    
    public function __construct($host="localhost", $user="root", $password="", $schema="", $port=3306) {
        $this->Database = new Mysql($host, $user, $password, $schema, $port);
    }
    
    public function test() {
        return "Test passed. Qdata";
    }
}
