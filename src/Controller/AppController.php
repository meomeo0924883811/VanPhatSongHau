<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\I18n\I18n;
use Cake\Routing\Router;
use Jenssegers\Agent\Agent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->response->header(
            array(
                'X-Frame-Options' => 'DENY',
                'X-XSS-Protection'=> 1,
                'Strict-Transport-Security'=>'max-age=15552000; preload'
            )
        );

        // set language
        $this->loadComponent('Languages');
        $this->Languages->setLanguageSite();

        // Detect device
        $agent = new Agent();
        $this->client_device = 'others';
        if($agent->isDesktop()){
            $this->client_device = 'Desktop';
        }else if($agent->isTablet()){
            $this->client_device = 'Tablet';
        }else{
            $this->client_device = 'Mobile';
        }
        $this->client_device_name = $agent->device();
        $this->client_browser = $agent->browser();
        $this->client_browser_version = $agent->version($this->client_browser);
        $this->client_os = $agent->platform();
        $this->client_os_version = $agent->version($this->client_os);

        $agentInfo = [
            'client_device' => $this->client_device,
            'client_device_name' => $this->client_device_name,
            'client_browser' => $this->client_browser,
            'client_browser_version' => $this->client_browser_version,
            'client_os' => str_replace(" ", "_", $this->client_os),
            'client_os_version' => $this->client_os_version,
        ];
        $this->set('agentInfo', $agentInfo);
        $this->set('environment', Configure::read('environment'));

        // GTM account
        $gtm_account = Configure::read('gtm_account');
        $this->set('gtm_account', !empty($gtm_account[$this->language]) ? $gtm_account[$this->language] : '');

        $app_settings = Configure::read('app_settings');
        $this->set('app_settings', $app_settings);

        //Sharing Data
        //$webroot = Router::url(['controller' => 'Frontend', 'action' => 'index','_ssl'=>true], true).'/';
        $webroot = Router::url(['controller' => 'Frontend', 'action' => 'index'], true).'/';
        $share_message= array(
            'site_name' => array(
                'en' => '',
                'vi' => "NIVEA VN",
            ),
            'description' => array(
                'en' => '',
                'vi' => "Chào mừng đến với NIVEA",
            ),
            'title' => array(
                'en' => '',
                'vi' => "NIVEA VN",
            ),
            'image' => array(
                'en' => '',
                'vi' => '',
            ),
            'image_twitter' => array(
                'en' => '',
                'vi' => '',
            ),
            'description_twitter' => array(
                'en' => '',
                'vi' => "Chào mừng đến với NIVEA"
            ),
            'description_facebook' => array(
                'en' => '',
                'vi' => "Chào mừng đến với NIVEA"
            ),
            'url' => array(
                'en' => '',
                'vi' =>  Router::url(['controller' => 'Frontend', 'action' => 'index','_ssl'=>true,'language'=>'vi'], true),
            )
        );
        $this->share_message = $share_message;
        $this->set('share_message',$this->share_message);

        /*$this->loadComponent('Cookie');
        $this->Cookie->config([
            'expires' => '+365 days',
            'encryption' => 'aes',
            'key' => 'BLISS\BLISS_HBPTOJECT_05102016'
            //'httpOnly' => true
        ]);
        $this->Cookie->config('path', '/');
        $this->Cookie->configKey('Name'); */
    }
    protected function url($options, $full = true) {
        if (!Configure::check('isLanguageByDomain')) {
            $options['language'] = $this->language;
        }
        return Router::url($options, $full);
    }
}
