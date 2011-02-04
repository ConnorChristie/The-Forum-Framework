<?php

class site {
	public $title;
	public $scripts = array();
	public function __construct($title,$scripts=null){
		$this->title=$title;
	}
	/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return the $scripts
	 */
	public function getScripts() {
		return $this->scripts;
	}

	/**
	 * @param field_type $scripts
	 */
	public function setScripts($scripts) {
		$this->scripts = $scripts;
	}
}

?>