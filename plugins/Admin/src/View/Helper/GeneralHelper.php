<?php
namespace Admin\View\Helper;
use Cake\View\Helper;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Utility\Text;

class GeneralHelper extends Helper
{
    public $helpers = array('Html');
    public function facyboxImage($image_url = '')
    {
        if(file_exists($image_url)){
            $thumb_image_url = str_replace(basename($image_url), 'thumbnail/'.basename($image_url), $image_url);
            return $img = '<a class="fancybox" href="'. $this->request->webroot . $image_url. '"><img height="20" src="'.$this->request->webroot . $thumb_image_url.'"/></a>';
        }
        else{
            return $img = '<img height="20" src="'.$this->request->webroot . 'images/no-image.jpg' . '"/>';
        }
    }

    public function _getImageUrl($image_url = "", $type = ""){
        $_UrlWebrootImage = Router::url('/');
        switch ($type) {
            case 'medium':
                $image_url_result = str_replace(basename($image_url), 'medium_'.basename($image_url), $image_url);
                break;
            case 'crop':
                $image_url_result = str_replace(basename($image_url), 'crop_'.basename($image_url), $image_url);
                break;
            default:
                $image_url_result = $image_url;
                break;
        }
        if(!empty($image_url_result) && file_exists($image_url_result)){
            return $_UrlWebrootImage . $image_url_result;
        }
        else{
            return $_UrlWebrootImage . 'images/no-image.jpg';
        }
    }

    public function _compactString($text = "", $length = null){
        if(!empty($text) && $length > 0){
            $text = Text::truncate($text, $length,
                [
                    'ellipsis' => '...',
                    'exact' => false
                ]
            );
        }
        return $text;
    }

    public function _dateTimeFormat($date_time = null, $format = "yyyy-MM-dd HH:mm:ss"){
        if(!empty($date_time)){
            $date_time = new Time($date_time);
            $date_time_format = $date_time->i18nFormat($format);
            return $date_time_format;
        }
        return "";
    }
}
