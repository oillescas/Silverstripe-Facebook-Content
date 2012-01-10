<?php
class FacebookPost extends Page
{
	//Note: that the corresponding filename to the path given for $icon will end with -file.gif, 
	//e.g. when you specify news above, the filename will be news-file.gif.
	static $icon = "fb_feed/img/fb";

	static $db = array();
	
	static $has_many = array ();
		
	function FbData() {
		
		$facebook = new Facebook(array(
		  'appId'  => '286837171347215',
		  'secret' => '9ac87256ae1b411e857586a4e24b0f75',
		  'cookie' => true,
		  'domain' => 'demo.montalbo.net'
		));
				
		$facebook->setAccessToken("AAAEE4Hu03w8BAIiZB060kMRQKK2O208FGRHncd9PUAXMrwHVqGdksXYYuXHerbwtBFAxG42Tmg0c3KhEMRsh1xKRyxTMZD");
		//$datos = $facebook->api('/149050115180034/posts');
		$datos = $facebook->api('/oillescas/posts');
		
		
		$doSet = $this->fb2SSdata($datos['data']);
		
		//print_r($doSet);
		return $doSet;
	}
	
	private function fb2SSdata($datos)
	{
		$doSet = new DataObjectSet();

		foreach($datos as $entrada)
		{
			$fbObj = array();
			
			while (list($key, $value) = each($entrada)) {
				
				if(!is_array($value))
				{
					if(substr_count($key,'_time')>0)
					{
						$fbObj[$key] = date("d-m-y h:m", strtotime($value));
					}
					else
					{
						$fbObj[$key] = $value;
					}
				}
				else if(is_array($value) && $key!="story_tags")
				{
					if(is_array($value) && count(array_filter(array_keys($value),'is_string')) == count($value))
					{
						//echo "(01) $key -- $value \n";
						$fbObj[$key] = $this->fbArray2SSdata($value);
					}
					else
					{	
						//echo "(02) $key -- $value \n";
						$fbObj[$key] = $this->fb2SSdata($value);
						
					}
				}
			}

			$doSet->push(new ArrayData($fbObj));
			
			
		}
		 
		return $doSet;
	}
	private function fbArray2SSdata($datos)
	{
		$doSet = new DataObjectSet();
		$fbObj = array();
		while (list($key, $value) = each($datos)) {
			if(!is_array($value))
			{
				if(substr_count($key,'_time')>0)
				{
					$fbObj[$key] = date("d-m-y h:m", strtotime($value));
				}
				else
				{
					$fbObj[$key] = $value;
				}
			}
			else if(is_array($value))
			{
				if(is_array($value) && count(array_filter(array_keys($value),'is_string')) == count($value))
				{
					//echo "(11) $key -- $value \n";
					$fbObj[$key] = $this->fbArray2SSdata($value);
				}
				else
				{
					//echo "(12) $key -- $value \n";
					$fbObj[$key] = $this->fb2SSdata($value);
					
				}
			}
			
		}
		
		if(is_array($fbObj))
		{
			$doSet->push(new ArrayData($fbObj));
		}
		else
		{
			$doSet->push($fbObj);
		}
		return $doSet;
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