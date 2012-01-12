<?php
class SSFacebook
{
	private $appID;
	private $secret;
	private $domain;
	private $accessToken;
	
	
	public function __constructor($appid,$secret,$domain,$accessToken)
	{
		
		$this->appID = $appid;
		$this->secret = $secret;
		$this->domain = $domain;
		$this->accessToken = $accessToken;
	}
	
	function api($consulta) {
		
		$facebook = new Facebook(array(
		  'appId'  => '286837171347215',
		  'secret' => '9ac87256ae1b411e857586a4e24b0f75',
		  'cookie' => true,
		  'domain' => 'demo.montalbo.net'
		));
				
		
		$facebook->setAccessToken("AAAEE4Hu03w8BAIuYfFmXD1Ni5SsR1ZBNXIPqlgR8VuaWEt9Pshl3xGPmiTw7Qh3fKRrwWElRROS7aWk9HVlNhLYZB7cLYZD");
		//$datos = $facebook->api('/149050115180034/events');
		//$datos = $facebook->api('/46683382206/events');
		
		try
		{
			$datos = $facebook->api($consulta);
		}
		catch(Exception $e)
		{
			print_r($e);
		}
	
		
		$doSet = $this->fb2SSdata($datos['data']);
		
	
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
