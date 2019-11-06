<?php
namespace Admin\View\Helper;

use Cake\View\View;
use Cake\View\Helper;
use Cake\Event\Event;
use Cake\View\Helper\FormHelper;

class JqueryUploadHelper extends Helper {
/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'Html', 'Form'
	);
    
    public $upload_temp = 'files/uploads/temp/';
    public $upload_server = 'plugins/jQueryFileUpload/server/php/';


/**
 * Default values
 *
 * @var array
 */
	protected $_defaults = array(
		'script' => array(
            '/plugins/jQueryFileUpload/js/vendor/jquery.ui.widget.js',
            '/plugins/jQueryFileUpload/js/jquery.fileupload.js',
            '/admin/js/cls.JqueryUpload.js',
        ),
		'loadScript' => true,
        'css' => array(
            '/plugins/jQueryFileUpload/css/jquery.fileupload.css',
            '/plugins/jQueryFileUpload/css/custom.css'
        ),
        'loadCss' => true
	);

/**
 * Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
    public function __construct(View $view, $config = [])
    {
        parent::__construct($view, $config);
        $this->config = array_merge($this->_defaults, $config);
    }

    public function upload($name = null, $label = null, $url = null, $multiple = null, $max_size = null) {
        $multiple = $multiple == 'multiple' ? $multiple : "";
        $image = "";
        $data_submit = $this->Form->hidden($name, ['data-type' => 'result']);
        if(is_array($url)){
            foreach($url as $value){
                $link_img = $this->request->webroot . $value;
                $url_img = str_replace('/thumbnail', '', $value);
                $image .= '<p><a class="btn btn-danger image_delete" wrapper_upload="'.$name.'" data-type="DELETE" data-url="'.$url_img.'" href="javascript:void(0)">
                <i class="glyphicon glyphicon-trash"></i></a>
                <img src="'.$link_img.'"></p>';
                $image .= '<input type="hidden" name="multi_'.$name.'[]" value="'.$url_img.'"/>';
            }
            $data_submit = $this->Form->hidden($name, ['data-type' => 'result']);
        }
        elseif(is_string($url) and $url != "")
        {
            $link_img = $this->request->webroot . $url;
            $url_img = str_replace('/thumbnail', '', $url);
            $image = '<p><a class="btn btn-danger image_delete" wrapper_upload="'.$name.'" data-type="DELETE" data-url="'.$url_img.'" href="javascript:void(0)">
            <i class="glyphicon glyphicon-trash"></i></a>
            <img src="'.$link_img.'"></p>';
            $data_submit = $this->Form->hidden($name, ['value' => $url, 'data-type' => 'result']);
        }

        $html = '
        <div class="wrapper_upload_'.$name.'">
            <div id="upload_files_'.$name.'" class="upload_files">'.$image.'</div>
            <br/>
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>'.$label.'</span>
                <input id="'.$name.'" type="file" name="files[]" '.$multiple.'>
                '.$data_submit.'
            </span>
            <br/><br/>
            <div id="progress" class="progress" style="display: none;">
                <div class="progress-bar progress-bar-success">&nbsp;</div>
            </div>
        </div>
        <script>
            $( document ).ready(function() {
                jQueryUpload.upload_init("'.$name.'", "'.$multiple.'", "'.$max_size.'");
            });
        </script>
        ';
        return $html;
    }




    /**
 * beforeRender callback
 * 
 * @param string $viewFile The view file that is going to be rendered
 * 
 * @return void
 */
	public function beforeRender(Event $event, $viewFile) {
        //parent::beforeRender($event);
		if ($this->config['loadScript'] === true) {
            if(is_array($this->config['script'])){
                foreach($this->config['script'] as $script){
                    echo $this->Html->script($script, ['block' => true]);
                }
            }
            else{
                echo $this->Html->script($this->config['script'], ['block' => true]);
            }
            $this->Html->scriptBlock('
                var upload_server = "'.$this->request->webroot . $this->upload_server.'";
                var upload_temp = "'.$this->upload_temp.'";',
                ['block' => true]);
        }
        if ($this->config['loadCss'] === true) {
            if(is_array($this->config['css'])){
                foreach($this->config['css'] as $css){
                    echo $this->Html->css($css, ['block' => true]);
                }
            }
            else{
                echo $this->Html->css($this->config['css'], ['block' => true]);
            }
		}
	}
}
/*
Usage
Add it before end of form

Add into layout to load script
    echo $this->fetch('script');
Method 1 : Load in controller
	$this->helpers = array('JqueryUpload');
Method 2	: Implement in html view
	echo $this->JqueryUpload->upload('name', 'label', 'url_image', 'multiple', 'max_size');
*/