<?php
namespace Testblog\Libs\Qdata;

class Tree {
	protected $Db;
	protected $table;
	protected $primary_key;
	
	private $relationships_table = "relationships";
	private $relationships_columns = ["table","parent_id","parent_level","child_id","child_level"];
	
	public function __construct(Database $Db, $table="tree", $primary_key="id") {
		$this->Db = $Db;
		$this->table = $table;
	}
	
	public function install() {
		$query = "
			CREATE TABLE IF NOT EXISTS `relationships` (  
				`table` char(255) NOT NULL,  
				`parent_id` int(11) NOT NULL,  
				`parent_level` int(11) NOT NULL, 
				`child_id` int(11) NOT NULL,
				`child_level` int(11) NOT NULL, 
				
				UNIQUE KEY `i_unique` (`table`,`parent_id`,`parent_level`,`child_id`,`child_level`)
			)
		";
		
		$this->Db->execute($query);
	}
	
	
	
	
	// Row functions
	protected function setRow($row) {
		$columns = "`";
		$placeholders = "";
		$updates = "";
		$insert_vars = [];
		$update_vars = [];
		$i=0;
		
		foreach ($row as $column=>$value) {	
			// Create strings
			$columns .= $column;
			$placeholders .= "?";
			$updates .= "`{$column}`=";
			$updates .= ($column == $this->primary_key) ? "LAST_INSERT_ID(?)" : "?";			
	
			// Add separators and closings to strings		
			if (count($row) != $i+1) {
				$columns .= "`, `";
				$placeholders .= ", ";
				$updates .= ", ";
			}
			else {
				$columns .= "`";
			}				
			
			// Associate vars to placeholders
			$insert_vars[] = $value;
			$update_vars[] = $value; 
			
			$i++;
		}
				
		// Build vars array
		$vars = array_merge($insert_vars, $update_vars);
		
		// Build query
		$query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
		$query .= " ON DUPLICATE KEY UPDATE {$updates}";
		
		echo $query . PHP_EOL;
		
		// Execute query
		$this->Db->execute($query, $vars);
		
		// Get row id
		$id = $this->Db->getValue("SELECT LAST_INSERT_ID()");
		
		return $id;
	}
	
	protected function remove($row) {
		
	}
	
	
	
	protected function getAncestors($child_id) {
		$query = "
			SELECT 
				`parent_id`, 
				`parent_level`,
				`child_level`
			FROM `{$this->relationships_table}` 
			WHERE 1
				AND `table`='{$this->table}' 
				AND `child_id`=? 
			ORDER BY `parent_level`
		";
		
		return $this->Db->getRows($query, [$child_id]);
	}
	
	protected function setRelationships($parent_id, $child_id) {
		$ancestors = $this->getAncestors($parent_id);
		$youngest_ancestor = end($ancestors);
		$parent_level = $youngest_ancestor->parent_level+1;
		$child_level = $youngest_ancestor->parent_level+2;

		$columns = "`" . implode("`, `", $this->relationships_columns) . "`";	
		$values  = "";
		
		// Add ancestors
		foreach ($ancestors as $i=>$ancestor) {
			$values .= "(?, ?, ?, ?, ?), ";			
			$vars[] = $this->table;
			$vars[] = $ancestor->parent_id;
			$vars[] = $ancestor->parent_level;
			$vars[] = $child_id;			
			$vars[] = $child_level;			
		}	
		
		// Add parent
		$values .= "(?, ?, ?, ?, ?)";
		$vars[] = $this->table;
		$vars[] = $parent_id;
		$vars[] = $parent_level;
		$vars[] = $child_id;			
		$vars[] = $child_level;				

		$query = "INSERT IGNORE INTO `{$this->relationships_table}` ({$columns}) VALUES {$values}";
		echo $query . PHP_EOL;
		
		$this->Db->execute($query, $vars);		
	}
	
	protected function deleteChildRelationships($id) {
		$this->execute("DELETE FROM `{$this->relationships_table}` WHERE `child_id`=?", [$id]);
	}
	
	
	
	
	public function set($row, $parent_id=null) {
		$child_id = $this->setRow($row);
		
		if (!empty($parent_id)) {	
			// $this->deleteChildRelationships($child_id);
			$this->setRelationships($parent_id, $child_id);
		}
	}
	
	public function get() {
		
	}
	
	public function delete() {
		
	}
}
?>
