<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use App\Controller\AppController;
use image_load;
use function Sodium\add;
class AjaxController extends AppController {

    public function submitSendMail() {
        $data = $this->request->getData();
        $response = ['status' => 0];
        if (!empty($data)) {
            $this->loadComponent("EmailHelper", []);
            $subject = 'Chào mừng đã đăng ký nhận thông tin định kỳ từ NIVEA!';
            $template = 'confirmation';
            $params["name"] = $data["subscribeName"];
            $guest_email = $data["subscribeEmail"];
            $this->EmailHelper->sendEmail($guest_email, $subject, $template, $params, $this->language);
            $response = ['status' => 1];
        }
        $this->response->body(json_encode($response));
        $this->response->type('json');
        return $this->response;
    }
}
