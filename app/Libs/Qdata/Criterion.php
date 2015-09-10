<?php
namespace Testblog\Libs\Qdata;

class Where {
    public $query;
    public $vars;
    
    public function __construct($query, array $vars=null) {
        $this->query = (string)$query;
        $this->vars = $vars;
    }
}

class Set {
    public $field;
    public $value;
    
    public function __construct($field, array $value) {
        $this->field = (string)$field;
        $this->value = $value;
    }  
}






class Criterion {
    public $primary_field = "id";
    public $where;
    public $set;
    public $order;
    public $limit;
    
    
    
    
    public function createFromRaw($criterion) 
    {
        if (!is_int($criterion) && !is_string($criterion) && !is_array($criterion) && !($criterion instanceof Criterion)) {
            throw new \Exception ("Criterion must have type \"integer\", \"string\" or \"array\" or be instance of \"Criterion\"");
        }
        
        if (is_int($criterion) || is_string($criterion)) {
            $this->where("`{$this->primary_field}`=?", [$criterion]);
        } else {
            // WHERE
            if (!empty($criterion['where'])) {
                // Place single 'where' into array 
                if (isset($criterion['where']['query']) || (isset($criterion['where'][0]) && is_string($criterion['where'][0]))) {                   
                    $criterion['where'][] = [
                        'query' => (isset($criterion['where']['query']) 
                            ? $criterion['where']['query'] 
                            : $criterion['where'][0]
                        ),
                        
                        'vars' => (isset($criterion['where']['vars'])
                            ? $criterion['where']['vars'] 
                            : (is_string($criterion['where'][0]) && isset($criterion['where'][1]) 
                                ? $criterion['where'][1]
                                : null
                            )
                        )
                    ];
                }
                
                // Clean 'where' array
                unset($criterion['where']['query']);
                unset($criterion['where']['vars']);
                
                if (is_string($criterion['where'][0])) {
                    if (!isset($criterion['where'][1]['query'])) {
                         unset($criterion['where'][1]);
                    }
                    
                    unset($criterion['where'][0]);
                }
                
                
                // Handle all 'where'
                foreach ($criterion['where'] as $where) {
                    if (!isset($where['query'])) {
                        throw new \Exception ("'Where' must contains 'query'");
                    }
                    
                    $this->where($where['query'], $where['vars']);
                }                
            } 
            
            
            // SET
            if (!empty($criterion['set'])) {
                // Place single 'set' into array 
                if (isset($criterion['set']['field']) && isset($criterion['set']['value'])) {
                    $criterion['set'][] = ['field'=>$criterion['set']['field'], 'value'=>$criterion['set']['value']];
                    
                    unset($criterion['set']['field']);
                    unset($criterion['set']['value']);
                }
                
                // Handle all 'where'
                foreach ($criterion['set'] as $set) {
                    if (!isset($criterion['set']['field']) || !isset($criterion['where']['vars'])) {
                        throw new \Exception ("'Set'  must contains 'field' and 'value'");
                    }
                    
                    $this->set($set['field'], $set['value']);
                }                
            } 
        }
    }
    
    public function cloneInstance($instance) 
    {
        $this->primary_field = $instance->primary_field;
        $this->where = $instance->where;
        $this->set = $instance->set;
        $this->order = $instance->order;
        $this->limit = $instance->limit;
    }
    
    public function __construct($criterion=null, $primary_field="id") 
    {
        $this->setPrimaryField($primary_field);
        
        if (!empty($criterion)) {
            $criterion instanceof Criterion
                ? $this->cloneInstance
                : $this->createFromRaw($criterion)
            ;
        }        
    }
    

    
    
    
    
    public function setPrimaryField($primary_field) 
    {
        $this->primary_field = $primary_field;
        
        return $this;        
    }
    
    public function where($query, $vars) 
    {
        $this->where[] = new Where($query, $vars);
        
        return $this;
    }
    
    public function set($field, $value) 
    {
        $this->set[] = new Set($field, $value);
        
        return $this;
    }
    
    public function order($field, $side="ASC") 
    {        
        return $this;
    }
    
    public function limit($quantity, $from=0) 
    {
         return $this;
        
    }
    

}
