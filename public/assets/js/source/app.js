(function($) {
    $(document).ready(function(){
        $('[data-target="menu"], .App-menu').click(function(){
            $(this).toggleClass('open');
            $('.App-menu').toggleClass('open');
            $('body, .App-menu').toggleClass('no-scroll');
        });

        $('[data-target="modal"]').click(function(){
            var buttonId = $(this).data('animate');
            $('#modal-container').removeAttr('class').addClass(buttonId);
            $('body').addClass('modal-active');
        });

        $('[data-dismiss="modal"]').click(function(){
            $('#modal-container').addClass('out');
            $('body').removeClass('modal-active');
        });

        setNavigation('.sidebar-middle ul li a');
        setNavigation('.sidebar-bottom ul li a');
  
        // DOM variables
        var document = $(document),
            languageDesktopButton = $('.nav-list__item'),
            hamburguerMenu        = $('.menu'),
            languageMobileButton  = $('.language'),
            languageSelector      = '.nav-list__item-selector';
    
        languageDesktopButton.on('click', function () {
            $(this).toggleClass('is-open');
    
            toggleARIA($(this).find(languageSelector), 'aria-expanded');
            toggleARIA($(this).find(languageSelector), 'aria-hidden');
        });
        hamburguerMenu.on("click", function () {
            $(this).parent().parent().toggleClass('is-open');
    
            toggleARIA($(this).parent().parent(), 'aria-hidden');
        });
    
        languageMobileButton.on('click', function () {
            $(this).toggleClass('is-open');
    
            toggleARIA($(this), 'aria-expanded');
        });
    });
    
    // Toggle ARIA attributes
    function toggleARIA(selector, ARIA) {
        selector.attr(ARIA, function (i, attr) {
            return attr == 'true' ? 'false' : 'true';
        });
    }

    var setNavigation = function(element) {
        // Menu active
        $(element).each(function(index) {
            if(this.href.trim() == window.location)
            $(this).addClass("active");
        });
    };

})(jQuery);