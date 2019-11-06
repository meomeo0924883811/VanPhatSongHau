<html lang="vi">
<!--<![endif]-->
<head>
    <!-- Basic Page Needs
      ================================================== -->
    <?php
    $jsVars = array(
        'webroot' => $this->request->webroot,
        'webroot_full' => $webroot_full,
        'language' => $language,
        'client_device' => $agentInfo['client_device'],
        'client_device_name' => $agentInfo['client_device_name'],
        'client_browser' => $agentInfo['client_browser'],
        'client_os' => $agentInfo['client_os'],
        'environment' => $environment,
        'AppSettings' => $app_settings
    );
    echo $this->Html->charset();
    echo $this->element('includes/meta_tags');
    echo $this->Html->meta('icon');
    echo $this->Html->scriptBlock('var window_app = ' . json_encode($jsVars) . ';');
    echo $this->element('includes/all_js_css');
    echo $this->fetch('script');
    ?>
</head>
<body
    class="<?php echo $agentInfo['client_device'] ?> <?php echo $agentInfo['client_os'] ?> <?php echo $agentInfo['client_device_name'] ?> <?php echo $agentInfo['client_browser'] ?>  <?php echo 'language_' . $language ?>">
<?= $this->element('modules/header'); ?>
<main role="main">
    <?php echo $this->fetch('content'); ?>
</main>
<?= $this->element('modules/footer'); ?>
<?= $this->element('modules/subscribe-popup'); ?>
<?= $this->element('modules/image-popup'); ?>
<div class="popup" id="loading"></div>
<a href="#" id="back-to-top"></a>
<div class="fb-customerchat"
     page_id="2272385429514202"
     theme_color="#D3D3D3"
     ref="live-chat">
</div>

<?= $this->element('includes/all_js_css_footer'); ?>
</body>
</html>
