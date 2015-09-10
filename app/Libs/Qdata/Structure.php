<?php
namespace Testblog\Libs\Qdata;

interface Structure {
    public function getFields();
    public function getPrimaryField();
    public function getDeletedField();
    public function getTableName();
    public function getCreateTableQuery();
        
    public function createExemplarFromRaw($exemplar);
    
}
