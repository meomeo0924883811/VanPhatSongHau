<?php	
	use Cake\Filesystem\File;
	$language = isset($data['language']) && $data['language'] != '' ? '_'.$data['language'] : '';
	$email_vars = isset($data['email_vars']) && is_array($data['email_vars']) ? $data['email_vars'] : array();
	$mail_template = isset($data['mail_template']) ? $data['mail_template'] :'';
	
	$template_url = WWW_ROOT.'mailTemplate/'.$mail_template.$language.'.txt';
	if(file_exists($template_url))
	{	
		$file = new File($template_url, true, 0644);
		if($mail_content = $file->read())
		{
			$root_url_images = $this->Url->build('/', true).'mailTemplate/images/';
			$mail_content = str_replace('"images/', '"'.$root_url_images, $mail_content);
			foreach($email_vars as $key=>$value)
			{
				$value = strip_tags($value);
				$mail_content = str_replace('['.$key.']',$value, $mail_content);
			}
			echo $mail_content ;
		}
		else
		{
			echo "Template '".$mail_template."' isn't exist";
		}
	}
	else //  try with strip_tags html
	{
		$template_url = 'mailTemplate/'.$mail_template.$language.'.html';
		if(file_exists($template_url))
		{	
			$file = new File($template_url, true, 0644);
			if($mail_content = $file->read())
			{
				$mail_content = strip_tags($mail_content);
				$root_url_images = $this->Url->build('/', true).'mailTemplate/images/';
				$mail_content = str_replace('"images/', '"'.$root_url_images, $mail_content);
				foreach($email_vars as $key=>$value)
				{
					$value = strip_tags($value);
					$mail_content = str_replace('['.$key.']',$value, $mail_content);
				}
				echo $mail_content ;
			}
			else
			{
				echo "Template '".$mail_template."' isn't exist";
			}
		}
		else
		{
			echo "Template '".$mail_template."' isn't exist";
		}
	}
?>