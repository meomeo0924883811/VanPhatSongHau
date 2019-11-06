import '../sass/all.scss'; // import scss
import 'slick-carousel';
import 'bootstrap';
import 'gsap';

require('./app/class.popup');
require('./app/class.subscribe');


SE.clsPopup.init();
SE.clsSubscribe.init();

$('#page-visual').slick({
    dots: true,
    infinite: true,
    arrows: false,
    autoplay: true,
    autoplaySpeed: 5000,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [

    ]
});

$('#quality-images').slick({
    dots: true,
    infinite: true,
    arrows: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [

    ]
});

$('#map-slider').slick({
    dots: false,
    infinite: true,
    arrows: true,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [

    ]
});

$('.open-image-popup').click(function () {
    let src = $(this).attr('src');
    $('#popup-image img').attr('src', src);
    SE.clsPopup.open('#popup-image');
})

$('#map-slider').on('afterChange', function(event, slick, currentSlide){
    $('#area-links .nav-link').removeClass('active');
    $('#area-links .tab-pane').removeClass('active show');
    $('#area-links .nav-link[data-id=' + (currentSlide + 1) + ']').addClass('active');
    $('#area-links .tab-pane[data-id=' + (currentSlide + 1) + ']').addClass('active show');
});

$('#area-links .nav-link').click(function () {
    let slide = $(this).data('id') -1;
    $('#map-slider').slick('slickGoTo',slide);
});

$('.single-image-preview').click(function (){
    let slide = $(this).attr('order') - 1;
    $('#quality-images').slick('slickGoTo',slide);
});

$(window).scroll(function () {
    if ($('body').scrollTop() > 600) {
        $('#back-to-top').css({
            display: 'block',
        })
    }
    else {
        $('#back-to-top').css({
            display: 'none',
        })
    }
});

var div = document.createElement('div');
div.className = 'fb-customerchat';
div.setAttribute('page_id', '2272385429514202');
div.setAttribute('ref', 'b64:Y2hhdC1saXZl');
div.setAttribute('logged_in_greeting', 'Chào anh/chị!\nEm là Long, em có thể giúp gì cho anh chị không?.');
div.setAttribute('logged_out_greeting', 'Chào anh/chị!\nEm là Long, em có thể giúp gì cho anh chị không?');
document.body.appendChild(div);
window.fbMessengerPlugins = window.fbMessengerPlugins || {
    init: function () {
        FB.init({
            appId            : '1678638095724206',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v5.0'
        });
    }, callable: []
};
window.fbAsyncInit = window.fbAsyncInit || function () {
    window.fbMessengerPlugins.callable.forEach(function (item) { item(); });
    window.fbMessengerPlugins.init();
};
setTimeout(function () {
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
}, 0);
