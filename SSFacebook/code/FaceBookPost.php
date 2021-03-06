<?php
class FacebookPost extends Page
{
	//Note: that the corresponding filename to the path given for $icon will end with -file.gif, 
	//e.g. when you specify news above, the filename will be news-file.gif.
	static $icon = "SSFacebook/img/post";

	static $db = array(
		 'FBUser' => 'Text'
	);
	
	static $has_many = array ();
	
	
		
	function getCMSFields() {
        $fields = parent::getCMSFields();
         
       $fields->addFieldToTab('Root.Content.Facebook', new TextField('FBUser', 'Usuario de Facebook'));
         
        return $fields;
    }
		
		
	function FbData() {
		$config = SiteConfig::current_site_config(); 
 
		
		$facebook = new SSFacebook(
			$config->apiKey,
			$config->secretKey,
			$config->domain,
			$config->accessToken
		);
				
		$datos = $facebook->api("/$this->FBUser/posts");

			
		//print_r($doSet);
		return $datos;
	}
}


class FacebookPost_Controller extends Page_Controller
{
	static $allowed_actions = array ();
	
	public function init()
	{
		
		//Requirements::css(project() . "/css/fb.css");
		Requirements::themedCSS('fb');
		parent::init();
	}

}