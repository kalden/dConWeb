<?php

class Menu_Class
{
	var $label;
	var $link;
	var $is_selected;
	
	function add_link($arg1,$arg2,$arg3) {
		$last = sizeof($this->label);
		$this->label[$last] = $arg1;
		$this->link[$last] = $arg2;
		$this->is_selected[$last] = $arg3;
		return 1;
	}
	
	function list_length() {
		return sizeof($this->label);
	}
}
?>