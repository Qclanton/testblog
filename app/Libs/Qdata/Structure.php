<?php
namespace Testblog\Libs\Qdata;

interface Structure {
    // Database options
    public function getFields();
    public function getPrimaryField();
    public function getDeletedField();
    public function getTableName();
    public function getCreateTableQuery();
    
    public function createExemplarFromRaw($exemplar);
    
    /*
    public function getOne(Criterion $criterion);
    public function getFew(Criterion $criterion);
    public function set($exemplar);
    public function delete(array $exemplars);  
    */
}
