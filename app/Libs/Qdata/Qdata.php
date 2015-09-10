<?php
namespace Testblog\Libs\Qdata;

abstract class Qdata
{
    protected $Database;
    
    protected $table;
    protected $primary_field;
    protected $deleted_field;
    
    
    
    
    // Default values to implement Structure
    public function getTableName() 
    {
        return ""; 
    }
    
    public function getPrimaryField() 
    {
        return "id";
    }
    
    public function getDeletedField() 
    {
        return false;
    }
    
    public function createExemplarFromRaw($exemplar) 
    {
        return (object)$exemplar;
    }
    
    
    
    
    
    private function setDeletedField() {
        $deleted_field = $this->getDeletedField();
        if (empty($deleted_field)) {
            $deleted_field = 0;
        }
        
        $this->deleted_field = $deleted_field;
    }
    
    public function __construct(Mysql $Database) {
        $this->Database = $Database;
        
        $this->table = $this->getTableName();
        $this->primary_field = $this->getPrimaryField();
        $this->setDeletedField();
    }
    
    
    
    

    
    
    
    
    // Set functions
    public function set($data) 
    {
        $result = (is_object($data) ? $this->setOne($data) : $this->setFew($data));
        
        return $result;
    }
    
    private function setOne($exemplar) 
    {
        $return_id = true;
        $exemplar = (object)$exemplar;
        
        if (!empty($exemplar->{$this->primary_field})) {
            $return_id = false;
            $existed = $this->get($exemplar->{$this->primary_field});

            if (!empty($existed)) {
                $exemplar = array_merge((array)$existed, (array)$exemplar);
            }
        }
        
        $exemplar = $this->Structure->createExemplarFromRaw($exemplar);
        $prepared = $this->prepareInsert($exemplar);
        
        
        $query = "INSERT INTO `{$this->table}` VALUES ({$prepared->query_add})";
        $query .= " ON DUPLICATE KEY UPDATE {$prepared->query_replace}"; 
        

        $result = $this->Db->execute($query, $prepared->vars);        
        return ($result && $return_id) ? $this->getLastId() : $result;
    }
    
    private function setFew($exemplars) 
    {
        $result = false;
        
        foreach ($exemplars as $exemplar) {            
            $result = $this->setOne($exemplar);
            if (!$result) { break ; }
        }
        
        return $result;
    }
    
    
    
    
    // Get functions
    public function get($criterion=false, $ties_mode="with_ties") 
    {        
        return (is_int($criterion) || is_string($criterion) 
            ? $this->getOne(new Criterion($criterion), $ties_mode)
            : $this->getFew(new Criterion($criterion), $ties_mode)            
        );        
    }    
    
    public function getOne($criterion=false, $ties_mode="with_ties") 
    {
        list($query, $vars) = $this->createQuery($criterion);

        $exemplar = $this->Database->getRow($query, $vars);
        if (!empty($exemplar)) {
            $exemplar = $this->createExemplarFromRaw($exemplar);
            // $exemplar = ($ties_mode === "with_ties" ? $this->attachTies($exemplar) : $exemplar);
        }
        
        return $exemplar;
    }
    
    public function getFew($criterion=false, $ties_mode="with_ties") 
    {
        list($query, $vars) = array_values($this->createQuery($criterion));
        
        $exemplars = $this->Database->getRows($query, $vars);        
        foreach ($exemplars as &$exemplar) {
            $exemplar = $this->createExemplarFromRaw($exemplar);
            // $exemplar = ($ties_mode === "with_ties" ? $this->attachTies($exemplar) : $exemplar);
        }
        
        return $exemplars;
    }
    
    
    
    
    // Mysql part 
    private function prepareInsert($exemplar) {
        $structure_fields = $this->Structure->getFields();
        
        $vars_add = []; 
        $vars_replace = [];
        $query_add = "";
        $query_replace = "";
        $i=1;        
            
        foreach ($structure_fields as $field=>$params) {
            if ($params->type === "bool") { $exemplar->{$field} = intval($exemplar->{$field}); }
            
            $query_add .= "?"; 
            if ($i < count((array)$structure_fields)) { 
                $query_add .= ", "; 
            }
                                    
            $vars_add[] = [$exemplar->{$field}=>$this->getPreparedStatementType($params)];    
            
                
            if ($params->editable) {
                $query_replace .= "`{$field}`=?"; if ($i < count((array)$structure_fields)) { $query_replace .= ", "; }                        
                $vars_replace[] = ['type'=>$this->getPreparedStatementType($params), 'value'=>$exemplar->{$field}];    
            }
            
            $i++;
        }
        
        return (object)[
            'query_add' => $query_add, 
            'query_replace' => $query_replace,
            'vars' => array_merge($vars_add, $vars_replace)
        ];        
    }
    
