<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;

/**
 * FacebookTab component
 */
class FacebookHelperComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
	public function initialize(array $config)
    {        
		if(Configure::read('environment') == 'local')
        {
            $config_iframe = array(
				'FacebookTabURL' => [
									'nl' => 'https://www.facebook.com/Testing-Interactive-414541448603550/app/1075972335850490/',
									'fr' => 'https://www.facebook.com/Testing-Interactive-414541448603550/app/1075972335850490/'
								],
				'RedirectToParent' => false
			);
        }
        else if(Configure::read('environment') == 'preview')
        {
            $config_iframe = array(
				'FacebookTabURL' => [
									'nl' => 'https://www.facebook.com/Testing-Interactive-414541448603550/app/1075972335850490/',
									'fr' => 'https://www.facebook.com/Testing-Interactive-414541448603550/app/1075972335850490/'
								],
				'RedirectToParent' => true
			);
        }
        else if(Configure::read('environment') == 'live')
        {
           $config_iframe = array(
				'FacebookTabURL' => [
									'nl' => 'https://www.facebook.com/Testing-Interactive-414541448603550/app/1075972335850490/',
									'fr' => 'https://www.facebook.com/Testing-Interactive-414541448603550/app/1075972335850490/'
								],
				'RedirectToParent' => true
			);
        }
		$config = array_merge($config_iframe,$config);
		$this->config = empty($config) ? $this->_defaultConfig :$config ; 
		$this->controller = $this->_registry->getController();
		$this->referer = $this->controller->referer();	
		$this->host = $this->remove_port($this->controller->request->host());
		$this->referer_host = !empty($this->get_url_parse($this->referer,'host')) ? $this->get_url_parse($this->referer,'host') : '';
		$this->session = $this->request->session();
		
		//FB Data
		$signed_request = !empty($this->request->data['signed_request']) ? $this->request->data['signed_request'] : '';
		if(empty($signed_request))
		{
			$signed_request =  !empty($this->request->query['signed_request']) ? $this->request->query['signed_request'] : '';
		}
		$is_facebookTab = $this->is_facebookTab($signed_request);
		$parse_signed_request = $this->parse_signed_request($signed_request);
		$this->is_facebookTab = $is_facebookTab;
		$this->signed_request = $signed_request;
		$this->parse_signed_request = $parse_signed_request;
		$app_data = !empty($this->parse_signed_request['app_data']) ? $this->parse_signed_request['app_data'] : '';
		$this->app_data = $this->parseAppData($app_data);
    }
	public function processingAppData()
	{
		
	}
	public function parseAppData($app_data)
	{
		if(!empty($app_data))
		{
			return $this->decode_AppData($app_data);			
		}
		return [];		
	}
	public function checkForRedirect()
    {			
		if($this->config['RedirectToParent'] == true)
		{
			if($this->referer_host == $this->host  || $this->checkFacebookLoadAllow() || $this->checkParentAllow()  || $this->checkExceptionsAllow()) // allow no redirect
			{	
				$this->processingAppData();
				$this->is_facebookTab = true;
			}
			else
			{	
				if($this->controller->device_info == 'Desktop')
				{
					$this->redirecToParent();
				}
				//$this->write_debug('2');	
			}
		}
    }	
	public function is_facebookTab($signed_request) {
		$result = false;
		$signed_request_data = $this->parse_signed_request($signed_request);
	  	if(!empty($signed_request_data) && is_array($signed_request_data))
		{
			$result = true;
		}	
	  	return $result;
	}
	
	public function parse_signed_request($signed_request) {
	  if(empty($signed_request))
	  {
	  	error_log('Bad Signed JSON signature!');
		return null;
	  }
	  
	  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
	
	  $secret = $this->config['appSecret']; // Use your app secret here
	
	  // decode the data
	  $sig = $this->base64_url_decode($encoded_sig);
	  $data = json_decode($this->base64_url_decode($payload), true);
	
	  // confirm the signature
	  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
	  if ($sig !== $expected_sig) {
		error_log('Bad Signed JSON signature!');
		return null;
	  }	
	  return $data;
	}
	private function encode_AppData($array)
	{
		return base64_encode(json_encode($array));
	}
	private function decode_AppData($str)
	{
		return json_decode(base64_decode($str),true);
	}
	
	private function base64_url_decode($input) {
	  return base64_decode(strtr($input, '-_', '+/'));
	}
	private function write_debug($string = '')
    {
		pr($this->config);
		echo '<br>ID : '.$string;
		echo '<br>referer : '.$this->referer;
		echo '<br>host  : '.$this->host;
		echo '<br>referer_host : '.$this->referer_host;
	}
	private function checkFacebookLoadAllow()
    {
		if($this->is_facebookTab)
			return true;
		$domains_fb = array('staticxx.facebook.com');		
		foreach($domains_fb as $key => $fb_domain)
		{
			if($fb_domain == $this->referer_host)
			{
				return true;
			}
		}		
		return false;
	}	
	private function redirecToParent()
    {
		$parent_url = $this->config['FacebookTabURL'][$this->controller->language];
		if(!empty($this->controller->request->query) && count($this->controller->request->query) >0)
		{
			$parent_url = $parent_url.'?app_data='.$this->encode_AppData($this->controller->request->query);
		}		
		return $this->controller->redirect($parent_url);
	}
	private function checkParentAllow()
    {
		foreach($this->config['FacebookTabURL'] as $key => $parentURL)
		{
			$parent_host = $this->get_url_parse($parentURL,'host');
			if($parent_host == $this->referer_host)
			{
				return true;
			}
		}
		return false;
	}
	private function checkExceptionsAllow()
    {
		$HTTP_USER_AGENT = !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		if(!empty($HTTP_USER_AGENT))
		{
			if(strpos($HTTP_USER_AGENT, "facebookexternalhit") !== FALSE) //FB query to get share
			{
				return true;
			}
			else if(strpos($HTTP_USER_AGENT, "Twitterbot") !== FALSE) //Twitter query to get share
			{
				return true;
			}
			
		}
		return false;
	}	
	private function remove_port($host)
    {
		$part = explode(":",$host);
		if(!empty($part[0]))
			return $part[0];
		else
			return $host;
    }
	private function get_url_parse($url,$path = 'host') // $path = scheme, host, port, user, pass, path, query , fragment(anchor)
    {
		$result = '';
		$parse_result = parse_url($url);
		$result =  !empty($parse_result[$path]) ? $parse_result[$path] : '';
		$result = str_replace('www.','',$result);
		return $result;
    }	
}
/* Uagse
Configure::write('FB_appID', '185653771463161');
Configure::write('FB_secret', '377b7f2c96eec7a26649518b4ac3f9ce');

$this->loadComponent('FacebookHelper',array('appID'=>Configure::read('FB_appID'),'appSecret'=>Configure::read('FB_secret')));
pr($this->FacebookHelper->parse_signed_request);
pr($this->FacebookHelper->is_facebookTab);		
//set language by FB locale
$facebook_locale = !empty($this->FacebookHelper->parse_signed_request['user']['locale']) ? $this->FacebookHelper->parse_signed_request['user']['locale'] : '';
if(!empty($facebook_locale))
{
	$this->Languages->setLanguageSite($facebook_locale); 	
}		
$this->FacebookHelper->checkForRedirect();
*/