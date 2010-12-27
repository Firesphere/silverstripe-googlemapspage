<?php

class ContactPage extends Page {
}

class ContactPage_Controller extends Page_Controller {
	
	function init(){
		parent::init();
		$this->js();
	}
	
}