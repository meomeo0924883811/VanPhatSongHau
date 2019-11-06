<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Routing\Router;
/**
 * IframeHelper component
 */
class IframeHelperComponent extends Component
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
				'ParentURL' => [
									'nl' => 'http://www.nl.labello.be/campaigns/local/be/neon',
									'fr' => 'http://www.fr.labello.be/campaigns/local/be/neon'
								],
				'RedirectToParent' => false,
				'RedirectToGetParentParams' => false
			);
        }
        else if(Configure::read('environment') == 'preview')
        {
            $config_iframe = array(
				'ParentURL' => [
									'nl' => 'http://www.nl.labello.be/campaigns/local/be/neon',
									'fr' => 'http://www.fr.labello.be/campaigns/local/be/neon'
								],
				'RedirectToParent' => false,
				'RedirectToGetParentParams' => false
			);
        }
        else if(Configure::read('environment') == 'live')
        {
           $config_iframe = array(
				'ParentURL' => [
									'nl' => 'http://www.nl.labello.be/campaigns/local/be/neon',
									'fr' => 'http://www.fr.labello.be/campaigns/local/be/neon'
								],
				'RedirectToParent' => true,
				'RedirectToGetParentParams' => true
			);
        }
		
		$config = array_merge($config_iframe,$config);
		$this->config = empty($config) ? $this->_defaultConfig :$config;
		$this->controller = $this->_registry->getController();
		$this->referer = $this->controller->referer();		
		//$this->referer = 'http://www.nl.labello.be/campaigns/local/be/Test-iFrame?utm1=1&utm2=2&utm4=2';
		$this->host = $this->remove_port($this->controller->request->host());
		$this->referer_host = !empty($this->get_url_parse($this->referer,'host')) ? $this->get_url_parse($this->referer,'host') : '';
		
		//Log::write('debug', json_encode($_SERVER));
    }
	public function checkForRedirect()
    {		
		//$data = ['referer'=>$this->referer,'referer_host'=>$this->referer_host,'host'=>$this->host];
		//Log::write('debug', json_encode($data));
		if($this->config['RedirectToParent'] == true)
		{
			if($this->referer_host == $this->host || $this->checkParentAllow() || $this->checkExceptionsAllow()) // allow no redirect
			{				
				if($this->config['RedirectToGetParentParams'] == true) //redirect to get param iframe
				{	
					$this->redirecToGetParentParams();
				}
			}
			else
			{				
				$this->redirecToParent();
				//$this->write_debug('2');	
			}
		}
    }
	private function write_debug($string = '')
    {
		pr($this->config);
		echo '<br>ID : '.$string;
		echo '<br>referer : '.$this->referer;
		echo '<br>host  : '.$this->host;
		echo '<br>referer_host : '.$this->referer_host;
	}
	private function redirecToGetParentParams()
    {		
		if($this->checkParentAllow())
		{
			$query_params = $this->controller->request->query;
			$parent_query_string = $this->get_url_parse($this->referer,'query');
			$parent_query_params = [];
			parse_str($parent_query_string,$parent_query_params);
			$result = array_diff($parent_query_params,$query_params);	
			$merge_query_param = [];
			if(!empty($result))
			{
				$merge_query_param = array_merge($result,$query_params);				
				//echo Router::url(['controller'=>$_controller,'action'=>$_index,'language'=>$this->controller->language,'?'=>$merge_query_param]);				
				return $this->controller->redirect(['controller'=>'Frontend','action'=>'index','language'=>$this->controller->language,'?'=>$merge_query_param]);				
			}
		}				
	}
	private function redirecToParent()
    {
		$parent_url = $this->config['ParentURL'][$this->controller->language];
		if(!empty($this->controller->request->query) && count($this->controller->request->query) >0)
		{
			$parent_url = $parent_url.'?'.http_build_query($this->controller->request->query);
		}
		
		return $this->controller->redirect($parent_url);
	}
	private function checkParentAllow()
    {
		foreach($this->config['ParentURL'] as $key => $parentURL)
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
	public function get_ParentURL()
    {
		return $this->config['ParentURL'][$this->controller->language];
    }
}
/*Usage
//IframeHelper
$this->loadComponent('IframeHelper',[]);
$this->IframeHelper->checkForRedirect();
*/