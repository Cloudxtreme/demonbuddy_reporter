<?php

class Report extends CI_Controller {

	function Report()
	{
		parent::__construct();		
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}
	
	function index()
	{
		$data = array();
		$data['title'] = "";
		
		$stash_paths = $this->config->item('stash_paths');
		foreach( $stash_paths as $path){
			$this->_parse_stash_file($path);		
		}
		
		$items = $this->demonbuddy_model->load_todays_items();
		$data['item_count'] = count($items);
		$last_item_id = 0;
		$html = "";
		if(!empty($items)){
			$last_item_id = $items[0]->item_id;
			foreach($items as $x => $item){
				$html .= 	'<div class="genericContainer">';
				$html .= 		'<div class="item">';
				$html .=			'<div class="name">';
				$html .=				'<span class="' . ($item->legendary ? 'legendary' : 'rare') . '">';
				if($item->legendary){
					$html .=				'<a href="http://us.battle.net/d3/en/item/' . $item->url_name . '" target="_blank">';
				}
				$html .=						$item->item_name;
				if($item->legendary){
					$html .=				'</a>';
				}
				$html .=                 '</span>';
				$html .=			'</div>';
				$html .= 			'<div class="stats">';
				foreach($item->stats as $stat){
					$html .= 			'<div class="stat">' . $stat->stat_name . ": " . $stat->value . '</div>';
				}
				$html .=			'</div>';
				$html .= 			'<div class="clearFix"></div>';
				$html .= 			'<div class="other">';
				$html .=				'<div class="slot">Found By: <span style="color:' . $item->color . '">' . $item->character_name . ' (' . $item->class . ')</span></div>';
				$html .=				'<div class="slot">Slot: ' . $item->slot_name . '</div>';
				$html .=				'<div class="type">Type: ' . $item->type_name . '</div>';
				$html .=	 			'<div class="score">Score: ' . $item->score . '</div>';
				$html .= 				'<div>Found: ' . $item->date_added . '</div>';
				$html .=			'</div>';
				$html .=		'</div>';
				$html .=		'<div class="clearFix"></div>';
				$html .=	'</div>';
			} 
		}
		$data['last_item_id'] = $last_item_id;
		$data['item_html'] = $html;
		$data['last_item_found'] = $this->demonbuddy_model->get_last_item_found_epoch();
		$this->template->write_view('content', 'homepage/content', $data, TRUE);
		$this->template->render();
	}
	
	function ajax_get_items(){
		$last_id = $this->uri->rsegment(3);
		$data = array();
		
		$stash_paths = $this->config->item('stash_paths');
		foreach( $stash_paths as $path){
			$this->_parse_stash_file($path);		
		}
		//Get messages for this current users session (since midnight and not in session array of id's)
		echo json_encode($this->demonbuddy_model->load_items_after_id($last_id));
	}
		
	function _parse_stash_file($stash_file) {
		$lock_file = $stash_file . ".LCK";
		
		$character = $this->demonbuddy_model->get_character_id_by_filename($stash_file);
		
		$items = array();
		//File change detected
		
		//Check to see if there is a lock file
		if(file_exists($lock_file)){
			//If Lock file, return
			return;
		}
		
		//No Lock File
		//Create lock file
		$fh = fopen($lock_file, 'w');
		fclose($fh);
		
		//Begin parsing...	
		if(!file_exists($stash_file)){		
			return;
		}
		$lines = file($stash_file);
		$skip = false;
		foreach ($lines as $x => $line){
			//Check to see to skip this iteration if required
			if($skip){
				//unset skip
				$skip = false;
				//skip this iteration
				continue;
			}
			
			//Clean up line from file
			$line = trim($line);
			//Skip these following exceptions
			if($line == "====================") continue;
			if(empty($line)) continue;
			if(preg_match("/^\d\d*/", $line)){
				continue;
			}
			
			$item_line1 = explode('.', $line);
			$tmp = explode('-', $item_line1[0]);
			$item_slot = trim($tmp[0]);
			
			$item_type = trim(preg_replace("/'(.*)'$/", '',trim($tmp[1])));
			
			$quote_index = strpos($tmp[1], "'") + 1;
			$length = strlen($tmp[1]);
			$remainder_length = $length - $quote_index - 1;
			$item_name = substr($tmp[1], $quote_index, $remainder_length);
			
			$tmp =  explode('=', $item_line1[1]);
			$item_score = trim($tmp[1]);
			
			$legendary = false;
			if(preg_match("/ \{legendary item\}$/", $item_score)){
				$item_score = preg_replace("/ \{legendary item\}$/", "", $item_score);
				$legendary = true;
			}
			
			$item_line2 = explode('.', $lines[$x+1]);
			
			$item_stat_and_values = array();
			foreach($item_line2 as $item2){
				$item_stat_and_value = explode('=', $item2);
				
				$item_stat_and_values[] = array( 
					'stat' => trim($item_stat_and_value[0]),
					'value' => trim($item_stat_and_value[1])
				);
				//vardump($item_stat_and_value);
			}
			
			$item = array(
				'character' => $character, 
				'slot' => $item_slot,
				'type' => $item_type,
				'name' => $item_name,
				'legendary' => $legendary,
				'score' => $item_score,
				'stats' => $item_stat_and_values
			);
			$items[] = $item;
			$skip = true;
		}
				
		//Enter stash message into database
		if(!empty($items)){
			$this->demonbuddy_model->add_items($items);
			$fh = fopen($stash_file, 'w');
			fclose($fh);
		}
		//Remove lock file
		unlink($lock_file);
	}
	
	function parse_dev(){
		$this->_parse_stash_file($this->config->item('binlagin_stash_path'));
	}
	
}

/* End of file report.php */
/* Location: ./system/application/controllers/welcome.php */