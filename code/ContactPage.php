<?php

class ContactPage extends Page {
	static $description = 'A contact page with Google Maps';
}

class ContactPage_Controller extends Page_Controller {
	
	function init(){
		parent::init();
		$this->js();
	}
	
}