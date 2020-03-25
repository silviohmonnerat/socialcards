(function($) {
    var url = 'https://www.socialcards.com.br';
    var config = {
        appId: '598321220616638',
        endpoint: {
            loginsocial: url + '/loginsocial',
            reactsocial: url + '/reactsocial',
            updatesocial: url + '/updatesocial',
            verificacep: url + '/verificacep',
            verificainfluencia: url + '/verificainfluencia',
            verificareacao: url + '/verificareacao'
        }
    };

    window.fbAsyncInit = function() {
        // FB JavaScript SDK configuration and setup
        FB.init({
          appId      : '598321220616638', // FB App ID
          cookie     : true,  // enable cookies to allow the server to access the session
          xfbml      : true,  // parse social plugins on this page
          version    : 'v3.2' // use graph api version 2.8
        });
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                console.log('Conectado');
            } else {
                console.log('Não conectado');
            }
        }); 
    };

    // Carregar o SDK do JavaScript de forma assíncrona
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/pt_BR/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    $("[data-target='influence']").on("click", function(event) {
        event.preventDefault();

        var parent   = $(this).parents('.Card'),
            formData = {};

        formData['sequencial_card'] = parent.data('sequencial');

        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                formData['user_id'] = response.authResponse.userID;
                $.post(config.endpoint.verificacep, {
                    data: JSON.stringify(formData)
                }, function(response) {
                    if (response) {                        
                        verifyInfluence(config.endpoint, formData);
                    } else {
                        consultaCEP(formData);
                    }
                });
            } else {
                fbLogin();
            }
        });        
    });

    $('[data-target="react"]').click(function(event){
        event.preventDefault();

        var parent   = $(this).parents('.Card'),
            formData = {};

        formData['social_id']     = $(this).data('react');
        formData['sequencial_card'] = parent.data('sequencial');

        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                formData['user_id'] = response.authResponse.userID;
                $.post(config.endpoint.verificareacao, {
                    data: JSON.stringify(formData)
                }, function(response) {
                    console.log(response);
                    if (response.sucesso == true) {
                        Swal({
                            title: 'Atenção!',
                            type: 'warning',
                            text: 'Você já reagiu nesse Card.',
                            showCancelButton: true
                        });
                    } else {
                        setReact(config.endpoint, formData);
                    }
                });                
            } else {
                fbLogin();
            }
        });
    });
    
    function fbLogin() {
        FB.login(function (response) {
            if (response.authResponse) {
                setDataFbLogin(config.endpoint.loginsocial);
            } else {
                Swal({
                    type: 'error',
                    text: 'O usuário cancelou o login ou não autorizou totalmente.',
                    showCloseButton: true
                });
            }
        });
    }

    function consultaCEP(formData){
        Swal({
            title: 'Entre com o teu CEP',
            input: 'text',
            type: 'info',
            inputAttributes: {
              autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Buscar',
            showLoaderOnConfirm: true,
            preConfirm: function(cep){
                return fetch('//viacep.com.br/ws/'+cep+'/json/').then(function(response){
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                }).catch(function(error){
                    Swal.showValidationMessage(
                        'Request failed: '+error
                    )
                })
            },
            allowOutsideClick: function(){
                !Swal.isLoading()
            }
        }).then(function(result){
            if (result.value) {
                formData['uf']     = result.value.uf;
                formData['cidade'] = result.value.localidade;
                formData['bairro'] = result.value.bairro;
                formData['cep']    = result.value.cep;
                Swal({
                    title: 'Sucesso!',
                    type: 'success',
                    text: 'Obrigado por participar',
                    showCancelButton: true
                }).then(function(response) {
                    if (response.value) {
                        ajaxPost(config.endpoint.updatesocial, formData);
                    }
                });
            }
        });
    }

    function ajaxPost(url, params){
        $.post(url, {
            data: JSON.stringify(params)
        }, function(response) {
            return true; 
        });
    }
    
    function setDataFbLogin(route) {
        Swal({
            title: 'Sucesso!',
            text: "Login feito com sucesso!",
            type: 'success',
            showCancelButton: true
        }).then( function(data) {
            if (data.value) {
                FB.api('/me', {
                    fields: 'id,about,age_range,picture,birthday,email,first_name,gender,link,location,middle_name,name,timezone,website,work'
                }, function (response) {
                    response['provider'] = 'facebook';
                    response['user_id']  = response.id;
                    ajaxPost(route, response);
                });
            }
        });        
    }

    function setReact(route, params){
        Swal({
            type: 'success',
            title: 'Sucesso!',
            text: "Reação feita com sucesso!",
            showCancelButton: true
        }).then(function(response) {
            if (response.value) {
                $.post(route.reactsocial, {
                    data: JSON.stringify(params)
                }, function(data) {
                    var retorno = JSON.stringify(data);
                    $('article[data-sequencial="'+params.sequencial_card+'"] a[data-react="'+params.social_id+'"] > span').text(data.total).trigger("change");
                });
            }
        });
    }
    
    function verifyInfluence(route, params){
        $.post(route.verificainfluencia, {
            data: JSON.stringify(params)
        }, function(response) {
            if (response.sucesso) {
                Swal({
                    title: 'Atenção!',
                    type: 'warning',
                    text: 'Você já é um influenciador desse candidato.',
                    showCancelButton: true
                });
            } else {
                setInfluence(route.updatesocial, params);
            }
        });       
    }

    function setInfluence(route, params){
        Swal({
            type: 'success',
            title: 'Sucesso!',
            text: 'Agora você é um influenciador desse candidato.',
            showCancelButton: true
        }).then(function(response) {
            if (response.value) {
                ajaxPost(route, params);
            }
        });        
    }

})(jQuery);