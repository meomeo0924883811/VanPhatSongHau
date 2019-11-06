<html>
<head>
    <title>Asset Management</title>
    <link href="all.css" media="all" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php
include ('modules/header.php');
?>
<main role="main">
    <?php
    $page = isset($_REQUEST['page']) ? $_REQUEST['page']: 'home';
    include ('modules/'.$page.'.php');
    ?>
</main><!-- /.container -->
<?php
include ('modules/footer.php');
?>
<?php
include ('modules/subscribe-popup.php');
?>
<div class="popup" id="loading"></div>
<a href="#" id="back-to-top"></a>
<div class="fb-customerchat"
    page_id="101756427940723"
    ref="live-chat">
</div>


<script src="js/commons.bundle.js"></script>
<script src="js/index.bundle.js"></script>

</body>
</html>