    private function createQuery(Criterion $criterion, $action="select") 
    {      
        switch ($action) {
            case "select": 
                $begin = "SELECT * FROM "; 
                break;
                
            case "update": 
                $begin = "UPDATE";
                break;
                
            case "delete": 
                $begin = "DELETE FROM";
                break;
        }
        
        
        $query = "{$begin} `{$this->table}` ";
        
        
        if ($action === "update" && !empty($criterion->set)) {
            $query .= " SET";
            
            foreach ($criterion->set as $set) {
                $query .= " `{$set->field}`=?";
                $vars[] = $set->value; 
            }
        }
        
        
        $query .= " WHERE {$this->deleted_field}=? ";
        $vars[] = 0;
        
        if (!empty($criterion->where)) {            
            foreach ($criterion->where as $where) {
                $query .= " AND {$where->query}";
                
                if (!is_null($where->vars)) {
                    $vars = array_merge($vars, $where->vars);
                }
            }
        }
        
        /*
        if (!empty($criterion)) {            
            if (isset($criterion['where'])) { 
                $query .= "AND ";
                if (is_array($criterion['where']) || is_object($criterion['where'])) {
                    $where = (object)$criterion['where'];
                    $query .= $where->query;
                    $vars = array_merge($vars, (array)$where->vars);
                }
                else {
                    $query .= "{$criterion['where']}";
                }
            }
            if ($action=='select') { 
                if (isset($criterion['orderby'])) {
                    $query .= " ORDER BY `{$criterion['orderby']}`";            
                    if (isset($criterion['order'])) { $query .= " {$criterion['order']}"; }
                }                    
                if (isset($criterion['limit'])) { $query .= " LIMIT {$criterion['limit']}"; }
            }
        }
        */
        return [$query, $vars];    
    }
    
    
    
    
    
    public function tie($structure, $type="single", $deletion_type="as_parent") {        
        if (is_string($structure)) { 
            $tie = ($type == "reverse" 
                ? (object)['key'=>"id", 'name'=>$structure]
                : (object)['key'=>$structure . ($type=='single' ? "_id" : "_ids"), 'name'=>$structure]
            ); 
        }
            
        if (is_array($structure)) { $tie = (object)$structure; }
        $tie->type = $type;
        $tie->deletion_type = $deletion_type;
                    
        $this->ties[] = $tie;
        
        return $this;
    }
    
