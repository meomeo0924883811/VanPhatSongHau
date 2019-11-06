<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>Error Pages</title>
    <link rel="stylesheet prefetch" href="<?php echo $this->request->webroot ?>error/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $this->request->webroot ?>error/css/style.css">
</head>

<body>
<div class="error-page">
    <div>
        <?php
        echo $this->fetch('content');
        ?>
    </div>
</div>
<div id="particles-js"></div>
<script src='<?php echo $this->request->webroot ?>error/js/particles.min.js'></script>
<script src="<?php echo $this->request->webroot ?>error/js/index.js"></script>
</body>

</html>
