<form method="post" action="">
	<input style="width: 50%" type="text" name="folder_path" value="<?php echo !empty($_POST['folder_path']) ? $_POST['folder_path'] : '' ?>">
	<input type="submit" value="submit">
</form>
<?php 
	if(!empty($_POST)){
		$folder_path = $_POST['folder_path'];
		
		chmod_r($folder_path);
		exit('DONE');
	}
	
	function chmod_r($path) {
		$dir = new DirectoryIterator($path);
		foreach ($dir as $item) {
			echo $item->getPathname().'<br/>';
			chmod($item->getPathname(), 0777);
			if ($item->isDir() && !$item->isDot()) {
				chmod_r($item->getPathname());
			}
		}
	}
?>