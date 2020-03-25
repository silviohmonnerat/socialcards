<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/cardslist',
        '/profile',
        '/login',
        '/pwdupdate',
        '/dashboard',
        '/pluginativado',
        '/plugindesativado',
        '/pagamentos',
        '/boleto',
        '/perfil',
        '/privacidade',
        '/loginsocial',
        '/sobre',
        '/reactsocial',
        '/updatesocial',
        '/verificacep',
        '/verificainfluencia',
        '/socialcard',
        '/verificareacao',
        '/salvarimagem',
        '/listarcategorias',
        '/criarcard',
        '/saveimage'
    ];
}
