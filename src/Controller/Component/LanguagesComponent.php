<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\I18n\I18n;
/**
 * Languages component
 */
class LanguagesComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
	public function initialize(array $config)
    {
        //detect language follow domain
        $domains_array = array  (
            'example.be' => array('nl_BE'),
            'example.fr' => array('fr_BE'),
            'example.en' => array('en_US')
        );
        $domain_lang_name = $this->request->host();
        $domain_lang_name = str_replace('www.','',$domain_lang_name);
        $domain_lang_name = explode(':',$domain_lang_name);
        $domain_lang_name = $domain_lang_name[0];
        if(array_key_exists($domain_lang_name,$domains_array))
        {
            $filer_locale = $domains_array[$domain_lang_name];
            $languageList  = Configure::read('Config.languageList');
            $languageList_temp = array();
            foreach($languageList as $key => $value)
            {
                if(in_array($key,$filer_locale))
                    $languageList_temp[$key] = $value;
            }
            Configure::write('Config.languageList',$languageList_temp);
        }

        $this->controller = $this->_registry->getController();
		$this->default_locale = ini_get('intl.default_locale');
		$this->valid_languages = Configure::read('Config.languageList');
		$this->request_params_language = !empty($this->request->params['language']) ? $this->request->params['language'] : '';
		if($this->_checkValid_Language($this->request_params_language))
		{
			$user_locale  = $this->_get_locale_from_langCode($this->request_params_language);
			I18n::locale($user_locale);
		}
		else
		{
			$this->request_params_language = '';
			if(!empty(Configure::read('Config.defaultLanguage')))
			{
				$user_locale = Configure::read('Config.defaultLanguage');
				I18n::locale($user_locale);
			}		
		}
		$this->user_locale = '';
		$this->language = '';
    }
	public function setLanguageSite($setLocale = '')
    {    
		if(!empty($setLocale))
		{
			$user_locale = $this->_correct_locale($setLocale);
			if(!empty($user_locale))
			{
				I18n::locale($user_locale);
			}
		}
		$this->user_locale = ini_get('intl.default_locale');		
		$this->user_locale = $this->_correct_locale($this->user_locale);		
		if(empty($this->user_locale) || empty($this->valid_languages[$this->user_locale]))
		{
			$user_locale = key($this->valid_languages); // set df language avaiable
			$this->user_locale = $user_locale;	
			I18n::locale($user_locale);						
		}
		
		$this->controller->default_locale = $this->default_locale;
		$this->controller->set('default_locale', $this->default_locale);  
		
		$this->controller->user_locale =$this->user_locale;
		$this->controller->set('user_locale', $this->user_locale); 
		
		$this->language = substr($this->user_locale,0,2);
		$this->controller->language = $this->language;		
		$this->controller->set('language', $this->language);

		$request_params_language = !empty($this->request->params['language']) ? $this->request->params['language'] : '';
        $languageList  = Configure::read('Config.languageList');
        if(count($languageList) == 1){
            if($this->language != $request_params_language && $request_params_language != ''){ // !empty($this->request_params_language) ||
                $controller =  $this->controller->request->getParam('controller');
                $action =  $this->controller->request->getParam('action');
                return $this->controller->redirect(
                    ['controller' => $controller, 'action' => $action]
                );
            }
        }
        else if(count($languageList) > 1){
            if(empty($request_params_language) || $this->language != $request_params_language){
                $controller =  $this->controller->request->getParam('controller');
                $action =  $this->controller->request->getParam('action');
                return $this->controller->redirect(
                    ['controller' => $controller, 'action' => $action,'language'=>$this->language]
                );
            }
        }
    }
	private function _checkValid_Language($check_lang)
    {        
		$result_check = $this->_get_locale_from_langCode($check_lang);
		if(!empty($result_check))
		{
			return true;
		}
		else
			return false;
    }
	private function _get_locale_from_langCode($langCode)
	{
		$result = '';
		if(!empty($langCode))
		{
			foreach ($this->valid_languages as $locale => $language) {
				if ($language['code'] == $langCode ) {
					return $locale;
					break;
				}
			}
		}
		return $result;
	}
	private function _correct_locale($locale)
	{	
		$result = '';
		if(!empty($locale))
		{			
			$locale_arr = explode('_',$locale);
			$locale_lang = $locale_arr[0];
			foreach ($this->valid_languages as $locale => $language) {
				if ($language['code'] == $locale_lang ) {
					$result =  $locale;
					I18n::locale($result);	
					break;
				}
			}		
		}
		return $result;
	}
	
}
