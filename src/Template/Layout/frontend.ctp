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
    ?><!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1792703004342672');
        fbq('track', 'PageView');
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151773686-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-151773686-1');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=1792703004342672&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

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
<?= $this->element('includes/all_js_css_footer'); ?>
</body>
</html>
