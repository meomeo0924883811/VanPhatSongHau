SE.clsPopup = (function () {
    //INIT
    function init() {
        initEvent();
    }

    function initEvent() {
        $('.close-popup').click(function () {
            closeAll();
        });

        $('.open-popup').click(function () {
            open('#popup-subscriber');
        });
    }

    //FUNCTIONS
    function closePopup(id) {
        TweenMax.to((id), 0.2, {css: {display: 'none', opacity: 0, visibility: 'hidden'}});
    }

    function closeAll() {
        TweenMax.to(('.popup'), 0.2, {css: {display: 'none', opacity: 0, visibility: 'hidden'}});
    }

    function open(id) {
        TweenMax.to((id), 0.4, {css: {display: 'block', opacity: 1, visibility: 'visible'}});
    }

    //RETURN
    return {
        init: init,
        closeAll: closeAll,
        open: open,
        closePopup: closePopup,
    }
})();

