<?php
namespace Testblog\Libs\Qdata;

class Mysql {
    private $connection;
    private $is_transaction_started = false;
    private $is_transaction_failed = false;    
    
    
    
    

    public function __construct($host="localhost", $user="root", $password="", $schema="", $port=3306) 
    {
        $connection = new \mysqli($host, $user, $password, $schema, $port);

        if ($connection->connect_error) {
            throw new \Exception("Connection failed: {$connection->connect_error}");
        }        
        
        $this->connection = $connection;
        $this->execute(" SET NAMES 'UTF8' ");      
    }
    
    public function closeConnection($connection = null) 
    {    
        $connection->close;
        
        return $this;
    }
    
    
    
    
    
    private function prepareStatement($query, array $params = [])
    {
        // Prepare query
        $statement = $this->connection->prepare($query);     
        if (!$statement) {
            throw new \Exception("Preparing failed. Error: {$this->connection->error}");
        }
        
        
        // Bind params
        if (!empty($params)) {
			$types = "";            
			foreach ($params as $index=>$param) {
				${$index} = (is_array($param) ? key($param) : $param);
											   
				$types .= (is_array($param) ? current($param) : "s");
				$values[] = &${$index};
			}
			array_unshift($values, $types);		
			
			
			call_user_func_array([$statement, "bind_param"], $values); 
		}    
        
        
        return $statement;        
    }





    public function getRows($query, array $params = []) 
    {
        $statement = $this->prepareStatement($query, $params);        
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
		// Handle errors during preparing statements
		try {
			$statement = $this->prepareStatement($query, $params);
			$statement->execute();                    
        } catch (\Exception $e) {
            if ($this->is_transaction_started) {
                $this->is_transaction_failed = true;  
                $this->transactionEnd();
            }
            
            throw $e;
        }
        
		// Handle errors during execituin query
        if ($statement->error) {
			if ($this->is_transaction_started) {
                $this->is_transaction_failed = true;  
                $this->transactionEnd();
			}
			
			throw new \Exception("Query execution error: {$statement->error}");			
		}
		

		$statement->close();
        
        
        return $this;    
    }
    
    public function transactionStart() {
        $this->is_transaction_started = true;
        $this->is_transaction_failed = false;
        $this->connection->begin_transaction();
        
        return $this;
    }
    
    public function transactionEnd() {
		if ($this->is_transaction_started) {
			!$this->is_transaction_failed
				? $this->connection->commit()
				: $this->connection->rollback()
			;
		}
        
        $this->is_transaction_started = false;
        
        return $this;
    }
}
?>
