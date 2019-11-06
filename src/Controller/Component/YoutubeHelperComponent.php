<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;
use Cake\Cache\Cache;

/**
 * YoutubeHelper component
 */
class YoutubeHelperComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $fetchVersion = 'v3';
    protected $videoDetails = [];
    protected $enableSystemCache = true;
	const URL_FETCHDATA     = 'http://www.youtube.com/get_video_info?&video_id=[video_id]&asv=3&el=detailpage&hl=nl_BE';
	const URL_GOOGLEAPI		= 'https://www.googleapis.com/youtube/v3/videos?key=[api_key]&part=snippet&id=[video_id]';
	public function initialize(array $config)
    {
        $this->config = empty($config) ? $this->_defaultConfig :$config;
        $this->fetchVersion = !empty($this->config['fetchVersion']) ? $this->config['fetchVersion'] : 'v1';
    }
	public function setVersion($version){
	    $this->fetchVersion = $version;
    }
    private function setVideoDetails($details){
        $this->videoDetails = !empty($details['videoDetails']) ? $details['videoDetails'] : [];
	    if(!empty($this->videoDetails)){
            $this->videoDetails = array_intersect_key($this->videoDetails, array_flip(['title','lengthSeconds','channelId','thumbnail','viewCount','author']));
        }
    }
    public function get_video_urls($video_id)
    {
		$url_video_info = self::URL_FETCHDATA;
		$url_video_info = str_replace('[video_id]',$video_id,$url_video_info);
	   
		$http = new Client();
		$response = $http->get($url_video_info);
		if($response->isOk())
		{
			$my_video_info = $response->body();
			//echo $my_video_info.'<br><br>';
            parse_str($my_video_info , $details);
            $adaptive_fmts = !empty($details['adaptive_fmts']) ? $details['adaptive_fmts'] : '';
            $url_encoded_fmt_stream_map = !empty($details['url_encoded_fmt_stream_map']) ? $details['url_encoded_fmt_stream_map'] : '';
            $videos_stream_str = !empty($adaptive_fmts) ? $adaptive_fmts : $url_encoded_fmt_stream_map;
			$avail_formats = [];
            $player_response = !empty($details['player_response']) ? $details['player_response'] : '';
            $player_response_arr = json_decode($player_response,true);
            //pr($player_response_arr);
            $this->setVideoDetails($player_response_arr);



			if(isset($videos_stream_str)) {
				/* Now get the url_encoded_fmt_stream_map, and explode on comma */
				$my_formats_array = explode(',',$videos_stream_str);
			} else {
				echo '<p>No encoded format stream found.</p>';
				echo '<p>Here is what we got from YouTube:</p>';
				echo $my_video_info;
			}
			if (count($my_formats_array) == 0) {
				echo '<p>No format stream map found - was the video id correct?</p>';
				exit;
			}
			
			
			$i = 0;
			$ipbits = $ip = $itag = $sig = $quality = $quality_label = '';
			$expire = time(); 
			//pr($my_formats_array);
			foreach($my_formats_array as $format) {
				parse_str($format,$formatData);
                $itag = !empty($formatData['itag']) ? $formatData['itag'] : '';
                $quality = !empty($formatData['quality_label']) ? $formatData['quality_label'] : (!empty($formatData['quality']) ? $formatData['quality'] : '');
                $type = !empty($formatData['type']) ? $formatData['type'] : [];
                $type = explode(';',$type);
                $type = $type[0];
                if(empty($quality) && !empty($formatData['bitrate'])){
                    $quality = 'audio';
                    $type = $type.'_'.$formatData['bitrate'];
                }

                $sig = !empty($formatData['sig']) ? $formatData['sig'] : '';
                $url = !empty($formatData['url']) ? $formatData['url'] : '';
                $expire = !empty($formatData['expire']) ? $formatData['expire'] : time();
                $ipbits = !empty($formatData['ipbits']) ? $formatData['ipbits'] : '';
                $ip = !empty($formatData['ip']) ? $formatData['ip'] : '';

				$avail_formats[$i]['itag'] = $itag;
				$avail_formats[$i]['quality'] = $quality;
				$avail_formats[$i]['type'] = $type;
				$avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
				parse_str(urldecode($url));
				$avail_formats[$i]['expires'] = date("G:i:s T", $expire);
				$avail_formats[$i]['ipbits'] = $ipbits;
				$avail_formats[$i]['ip'] = $ip;
				$i++;
			}
			return $avail_formats;
		}
		else
		{
			return [];
		}
    }
    public function get_video_urls_v2($video_id)
    {
        $url_video_info = self::URL_FETCHDATA;
        $url_video_info = str_replace('[video_id]',$video_id,$url_video_info);

        $http = new Client();
        $response = $http->get($url_video_info);
        if($response->isOk())
        {
            $my_video_info = $response->body();
            //echo $my_video_info.'<br><br>';
            parse_str($my_video_info , $details);

            $avail_formats = [];
            $player_response = !empty($details['player_response']) ? $details['player_response'] : '';
            $player_response_arr = json_decode($player_response,true);
            $this->setVideoDetails($player_response_arr);
            //pr($player_response_arr);
            $streamingDataFormats = !empty($player_response_arr['streamingData']['adaptiveFormats']) ? $player_response_arr['streamingData']['adaptiveFormats'] : '';
            if(empty($streamingDataFormats)){
                $streamingDataFormats = !empty($player_response_arr['streamingData']['formats']) ? $player_response_arr['streamingData']['formats'] : '';
            }

            if(isset($streamingDataFormats) && is_array($streamingDataFormats)) {
                $my_formats_array = $streamingDataFormats;
            } else {
                echo '<p>No encoded format stream found.</p>';
                echo '<p>Here is what we got from YouTube:</p>';
                echo $my_video_info;
            }
            if (empty($my_formats_array)) {
                echo '<p>No format stream map found - was the video id correct?</p>';
                exit;
            }


            $i = 0;
            $ipbits = $ip = $itag = $sig = $quality = $quality_label = '';
            $expire = time();
            //pr($my_formats_array);
            foreach($my_formats_array as $format) {
                $formatData = $format;
                $itag = !empty($formatData['itag']) ? $formatData['itag'] : '';
                $quality = !empty($formatData['qualityLabel']) ? $formatData['qualityLabel'] : '';
                $type = !empty($formatData['mimeType']) ? $formatData['mimeType'] : [];
                $type = explode(';',$type);
                $type = $type[0];
                if(empty($quality) && !empty($formatData['audioQuality'])){
                    $quality = 'audio';
                    $type = $type.'_'.$formatData['bitrate'];
                }

                $sig = !empty($formatData['sig']) ? $formatData['sig'] : '';
                $url = !empty($formatData['url']) ? $formatData['url'] : '';
                $expire = !empty($formatData['expire']) ? $formatData['expire'] : time();
                $ipbits = !empty($formatData['ipbits']) ? $formatData['ipbits'] : '';
                $ip = !empty($formatData['ip']) ? $formatData['ip'] : '';

                $avail_formats[$i]['itag'] = $itag;
                $avail_formats[$i]['quality'] = $quality;
                $avail_formats[$i]['type'] = $type;
                $avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
                parse_str(urldecode($url));
                $avail_formats[$i]['expires'] = date("G:i:s T", $expire);
                $avail_formats[$i]['ipbits'] = $ipbits;
                $avail_formats[$i]['ip'] = $ip;
                $i++;
            }
            return $avail_formats;
        }
        else
        {
            return [];
        }
    }
    public function get_video_urls_v3($video_id)
    {
        $url_video_info = self::URL_FETCHDATA;
        $url_video_info = str_replace('[video_id]',$video_id,$url_video_info);

        $http = new Client();
        $response = $http->get($url_video_info);
        if($response->isOk())
        {
            $my_video_info = $response->body();
            //echo $my_video_info.'<br><br>';
            parse_str($my_video_info , $details);
            $adaptive_fmts = !empty($details['adaptive_fmts']) ? $details['adaptive_fmts'] : '';
            $url_encoded_fmt_stream_map = !empty($details['url_encoded_fmt_stream_map']) ? $details['url_encoded_fmt_stream_map'] : '';
            $videos_stream_str = !empty($adaptive_fmts) ? $adaptive_fmts : $url_encoded_fmt_stream_map;
            $avail_formats = [];
            $player_response = !empty($details['player_response']) ? $details['player_response'] : '';
            $player_response_arr = json_decode($player_response,true);
            //pr($player_response_arr);
            $this->setVideoDetails($player_response_arr);

            if(isset($videos_stream_str)) {
                /* Now get the url_encoded_fmt_stream_map, and explode on comma */
                $my_formats_array = explode(',',$videos_stream_str);
            } else {
                /*echo '<p>No encoded format stream found.</p>';
                echo '<p>Here is what we got from YouTube:</p>';
                echo $my_video_info;*/
            }
            if (!empty($my_formats_array)) {
                $i = 0;
                $ipbits = $ip = $itag = $sig = $quality = $quality_label = '';
                $expire = time();
                //pr($my_formats_array);
                foreach($my_formats_array as $format) {
                    parse_str($format,$formatData);
                    $itag = !empty($formatData['itag']) ? $formatData['itag'] : '';
                    $quality = !empty($formatData['quality_label']) ? $formatData['quality_label'] : (!empty($formatData['quality']) ? $formatData['quality'] : '');
                    $type = !empty($formatData['type']) ? $formatData['type'] : '';
                    $type = explode(';',$type);
                    $type = $type[0];
                    if(empty($quality) && !empty($formatData['bitrate'])){
                        $quality = 'audio';
                        $type = $type.'_'.$formatData['bitrate'];
                    }

                    $sig = !empty($formatData['sig']) ? $formatData['sig'] : '';
                    $url = !empty($formatData['url']) ? $formatData['url'] : '';
                    $expire = !empty($formatData['expire']) ? $formatData['expire'] : time();
                    $ipbits = !empty($formatData['ipbits']) ? $formatData['ipbits'] : '';
                    $ip = !empty($formatData['ip']) ? $formatData['ip'] : '';

                    $avail_formats[$i]['itag'] = $itag;
                    $avail_formats[$i]['quality'] = $quality;
                    $avail_formats[$i]['type'] = $type;
                    $avail_formats[$i]['url'] = urldecode($url) . '&signature=' . $sig;
                    parse_str(urldecode($url));
                    $avail_formats[$i]['expires'] = date("G:i:s T", $expire);
                    $avail_formats[$i]['ipbits'] = $ipbits;
                    $avail_formats[$i]['ip'] = $ip;
                    $i++;
                }
            }
            else {
                echo '<p>No format stream map found - was the video id correct?</p>';
                exit;
            }
            return $avail_formats;
        }
        else
        {
            return [];
        }
    }
	public function get_video_urls_formated($video_id,$filter_quality = '',$filter_type='')//quality : 1080p,720p,480p,hd720,medium,small    type: video/mp4 video/webm  video/3gpp
    {
		$result = [];
		if($this->enableSystemCache == true){
            $resultCache = Cache::read('youtube_videos_'.$video_id,'DataCaches_YTVideo');
        }
        if(empty($resultCache)){
            if($this->fetchVersion == 'v1'){
                $format_urls = $this->get_video_urls($video_id);
            }
            elseif($this->fetchVersion == 'v2'){
                $format_urls = $this->get_video_urls_v2($video_id);
            }
            elseif($this->fetchVersion == 'v3'){
                $format_urls = $this->get_video_urls_v3($video_id);
            }
            $result['videoDetails'] = $this->videoDetails;
            if(!empty($format_urls) && is_array($format_urls))
            {

                foreach($format_urls as $url_OBJ)
                {
                    $video_quality = $url_OBJ['quality'];
                    $video_type  = $url_OBJ['type'];
                    $type = str_replace('video/','',$video_type);
                    $video_url = $url_OBJ['url'];
                    if(!empty($filter_quality))
                    {
                        if($filter_quality != $video_quality)
                        {
                            continue;
                        }

                    }
                    if(!empty($filter_type))
                    {
                        if($filter_type != $video_type)
                        {
                            continue;
                        }

                    }

                    $result[$video_quality][$type] = $this->replaceGoogleCacheDomain($video_url);
                }
            }
            if($this->enableSystemCache == true){
                Cache::write('youtube_videos_'.$video_id, $result, 'DataCaches_YTVideo');
            }
        }
        else {
            $result = $resultCache;
        }
		return $result;

	}

	public function get_video_image($video_url = ''){
		$api_key = $this->config['api_key'];
		$url_video_info = self::URL_GOOGLEAPI;
		$video_id = $this->get_youtube_id($video_url);
		$url_video_info = str_replace('[video_id]',$video_id,$url_video_info);
		$url_video_info = str_replace('[api_key]',$api_key,$url_video_info);

		$http = new Client();
		$response = $http->get($url_video_info);
		$video_image = '';
		if($response->isOk())
		{
			$my_video_info = $response->body();
			parse_str($my_video_info);
			$arr_my_video_info = json_decode($my_video_info, true);
			if(!empty($arr_my_video_info['items']) && isset($arr_my_video_info['items'][0]['snippet']['thumbnails'])){
				$thumbnails = $arr_my_video_info['items'][0]['snippet']['thumbnails'];
				foreach($thumbnails as $key => $value){
					$video_image = $value['url'];
					if($key == 'standard') break;
				}
			}

		}
		return $video_image;
	}
	//pass google global cache
    public function replaceGoogleCacheDomain($url)
    {
        $cachehost = parse_url($url,PHP_URL_HOST);
        $result = str_replace($cachehost,'redirector.googlevideo.com',$url);
        return $result;
    }
	public function get_youtube_id($url)
	{
	    if(strlen($url) <= 15){
            return $url;
        }
		preg_match_all("#(?<=v=|v\/|vi=|vi\/|youtu.be\/)[a-zA-Z0-9_-]{11}#", $url, $matches);
		//pr($matches);
		return !empty($matches[0][0]) ? $matches[0][0] : '';
	}
}
/* Usage
enable Cache :
'DataCaches_YTVideo' => [
            'className' => $use_memcache ? 'Cake\Cache\Engine\MemcachedEngine' : 'File',
            'prefix' => 'YTVideo_',
            'path' => CACHE . 'DatadCaches/',
            'duration' => '+1 hours',
        ],

$this->loadComponent('YoutubeHelper',['fetchVersion'=>'v2','api_key'=>'']);
$this->YoutubeHelper->setVersion('v3');
$youtube_id = "Vnt7MB9KGCk";
$url_play_video = $this->YoutubeHelper->get_video_urls_formated($youtube_id,''); //medium		
*/
