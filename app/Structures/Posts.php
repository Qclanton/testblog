<?php
namespace Testblog\Structures;

use \Testblog\Libs\Qdata\Qdata;
use \Testblog\Libs\Qdata\Structure;

class Posts extends Qdata implements Structure
{
    public function getFields() 
    {
        return ["id", "title", "text"];
    }
    
    public function getPrimaryField() 
    {
        return "id";
    }
    
    public function getDeletedField() 
    {
        return false;
    }
    
    public function getTableName() 
    {
        return "posts"; 
    }
    
    public function getCreateTableQuery() 
    {
        return "
            CREATE TABLE `posts` (  
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,  
                `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,  
                `text` text COLLATE utf8_unicode_ci NOT NULL,  
                
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
        ";
    }
        
    public function createExemplarFromRaw($exemplar) 
    {
        return (object)$exemplar;
    }
}
