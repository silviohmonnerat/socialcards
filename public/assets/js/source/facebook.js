var Facebook = {
    config: {
        ip: '157.230.157.117',
        ssh: 'root@socialcards.com.br',
        senha: 's4ndr01972',
        appId: '598321220616638',
        protocol: location.protocol,
        domain: location.hostname,
        api: 'https://'+location.hostname,
        urlShared: 'https://'+location.hostname+'/assets/images/compartilhadas/',
        endpoint: {
            loginsocial: 'https://'+location.hostname+'/loginsocial',
            reactsocial: 'https://'+location.hostname+'/reactsocial',
            updatesocial: 'https://'+location.hostname+'/updatesocial',
            verificacep: 'https://'+location.hostname+'/verificacep',
            verificainfluencia: 'https://'+location.hostname+'/verificainfluencia',
            verificareacao: 'https://'+location.hostname+'/verificareacao',
            salvarimagem: 'https://'+location.hostname+'/salvarimagem'
        }
    },

    init: function() {
        var self = this;
        console.log(self.config);

        $.ajaxSetup({
            cache: true
        });
        $.getScript('//connect.facebook.net/en_US/sdk.js', function() {
            // Load the APP / SDK
            FB.init({
                appId: '598321220616638', // App ID from the App Dashboard
                cookie: true, // set sessions cookies to allow your server to access the session?
                xfbml: true, // parse XFBML tags on this page?
                version: 'v3.2',
                frictionlessRequests: true,
                oauth: true
            });

            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    console.log('Conectado');
                    $('body').removeClass('logged-out');
                    $('body').addClass('logged-in');
                } else {
                    console.log('Não conectado');
                    $('body').removeClass('logged-in');
                    $('body').addClass('logged-out');
                }
            }); 

        });
        
        self.afterInit();
    },

    afterInit: function() {
        var self = this;

        self.bindEvents();

        return this;
    },

    bindEvents: function () {
        var self = this;

        $("[data-target='compartilhar']").on("click", function(event) {
            event.preventDefault();
    
            var parent   = $(this).parents('.Card'),
                formData = {};

            formData['sequencial_card'] = parent.data('sequencial');
            formData['titulo']          = parent.data('titulo');
            formData['categoria']       = parent.data('categoria');
            formData['categoria_id']    = parent.data('cat');
            formData['url']             = self.config.api+'/?categoria='+formData['categoria_id'];

            var captureArea = document.getElementById('Card-'+formData['sequencial_card']);
            var obejtoImage = {};

            if('image' in formData){
                console.log('imagem já gerada.');
            } else {
                domtoimage.toPng(captureArea).then(function (dataUrl) {
                    obejtoImage['nome']  = self.slugify(formData['titulo']);
                    obejtoImage['image'] = dataUrl;

                    $.post(self.config.endpoint.salvarimagem, {
                        data: JSON.stringify(obejtoImage)
                    }, function(response) {
                        formData['image'] = self.config.urlShared+response;
                    });
                }).catch(function (error) {
                    console.error('oops, something went wrong!', error);
                });                
            }            
    
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    formData['user_id'] = response.authResponse.userID;
                    $.ajax({
                        url: self.config.endpoint.verificacep,
                        data: JSON.stringify(formData),
                        type: 'POST',
                        crossDomain: true,
                        dataType: 'json',
                        contentType: 'application/json',
                        success: function(data) {
                            if (data) {                        
                                self.verifyInfluence(self.config.endpoint, formData);
                            }
                        }
                    });
                } else {
                    self.Login(self.config.endpoint.loginsocial);
                }
            });        
        });
    
        $('[data-target="reagir"]').click(function(event){
            event.preventDefault();
    
            var parent   = $(this).parents('.Card'),
                formData = {};
    
            formData['sequencial_card'] = parent.data('sequencial');
            formData['titulo']          = parent.data('titulo');
            formData['categoria']       = parent.data('categoria');
            formData['social_id']       = $(this).data('react');
    
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    formData['user_id'] = response.authResponse.userID;
                    $.ajax({
                        url: self.config.endpoint.verificareacao,
                        data: JSON.stringify(formData),
                        type: 'POST',
                        crossDomain: true,
                        dataType: 'json',
                        contentType: 'application/json',
                        success: function(data) { 
                            if (data.sucesso == true) {
                                Swal({
                                    title: 'Atenção!',
                                    type: 'warning',
                                    text: 'Você já reagiu nesse Card.',
                                    showCancelButton: true
                                });
                            } else {
                                self.setReact(self.config.endpoint, formData);
                            }
                        }
                    });                
                } else {
                    self.Login(self.config.endpoint.loginsocial);
                }
            });
        });

        return this;
    },

    slugify: function(str) {
		var map = {
            '-' : ' ',
            '-' : '_',
            'a' : 'á|à|ã|â|À|Á|Ã|Â',
            'e' : 'é|è|ê|É|È|Ê',
            'i' : 'í|ì|î|Í|Ì|Î',
            'o' : 'ó|ò|ô|õ|Ó|Ò|Ô|Õ',
            'u' : 'ú|ù|û|ü|Ú|Ù|Û|Ü',
            'c' : 'ç|Ç',
            'n' : 'ñ|Ñ'
        };
        
        str = str.toLowerCase();
        
        for (var pattern in map) {
            str = str.replace(new RegExp(map[pattern], 'g'), pattern);
        };
    
        return str;
    },

    facebookShare: function(params) {
        setTimeout(function(){
            FB.ui({
                method: 'share_open_graph',
                action_type: 'og.shares',
                action_properties: JSON.stringify({
                    object: {
                        'og:url': params.url,
                        'og:title': params.titulo,
                        'og:description': params.categoria,
                        'og:image': params.image
                    }
                })
            }, function(response){
                if (response.error_code) {
                    Swal({
                        type: 'error',
                        title: 'Código ' + response.error_code,
                        html: response.error_message,
                        showCancelButton: true
                    });
                } else {
                    Swal({
                        type: 'success',
                        title: 'Sucesso!',
                        text: 'Card Compartilhado com sucesso.',
                        showCancelButton: true
                    });
                }
            });
        }, 2000);
    },

    dataURLtoFile: function(dataurl, filename) {
        var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]), n = bstr.length, u8arr = new Uint8Array(n);
        while(n--){
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {type:mime});
    },

    Login: function(route) {
        var self = this;

        FB.login(function (response) {
            if (response.authResponse) {
                self.setDataFbLogin(route);
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

        return this;
    },

    consultaCEP: function(formData) {
        var self = this;

        Swal({
            title: 'Digite seu CEP',
            input: 'text',
            type: 'info',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Buscar',
            showLoaderOnConfirm: true,
            preConfirm: function(cep) {
                return fetch('//viacep.com.br/ws/'+cep+'/json/').then(function(response){
                    console.log(response);
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

                $.ajax({
                    url: self.config.endpoint.updatesocial,
                    data: JSON.stringify(formData),
                    type: 'POST',
                    crossDomain: true,
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(data) {
                        Swal({
                            type: 'success',
                            title: 'Parabéns!',
                            text: 'Deseja compartilhar esse Card no seu perfil?',
                            showCancelButton: true,
                            confirmButtonText: 'Sim',
                        }).then(function(res) {
                            if (res.value) {
                                self.facebookShare(formData);
                            }
                        });                       
                    }
                });                
            }
        });
    },

    setDataFbLogin: function(route) {
        var self = this;

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
                        url: route,
                        data: JSON.stringify(response),
                        type: 'POST',
                        crossDomain: true,
                        dataType: 'json',
                        contentType: 'application/json',
                        success: function(data) { 
                            return true;
                        }
                    });
                });
            }
        });

        return this;
    },

    setReact: function(route, params) {
        var self = this;
        Swal({
            type: 'success',
            title: 'Sucesso!',
            text: "Reação feita com sucesso!",
            showCancelButton: true
        }).then(function(response) {
            if (response.value) {
                $.ajax({
                    url: route.reactsocial,
                    data: JSON.stringify(params),
                    type: 'POST',
                    crossDomain: true,
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(data) {
                        $('article[data-sequencial="'+params.sequencial_card+'"] a[data-react="'+params.social_id+'"] > span').text(data.total).trigger("change");
                    }
                });
            }
        });

        return this;
    },
    
    verifyInfluence: function(route, params) {
        var self = this;
        
        $.ajax({
            url: route.verificainfluencia,
            data: JSON.stringify(params),
            type: 'POST',
            crossDomain: true,
            dataType: 'json',
            contentType: 'application/json',
            success: function(response) { 
                if (response.sucesso) {
                    Swal({
                        title: 'Atenção!',
                        type: 'warning',
                        text: 'Card já compartilhado. Deseja novamente compartilhar?',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                    }).then(function(data) {
                        if (data.value) {
                            self.facebookShare(params);
                        }
                    });
                } else {
                    self.setInfluence(route.updatesocial, params);
                }
            }
        });       

        return this;
    },

    setInfluence: function(route, params) {
        var self = this;

        $.ajax({
            url: route,
            data: JSON.stringify(params),
            type: 'POST',
            crossDomain: true,
            dataType: 'json',
            contentType: 'application/json',
            success: function(response) {
                Swal({
                    type: 'success',
                    title: 'Parabéns!',
                    text: 'Deseja compartilhar esse Card no seu perfil?',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                }).then(function(data) {
                    if (data.value) {
                        self.facebookShare(params); 
                    }
                });                
            }
        });

        return this;
    }
};

;(function ($, window, undefined) {
    'use strict';
    $(document).ready(function() {
        Facebook.init();
	});
})(jQuery, this);

//_.bindAll(Facebook, 'init', 'afterInit', 'bindEvents', 'facebookShare', 'slugify', 'dataURLtoFile', 'Login', 'consultaCEP', 'setDataFbLogin', 'setReact', 'verifyInfluence', 'setInfluence');