    private function attachTies($exemplar) {
        if (!empty($this->ties)) {
            foreach ($this->ties as $tie) {
                if (!isset($exemplar->{$tie->key})) { throw new \Exception ("Key doesn't exists in exemplar"); }                
                $tie->ids = $exemplar->{$tie->key};
                
                $TieData = new Data($this->Db, $tie->name);
                
                switch ($tie->type) {
                    case 'single';
                        $criterion = $tie->ids; break;
                    case 'reverse';
                        $criterion = ['where'=>['query'=>"`{$this->table}_{$this->primary_field}`=?", 'vars'=>$tie->ids]]; break;
                    case 'list':
                        $criterion = ['where'=>$this->prepareIn($TieData->primary_field, explode(',', $tie->ids))]; break;
                    default: 
                        throw new \Exception ("Incorrect tie type"); break;
                }

                $exemplar->{$tie->name} = $TieData->get($criterion);
            }
        }
        
        return $exemplar;
    } 
    
    
    
    
    private function deleteTied($exemplars) {
        if (is_object($exemplars)) { $exemplars = [$exemplars]; }
        $result = true;        

        foreach ($exemplars as $exemplar) { 
            foreach ($this->ties as $tie) {
                if (!isset($exemplar->{$tie->key})) { throw new \Exception ("Key doesn't exists in exemplar"); }
                
                $tie->ids = $exemplar->{$tie->key}; 
                $criterion = ['where'=>['query'=>"`{$this->table}_{$this->primary_field}`=?", 'vars'=>$tie->ids]];
                
                $TieData = new Data($this->Db, $tie->name);
                $result = $TieData->delete($criterion, $tie->deletion_type);
            }
        }
        
        return $result;
    }
    
    public function delete($criterion, $type="temporary") {
        $action = ($type == "permanently" || empty($this->deleted_field) ? "delete" : "update");
        
        if (!empty($this->ties)) {
            $exemplars = $this->get($criterion, "without_ties");
            
            if (!empty($exemplars)) {
                foreach ($this->ties as &$tie) {
                    if ($tie->deletion_type === "as_parent") { $tie->deletion_type = $type; } // Set parent deletion type for ties
                }            
                
                $this->deleteTied($exemplars);
            }
        }
        
        
        if ($action == "update") {
            $criterion['set'] = [['field'=>$this->deleted_field, 'value'=>1]];
        }
        
        $sql = (object)$this->createQuery($criterion, $action);            
        return $this->Db->execute($sql->query, $sql->vars);
    }
    
    public function markAsDeleted($criterion) {
        if (empty($this->deleted_field)) { return false; }
        
        $criterion['set'] = ['field'=>$this->deleted_field, 'value'=>1];
        $sql = (object)$this->createQuery($criterion, $action);

        return $this->Db->execute($sql->query, $sql->vars);
    }
    
    
    public function restore($criterion) {
        if (empty($this->deleted_field)) { return false; }
        
        $criterion['set'] = ['field'=>$this->deleted_field, 'value'=>0];
        $sql = (object)$this->createQuery($criterion, $action);

        return $this->Db->execute($sql->query, $sql->vars);    
    }
    
    
     
    private function getMysqlType($field) {
        $string = "";
        
        switch ($field->type) {
            case 'bool': $string .= "TINYINT(1)"; break;
            case 'int': $string .= "INT(11)"; break;
            case 'float': $string .= "FLOAT(11,4)"; break;
            
            case 'string': $string .= "CHAR(255)"; break;
            case 'enum':
                $values = explode("|", $fields->mask);
                $values_str = implode("','", str_replace("^", "", str_replace("$", "", $values))); 
                $string .= "ENUM('{$values_str}')"; 
                break;
            case 'text': $string .= "TEXT"; break;
            case 'list': $string .= "TEXT"; break;
            case 'json': $string .= "TEXT"; break;
            
            case 'datetime': $string .= "DATETIME"; break;            
        }
        
        return $string;
    }
    
    private function getPreparedStatementType($field) {
        switch ($field->type) {
            case 'bool': $type = "i"; break;
            case 'int': $type = ($field->auto_increment ? "s" : "i"); break; // Prepared statement doesn't support null values for integer fields
            case 'float': $type = "d"; break;            
            default: $type = "s"; break;
        }
        
        return $type;
    }
    
    public function prepareIn($field, $values) {
        if (empty($values)) { return false; }

        $query = "`{$field}` IN (";
        foreach($values as $i=>$value) {
            $query .= "?"; if (count($values) != $i+1) { $query.=","; }
            $vars[] = $value;
        }
        $query .=")";
        
        return ['query'=>$query, 'vars'=>$vars];
    }
    
    public function getLastId() {
        return $this->Db->getValue("SELECT LAST_INSERT_ID()");
    }
}
