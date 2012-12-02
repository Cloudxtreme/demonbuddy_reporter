<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Demonbuddy_model extends CI_Model {
	
    function Demonbuddy_model()
    {
        parent::__construct();
    }
	
	function add_items($items){
		//vardump($items);
		//Loop over each item
		foreach($items as $item){
			if($this->_item_exists($item)){
				continue;
			}else {
				//echo "inserting({$item['name']})<br/>";
			}
			//Set the basic variables
			$insert_array = array(
				'character_id' => $item['character'],
				'item_slot_id' =>$this->_get_insert_slot($item['slot']),
				'item_type_id' => $this->_get_insert_type($item['type']),
				'score' => $item['score'],
				'legendary' => $item['legendary'],
				'name' => $item['name'],
				'date_added' => time()
			);
			
			
			//Insert item
			$this->db->insert('db_items', $insert_array);
			$item_id = $this->db->insert_id();
			
			//Loop over stats for each item
			foreach($item['stats'] as $stat){
				$stat_id = $this->_get_insert_stat($stat['stat']);
				
				$insert_array = array(
					'item_id' => $item_id,
					'stat_id' => $stat_id,
					'value'	=> $stat['value']
				);
				$this->db->insert('db_item_stats', $insert_array);
			}
		}
	}
	
	function load_todays_items(){
		$this->db->select('*, db_items.id as item_id, db_items.name as item_name, db_items.id as id, db_item_slots.name AS slot_name, db_item_types.name as type_name, db_characters.name as character_name, db_characters.class, db_characters.color');
		$this->db->join('db_characters', 'db_characters.id = db_items.character_id', 'inner');
		$this->db->join('db_item_slots', 'db_item_slots.id = db_items.item_slot_id', 'inner');
		$this->db->join('db_item_types', 'db_item_types.id = db_items.item_type_id', 'inner');
		$this->db->where('date_added > ', strtotime("midnight"));
		$this->db->order_by('db_items.id', 'DESC');
		$query = $this->db->get('db_items');
		
		$return_array = array();
		foreach($query->result() as $item){
			$this->db->select('*, db_stats.name as stat_name');
			$this->db->join('db_stats', 'db_item_stats.stat_id = db_stats.id', 'l');
			$stats_query = $this->db->get_where('db_item_stats', array('item_id' => $item->id));
			$item->stats = $stats_query->result();
			$item->date_added = date('h:i:sA', $item->date_added);
			$item->url_name = stripText($item->item_name);
			$return_array[] = $item;
		}
		
		return $return_array;
	}
	
	function load_console_message_after_id($previous_id){
		$query = $this->db->get_where('db_console_messages', array('id >' => $previous_id));
		
		$messages = array();
		foreach($query->result() as $row){
			$message = array(
				'id' => $row->id,
				'message' => $row->message,
				'date_added' => $row->date_added,
				'character_id' => $row->character_id
			);
			$messages[] = $message;
		}
		return $messages;
	}
	
	function get_last_console_message_id(){
		$this->db->select('max(id) as last_console_message_id');
		$query = $this->db->get('db_console_messages');
		return $query->row()->last_console_message_id;
	}
	
	function load_items_after_id($previous_id){
		$this->db->select('*, db_items.legendary, db_items.id as item_id, db_items.name as item_name, db_items.id as id, db_item_slots.name AS slot_name, db_item_types.name as type_name, db_characters.name as character_name, db_characters.class, db_characters.color');
		$this->db->join('db_characters', 'db_characters.id = db_items.character_id', 'inner');
		$this->db->join('db_item_slots', 'db_item_slots.id = db_items.item_slot_id', 'inner');
		$this->db->join('db_item_types', 'db_item_types.id = db_items.item_type_id', 'inner');
		$this->db->where('date_added > ', strtotime("midnight"));
		$this->db->order_by('db_items.id', 'ASC');
		$query = $this->db->get_where('db_items',array('db_items.id >'=>$previous_id));
		
		$return_array = array();
		foreach($query->result() as $item){
			$this->db->select('*, db_stats.name as stat_name');
			$this->db->join('db_stats', 'db_item_stats.stat_id = db_stats.id', 'l');
			$stats_query = $this->db->get_where('db_item_stats', array('item_id' => $item->id));
			$item->stats = $stats_query->result();
			$item->date_added = date('h:i:sA', $item->date_added);
			$item->url_name = stripText($item->item_name);
			$return_array[] = $item;
		}
		
		return $return_array;
	}
	
	function get_last_item_found_epoch(){
		$this->db->order_by('id', 'DESC');
		$this->db->limit('1');
		$query = $this->db->get('db_items', 1,0);
		$row = $query->row();
		if(!empty($row)){
			return $row->date_added;
		}
		return 0;
	}
	
	function _item_exists($item){
		//Get all the items that match the names
		$query = $this->db->get_where('db_items', array('name' => $item['name']));
		$result = $query->result(); 
		//If any names match... get that items stats
		if(empty($result)){
			return false;
		}
		
		foreach($result as $row){
			$query = $this->db->get_where('db_item_stats', array('item_id' => $row->id));
			$matches_array = array();
			foreach($query->result() as $index => $row){
				$stat_value_match = false;
				foreach($item['stats'] as $stat){
					$stat_id = $this->_get_insert_stat($stat['stat']);
					$stat_value = $stat['value'];
					if($stat_id == $row->stat_id && $stat_value == $row->value){
						$stat_value_match = true;
					}
				}
				$matches_array[$index] = $stat_value_match;
			}
			
			$identical_stats = empty($matches_array) ? false : true;
			foreach($matches_array as $value){
				if(!$value){
					$identical_stats = false;
					break;
				}
			}
			if($identical_stats){
				return true;
			}
		}
		return false;
	}
	
	function _get_insert_slot($slot){
		$query = $this->db->get_where('db_item_slots', array('name'=>$slot));
		$row = $query->row();
		if(!empty($row)){
			return $row->id;
		}
		$this->db->insert('db_item_slots', array('name'=>$slot));
		return $this->db->insert_id();
	}
	
	function _get_insert_type($type){
		$query = $this->db->get_where('db_item_types', array('name'=>$type));
		$row = $query->row();
		if(!empty($row)){
			return $row->id;
		}
		$this->db->insert('db_item_types', array('name'=>$type));
		return $this->db->insert_id();
	}
	
	function _get_insert_stat($stat){
		$query = $this->db->get_where('db_stats', array('name'=>$stat));
		$row = $query->row();
		if(!empty($row)){
			return $row->id;
		}
		$this->db->insert('db_stats', array('name'=>$stat));
		return $this->db->insert_id();
	}
	
	function get_character_id_by_filename($stash_file){
		//Parse name out of file name
		$character_name = preg_replace("/.*\/(.*) - StashLog.*/", "$1", $stash_file);
		//Parse class out of file name
		$class_name = preg_replace("/.*- (.*).log$/", "$1", $stash_file);
		//See if character name exists in database
		$query = $this->db->get_where("db_characters", array("name" => $character_name, "class" => $class_name));
		$row = $query->row();
		//If empty, insert character into database
		if(empty($row)){
			$character = array(
				'name' => $character_name,
				'class' => $class_name
			);
			$this->db->insert('db_characters', $character);
			vardump($character, true);
			$character_id = $this->db->insert_id();
		}else{
			$character_id = $row->id;
		}
		return $character_id;
	}
}
