var Category = {
    config: {
        protocol: location.protocol,
        domain: location.hostname,
        api: 'https://'+location.hostname,
        endpoint: {
            listarcategorias: 'https://'+location.hostname+'/listarcategorias'
        }
    },

    init: function() {
        var self = this;
        
        self.afterInit();
    },

    afterInit: function() {
        var self = this;

        self.bindEvents();

        return this;
    },

    bindEvents: function () {
        var self = this;
        
        self.Listar(self.config.endpoint);

        return this;
    },

    Listar: function(route) {
        var self = this;
        
        $.get(route.listarcategorias, function(response) {
            var _html = '';
            if (response.success) {
                $.each(response.data, function(key, value) {
                    _html += '<li class="nav-selector__item" role="menuitem">'+
                        '<a href="/?categoria='+value.id+'" tabindex="-'+key+'" data-target="link">'+
                            '<span>'+value.categoria+'</span>'+
                        '</a>'+
                    '</li>';
                });

                $('.nav-list__item-selector').html(_html);
            }
        });
    }

};

//_.bindAll(Category, 'init', 'afterInit', 'bindEvents', 'Listar');

;(function ($, window, undefined) {
    'use strict';
    $(document).ready(function() {
        Category.init();
	});
})(jQuery, this);