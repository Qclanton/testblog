<?php
namespace Testblog\Libs\Qdata;

class Mysql {
    private $connection;    
    
    public function __construct($host="localhost", $user="root", $password="", $schema="", $port=3306) {
        $connection = new \mysqli($host, $user, $password, $schema, $port);

        if ($connection->connect_error) {
            throw new \Exception("Connection failed: {$connection->connect_error}");
        }
        
        
        $this->connection = $connection;
        $this->execute(" SET NAMES 'UTF8' ");
        $result = true;        
        
        return $result;    
    }
    
    public function closeConnection($connection = null) {    
        $connection->close;
        
        return $this;
    }
    
    
    
    
    private function getReferences($array) {      
        foreach($array as $key => $value) {
            $references[$key] = &$array[$key];
        }
        
        return $references; 
    }
    
    private function prepareStatement($query, array $params = []) {
        $statement = $this->connection->prepare($query);        

        if (!$statement) {
            throw new \Exception("Preparing failed: " . $this->connection->error);
        }
        
        if (!empty($params)) {
            $params_types = "";
            $params_values = [];
            foreach ($params as $param) {
                $param_type = (is_array($param) ? current($param) : "s");
                $param_value = (is_array($param) ? key($var) : $param);
                
                $params_types .= $param_type;
                $params_values[] = $param_value;
            }
            array_unshift($params_values, $params_types);
            call_user_func_array([$statement, "bind_param"], $this->getReferences($params_values)); 
        }        
        
        
        return $statement;        
    }
    
    
    
    
    
    public function getRows($query, array $params = []) {
        $statement = $this->prepareStatement($query, $params);
        if (!$statement) { 
            throw new \Exception ("Preaparing of statement failed. Error: " . $this->connection->error());
        }
        
        $statement->execute();        
           
        $meta = $statement->result_metadata();
        while ($field = $meta->fetch_field()) { 
             $columns[] = &$row[$field->name]; 
        } 

        call_user_func_array([$statement, "bind_result"], $columns); 

        $result = null;
        while ($statement->fetch()) {            
            foreach ($row as $key=>$value) {
                $row_data[$key] = $value;
            }
                     
            $result[] = (object)$row_data;
        }
                
        $statement->close();        
        
        return $result;    
    }
        
    public function getRow($query, array $params = []) {
        $data = $this->getRows($query, $params);
        
        return (isset($data[0]) ? $data[0] : null);
    }
    
    public function getValue($query, array $params = []) {
        $result = $this->getRows($query, $params);
        
        return ($result
            ? array_values((array)$result[0])[0]
            : null
        );
    }
    

    public function execute($query, array $params = []) {
        $statement = $this->prepareStatement($query, $params);
        $statement->execute();
        $statement->close();
        
        return true;    
    }
}
?>
