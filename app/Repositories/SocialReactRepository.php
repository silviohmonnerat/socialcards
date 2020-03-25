<?php
namespace App\Repositories;

use DB;

use App\Entities\SocialReact;

class SocialReactRepository extends BaseRepository
{
    protected $SocialReact;
    
    public function __construct( SocialReact $entity )
    {
        $this->entity = $entity;    
    }

function cadastra($parametros)
{
	$resultado = $this->entity->cadastra($parametros);
	return $resultado;
}

function qtdReacoes($parametros)
{
	$resultado = $this->entity->qtdReacoes($parametros);
	return $resultado;
}

function verificar($parametros)
{
	$resultado = $this->entity->verificarReacao($parametros);
	return ['sucesso'=>$resultado];
}

}
