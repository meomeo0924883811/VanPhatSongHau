<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Network\Response;
 use Cake\Filesystem\Folder;
 use Cake\Filesystem\File;
use Cake\Network\Email\Email;

use Cake\Utility\Security;
use \Firebase\JWT\JWT;

class TemplateCodeController extends AppController {
	public $layout = 'frontend';	
	public $upload_dir = "files/uploads/wwf/";
    public function initialize()
    {
        parent::initialize();
		$this->response->disableCache();
		
	}
	
	public function index() {
		echo 'Link :  <a href="'.Router::url(['language' => $this->language, 'controller' => 'TemplateCode', 'action' => 'sendMail'], false).'">Demo Send Mail</a>';
		echo "<br>";
        $this->response->body('body');
        $this->response->type('html');
        return $this->response;
		//return  $this->response(['body' =>'<br>', 'type' => 'html']);
		//return new CakeResponse(array('body' => json_encode(array('status' => '-1')), 'type' => 'json'));
	}
	
	//for Email[Start]
	public function view_email_old($mail_template='',$name=''){
		$this->layout = 'ajax';
		$data = array('language'=>$this->language,'mail_template'=>$mail_template,'email_vars'=>array('view_link'=>'#','name'=>$name));
		$this->set('data', $data);
    	$this->render('/Emails/html/content');
    }
	public function view_email(){
        $this->viewBuilder()->setLayout('ajax');
        $email_vars_encryp = !empty($this->request->getQuery("email_vars_encryp")) ? $this->request->getQuery("email_vars_encryp") : [];
        $email_vars = [];
        if(!empty($email_vars_encryp)){
            try {
                $email_vars = JWT::decode($email_vars_encryp, $this->_AuthPrivateKeys, array('HS256'));
                $email_vars = json_decode(json_encode($email_vars),true);
            } catch (\Exception $e) { // Also tried JwtException
                $email_vars = [];
            }
        }
        else{
            $email_vars = $this->request->getQuery();
        }

        if(!empty($email_vars)){
            $mail_template = $email_vars['template'];
            $email_vars['view_link'] = '#';
            $data = array('language'=>$this->language,'mail_template'=>$mail_template,'email_vars'=>$email_vars);
            $this->set('data', $data);
        }
        return $this->render('/Email/html/content');

    }
	public function sendMail() {
        $mailer = new Email();
        $mailer->transport('smtp');
		$email_to = 'xuan@bliss-interactive.com';
		
		$replyToEmail = "xuan@bliss-interactive.com";
		$replyToEmailName = 'Info';
		$fromEmail = "noreply@bliss-interactive.net";		
		$fromEmailName = "Xuan";
		$emailSubject = "Demo mail";
		//$view_link = Router::url('/', true);
		$params_name = 'XuanNguyen'; 
		$view_link = Router::url(['language' => $this->language, 'controller' => 'frontend', 'action' => 'view_email', 'confirmation',$params_name], true);
		$sentMailSatus = array();
		
		if(!empty($email_to))
		{
			//emailFormat text, html or both.
			$mailer->template('content', 'template')->emailFormat('html')
			//$mailer->template('content', 'template')->emailFormat('both')
				->subject($emailSubject)
				->viewVars(['data' => ['language'=>$this->language,'mail_template'=>'confirmation','email_vars'=>['view_link'=>$view_link,'name'=>$params_name]]])
				->from([$fromEmail => $fromEmailName] )->replyTo([$replyToEmail => $replyToEmailName])->to($email_to);
			if ( $mailer->send() )
			{
				$sentMailSatus = 1;
			}else{
				$sentMailSatus = 0;
			}
		}
		pr($sentMailSatus);
		exit();
	}
	//for Email[End]
	
}
