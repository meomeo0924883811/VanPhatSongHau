<?php
namespace Admin\Controller;

use App\Controller\AppController as BaseController;
use Cake\Event\Event;
use Cake\Routing\Router;

class AppController extends BaseController
{

    public $helpers = ['Admin.General'];//'Admin.JqueryUpload'
    public function initialize()
    {
        $this->viewBuilder()->layout('Admin.admin');
        $this->loadComponent('Flash');
        $this->loadComponent('Csrf');
        $this->response->header(
            array(
                'X-Frame-Options' => 'DENY',
                'X-XSS-Protection'=> 1,
                'Strict-Transport-Security'=>'max-age=15552000; includeSubDomains; preload'
            )
        );
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                //'plugin' => 'Admin'
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index',
                //'plugin' => 'Admin'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                //'plugin' => 'Admin',
                //'home'
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email']
                ]
            ] ,
            //'storage' => 'Session',
            'authError' => 'You can not access that page',
            'authorize' => ['Controller']
        ]);
    }
    //public $logged_in = false;
    public $current_user = null;
    public function beforeFilter(Event $event)
    {
        $this->current_user = $this->Auth->user();
        //$this->set('logged_in', $this->logged_in);
        $this->set('current_user', $this->current_user);

        $menu_items = array(
            /*'home' => array(
                'text' => 'Home',
                'link' => Router::url(['controller' => 'home','action' => 'index']),
                'icon' => 'icon-home'
            ),*/
            'users' => array(
                'text' => 'Users',
                'link' => Router::url(['controller' => 'users', 'action' => 'index']),
                'icon' => '',
                'sub_menu' => array(
                    'index' => array(
                        'text' => 'List users',
                        'link' => Router::url(['controller' => 'users','action' => 'index']),
                        'icon' => '',
                    ),
                    'add' => array(
                        'text' => 'Add new users',
                        'link' => Router::url(['controller' => 'users', 'action' => 'add']),
                        'icon' => '',
                    )
                )
            ),
            'subscribers' => array(
                'text' => 'Subscribers',
                'link' => Router::url(['controller' => 'Subscribers', 'action' => 'index']),
                'icon' => '',
            )
        );
        $this->set('menu_items', $menu_items);
        $menu_active = strtolower($this->request->params['controller']);
        if(!in_array($menu_active, array_keys($menu_items))){
            foreach($menu_items as $key_menu => $menu){
                $sub_menu = !empty($menu_items[$key_menu]['sub_menu']) ? $menu_items[$key_menu]['sub_menu'] : array();
                if(in_array($menu_active, array_keys($sub_menu))){
                    $sub_menu_active = $menu_active;
                    $menu_active = $key_menu;
                    break;
                }
            }
        }
        $this->set('menu_active', $menu_active != '' ? $menu_active : 'index');
        $sub_menu_active = isset($sub_menu_active) ? $sub_menu_active : $this->request->params['action'];
        $this->set('sub_menu_active', $sub_menu_active != '' ? $sub_menu_active : 'index');

        $SessionExprieTime = $this->request->session()->read('Admin.SessionExprieTime');
        if(!empty($SessionExprieTime))
        {
            if($SessionExprieTime <= time())
            {
                if($SessionExprieTime <= time())
                {
                    $controller = $this->request->params['controller'];
                    $action = $this->request->params['action'];
                    $avoid_action = array('validateSessionExprie','sessionLogout','login');
                    if( $controller != 'Users' || ($controller == 'Users' && !in_array($action,$avoid_action)))
                    {
                        $this->Auth->logout();
                    }
                }
            }
        }
        $this->set('SessionExprieIn', $this->createSessionExprie());
        $this->set('webroot_full', Router::url('/', true));

        if(in_array($this->request->params['action'], array('update_order'))){
            $this->eventManager()->off($this->Csrf);
        }
    }
    function createSessionExprie(){
        $controller = $this->request->params['controller'];
        $action = $this->request->params['action'];
        $avoid_action = array('validateSessionExprie','sessionLogout','login');
        if( $controller != 'Users' || ($controller == 'Users' && !in_array($action,$avoid_action)))
        {
            $time = time();
            $SessionExprieTime = strtotime(date('Y-m-d H:i:s') . " + 20 minutes");
            $this->request->session()->write('Admin.SessionExprieTime',$SessionExprieTime);
            $SessionExprieIn = $SessionExprieTime - $time;
            return $SessionExprieIn;
        }
        return '';
    }
    public function isAuthorized($user){
        return true;
    }

}
