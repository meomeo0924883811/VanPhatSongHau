<?php
$version  =  $environment == 'live' ? '?v=1.1.1' : '?v=' . rand(0, 10000000) . rand(0, 10000000) . rand(0, 10000000);
?>
<script src="<?php echo $this->request->webroot ?>js/commons.bundle.js<?php echo $version ?>"></script>
<script src="<?php echo $this->request->webroot ?>js/index.bundle.js<?php echo $version ?>"></script>
<!--<script src="--><?php //echo $this->request->webroot ?><!--js/main.bundle.js--><?php //echo $version ?><!--"></script> -->
