<?php
class FacebookEvents extends Page
{
	//Note: that the corresponding filename to the path given for $icon will end with -file.gif, 
	//e.g. when you specify news above, the filename will be news-file.gif.
	static $icon = "fb_feed/img/events";

	static $db = array(
		 'FBUser' => 'Text'
	);
	
	static $has_many = array ();
		
		
	function getCMSFields() {
        $fields = parent::getCMSFields();
         
        $fields->addFieldToTab('Root.Content.Facebook', new TextField('FBUser'), 'Usuario de Facebook');
         
        return $fields;
    }
		
		
	function FbData() {
		
		$facebook = new SSFacebook(
			'286837171347215',
			'9ac87256ae1b411e857586a4e24b0f75',
			'demo.montalbo.net',
			"AAAEE4Hu03w8BAIiZB060kMRQKK2O208FGRHncd9PUAXMrwHVqGdksXYYuXHerbwtBFAxG42Tmg0c3KhEMRsh1xKRyxTMZD"
		);
				
		
		$datos = $facebook->api('/149050115180034/events');
			
		//print_r($doSet);
		return $datos;
	}
}


class FacebookEvents_Controller extends Page_Controller
{
	static $allowed_actions = array ();
	
	public function init()
	{
		//Requirements::css(project() . "/css/fb.css");
		Requirements::themedCSS('fb');
		parent::init();
	}

}