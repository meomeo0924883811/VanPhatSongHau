<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use App\Controller\AppController;
require_once(ROOT .DS. 'src'.DS. 'Lib' . DS .'image_load.php');
use image_load;



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
        $this->set('home', false);
    }

	public function index() {
        $this->loadModel('Images');
        $this->loadModel('News');
        $images = $this->Images->find('all')->toArray();
        $news = $this->News->find('all')->toArray();
        $this->set('images', $images);
        $this->set('news', $news);
        $this->set('home', true);
	}

    public function news($id = 0) {
        $this->autoRender = false;
        $this->loadModel('News');

        $news_related = $this->News->find('all')->where([
            'id !=' => $id
        ])->order('rand()')->limit(5)->toArray();

        $page_content = $this->News->find('all')->where([
            'id = ' => $id
        ])->first();
        $this->set('page_content', $page_content);
        $this->set('news_related', $news_related);
        $this->render('news');
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
