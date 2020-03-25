var Card = {
    config: {
        protocol: location.protocol,
        domain: location.hostname,
        api: 'https://'+location.hostname,
        endpoint: {
            criarcard: 'https://'+location.hostname+'/criarcard',
            saveimage: 'https://'+location.hostname+'/saveimage'
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

        window.onload = self.verificaSeEstaLogado;
        
        $("[data-target='criar']").on("click", self.Login);

        self.menuCategorias('https://'+location.hostname+'/listarcategorias');
        $('form[name="formCriarCard"]').on('submit', self.Criar);

        return this;
    },

    verificaSeEstaLogado: function(){
        if ( $('body').hasClass('logged-out') ) {
            document.getElementById("cardname").disabled = true;
            document.getElementById("cardcategory").disabled = true;
            document.getElementById("cardurl").disabled = true;
            document.getElementById("cardimage").disabled = true;
            document.getElementById("cardsubmit").disabled = true;

            $('body.logged-out').on("click", function(event){
                event.stopPropagation();
                event.preventDefault();

                FB.login(function (response) {
                    if (response.authResponse) {
                        FB.api('/me', {
                            fields: 'id, age_range, picture, birthday, email, first_name, last_name, gender, location, name'
                        }, function (response) {
                            response['provider'] = 'facebook';
                            response['user_id']  = response.id;
                            $.ajax({
                                url: 'https://'+location.hostname+'/loginsocial',
                                data: JSON.stringify(response),
                                type: 'POST',
                                crossDomain: true,
                                dataType: 'json',
                                contentType: 'application/json',
                                success: function(data) {
                                    Swal({
                                        title: 'Sucesso!',
                                        text: "Login feito com sucesso!",
                                        type: 'success',
                                        showCancelButton: true
                                    }).then( function(data) {
                                        if (data.value) {
                                            document.getElementById("cardname").disabled = false;
                                            document.getElementById("cardcategory").disabled = false;
                                            document.getElementById("cardurl").disabled = false;
                                            document.getElementById("cardimage").disabled = false;
                                            document.getElementById("cardsubmit").disabled = false;
                                        }
                                    });
                                    
                                }
                            });
                        });
                    } else {
                        Swal({
                            type: 'error',
                            text: 'O usuário cancelou o login ou não autorizou totalmente.',
                            showCloseButton: true
                        });
                    }
                },{
                    scope: 'email, public_profile'
                });
            });
        }
    },

    Login: function(event){
        event.preventDefault();

        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                window.location = '/criar';
            } else {
                FB.login(function (response) {
                    if (response.authResponse) {
                        Swal({
                            title: 'Sucesso!',
                            text: "Login feito com sucesso!",
                            type: 'success',
                            showCancelButton: true
                        }).then( function(data) {
                            if (data.value) {
                                FB.api('/me', {
                                    fields: 'id, age_range, picture, birthday, email, first_name, last_name, gender, location, name'
                                }, function (response) {
                                    response['provider'] = 'facebook';
                                    response['user_id']  = response.id;
                                    $.ajax({
                                        url: 'https://'+location.hostname+'/loginsocial',
                                        data: JSON.stringify(response),
                                        type: 'POST',
                                        crossDomain: true,
                                        dataType: 'json',
                                        contentType: 'application/json',
                                        success: function(data) { 
                                            window.location = '/criar';
                                        }
                                    });
                                });
                            }
                        });
                    } else {
                        Swal({
                            type: 'error',
                            text: 'O usuário cancelou o login ou não autorizou totalmente.',
                            showCloseButton: true
                        });
                    }
                },{
                    scope: 'email, public_profile'
                });
            }
        });
    },

    menuCategorias: function(route) {
        $.get(route, function(response) {
            var option = '<option value="">Escolha a Modalidade</option>';
            if (response.success) {
                $.each(response.data, function(key, value) {
                    option += '<option value="'+value.id+'">'+value.categoria+'</option>';
                });

                $('#cardcategory').html(option);
            }
        });
    },

    Criar: function(event) {
        var self = this;

        event.stopPropagation();
        event.preventDefault();

        var values = {};
        $.each($('input[type="text"], input[type="url"], select'), function(i, field) {
            values[field.name] = field.value;
        });

        var formData = {};
        $.each($('#cardimage')[0].files, function(i, file) {
            formData['cardimage'] = file;
        });

        console.log('Montado o objeto');
        console.table(values);
        console.table(formData);
    
        $.ajax({
            url: 'https://'+location.hostname+'/criarcard',
            data: values,
            type: 'POST',
            dataType: 'json',
            before: function(){
                $('input[type="submit"]', $('#formCriarCard')).prop('disabled', true);
                $('input[type="submit"]', $('#formCriarCard')).value('Processsando ...');
            },
            success: function(response) {
                console.log('Resposta do ajax que cria o card.');
                console.table(response);
                formData['data'] = response.data;
                console.log('Passando o objeto de retorno para o objeto formData');
                console.table(formData);

                var title = response.title;
                var message = reponse.message;
                if (response.success) {
                    var timerInterval;
                    Swal.fire({
                        title: 'Aguarde...',
                        html: 'Estamos salvando os dados.',
                        timer: 2000,
                        onBeforeOpen: function(){
                            Swal.showLoading();
                            timerInterval = setInterval(function(){
                                $.ajax({
                                    url: 'https://'+location.hostname+'/saveimage',
                                    type: 'POST',
                                    data: formData,
                                    cache: false,
                                    dataType: 'json',
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        console.log('Resposta do ajax que salva a imagem');
                                        console.table(response);
                                    }
                                });
                            }, 100);
                        },
                        onClose: function(){
                            clearInterval(timerInterval);
                        }
                    }).then(function(result) {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            Swal({
                                type: 'success',
                                title: title,
                                text: message,
                                showCancelButton: true
                            }).then(function(result){
                                if (result.value) {
                                    document.getElementById('formCriarCard').reset();
                                    $('input[type="submit"]', $('#formCriarCard')).value('Criar');
                                    $('input[type="submit"]', $('#formCriarCard')).prop('disabled', false);                 
                                }
                            });
                        }
                    });
                } else {
                    Swal({
                        type: 'error',
                        title: response.title,
                        text: response.message,
                        showCancelButton: true
                    });                    
                }                
            }
        });
    }

};

//_.bindAll(Card, 'init', 'afterInit', 'bindEvents', 'Criar', 'ValidaCampos');

;(function ($, window, undefined) {
    'use strict';
    $(document).ready(function() {
        Card.init();
	});
})(jQuery, this);