<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Utility\Security;
use \Firebase\JWT\JWT;

/**
 * EmailHelper component
 */
class EmailHelperComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public function initialize(array $config)
    {
        $this->config = empty($config) ? $this->_defaultConfig :$config;
        $this->controller = $this->_registry->getController();
        $this->viewController = 'Frontend';
        $this->viewAction = 'view_email';

        $this->mailer = new Email();
        $this->mailer->setTransport('smtp');

        $this->FromEmail = Configure::read('SMTP_fromEmail');
        $this->fromEmailName = 'From name';
        $this->replyToEmail = Configure::read('SMTP_fromEmail');
        $this->replyToEmailName = 'Reply name';

        $this->controller = $this->_registry->getController();
        $this->_AuthPrivateKeys .= Security::getSalt();
    }

    public function sendEmail($toEmail, $subject, $template, $email_vars, $language = ''){
        $this->FromEmail = 'thong.hhm0624@gmail.com';
        $this->fromEmailName = 'NIVEA';

        $this->replyToEmail = 'thong.hhm0624@gmail.com';
        $this->replyToEmailName = 'NIVEA';

        $language = !empty($language) ? $language : $this->controller->language;
        $email_vars['template'] = $template;

        if($toEmail != "" && $template != ""){
            //emailFormat text, html or both.
            $this->mailer
                //->template('content', 'template')->emailFormat('html')
                ->template('content', 'template')->emailFormat('both')
                ->subject($subject)
                ->viewVars(['data' => ['language'=>$language,'mail_template'=>$template,'email_vars'=>$email_vars]])
                ->from([$this->FromEmail => $this->fromEmailName] )
                ->replyTo([$this->FromEmail => $this->replyToEmailName] )
                ->to($toEmail);
            if ( $this->mailer->send() )
            {
                $sentMailSatus = 1;
            } else{
                $sentMailSatus = 0;
            }
            return $sentMailSatus;
        }
        else {
            return "Invalid Infomation";
        }
    }

}


/*
	$this->loadComponent("EmailHelper",[]);
	$emailStatus = $this->EmailHelper->sendEmail($toEmail, $subject, $template, $params, $language);
*/