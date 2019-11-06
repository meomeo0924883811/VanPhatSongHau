<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Routing\Router;
use App\Controller\AppController;
use Cake\Console\ShellDispatcher;



class FrontendController extends AppController {
	//public $layout = 'frontend';

    public function initialize()
    {
        parent::initialize();
		$this->viewBuilder()->layout('frontend');
        $this->response->disableCache();
		$this->set('webroot_full', Router::url('/', true));


        $BaseURLs = ['images' => Router::url('/')];
        $this->set('BaseURLs', $BaseURLs);
    }

	public function index() {

	}

    public function subscribe() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $name = $data['name'];
            $phone = $data['phone'];
            $response = [
                'status' => 0,
                'message' => 'Check your information!',
            ];
            $this->loadModel('Subscribers');
            $subscriber = $this->Subscribers->find('all')->where(
                [
                    'phone =' => $phone
                ]
            )->first();
            if (empty($subscriber)) {
                $new_subscriber = $this->Subscribers->newEntity();
                $new_subscriber['name'] = $name;
                $new_subscriber['phone'] = $phone;
                if ($this->Subscribers->save($new_subscriber)) {
                    $response = [
                        'status' => 1,
                        'message' => 'Subscriber saved!',
                    ];
                }
                else {
                    $response = [
                        'status' => 2,
                        'message' => 'Save failed!',
                    ];
                }
            }
            $this->response->withType('json');
            $this->response->body(json_encode($response));
            return $this->response;
        }
    }
}
