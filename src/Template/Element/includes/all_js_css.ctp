<?php
	$version  =  $environment == 'live' ? '?v=1.1.1' : '?v='.rand(0,10000000).rand(0,10000000).rand(0,10000000);
?>
<link rel="stylesheet" href="<?php echo $this->request->webroot ?>css/all.css<?php echo $version ?>">
<?php
$buld_for_grunt = false;
$array_lib_js = array(
		"js/lib/jquery-3.3.1.min.js",
		//BE
		"js/lib/jquery.validate.min.js",
	);
$array_app_js = array(
		//BE
		"js/app/cls.Validation.js",
		'js/app/cls.GATracking.js',
		'js/app/cls.MainProcess.js'
	);

if($environment == 'local' || $environment == 'preview' || $environment =='live')
{
//	foreach($array_lib_js as $url_js)
//	{
//		if($buld_for_grunt == false)
//		{
//			$url_js = $this->request->webroot.$url_js.$version;
//			echo '<script src="'.$url_js.'"></script>'."\n";
//		}
//		else
//		{
//			echo "buildSource_Path + '".$url_js."',"."\n";
//		}
//	}
//	foreach($array_app_js as $url_js)
//	{
//		if($buld_for_grunt == false)
//		{
//			$url_js = $this->request->webroot.$url_js.$version;
//			echo '<script src="'.$url_js.'"></script>'."\n";
//		}
//		else
//		{
//			echo "buildSource_Path + '".$url_js."',"."\n";
//		}
//	}
}
else //if($environment == 'live')
{
	?>
	<script src="<?php echo $this->request->webroot ?>js/all_lib.src.js<?php echo $version ?>"></script>
    <script src="<?php echo $this->request->webroot ?>js/all.src.js<?php echo $version ?>"></script>
	<?php
}
?>
