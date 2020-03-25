<?php
namespace App\Repositories;

use DB;

use App\Entities\Social;

class SocialRepository extends BaseRepository
{
    protected $Social;
    
    public function __construct( Social $entity )
    {
        $this->entity = $entity;    
    }

function login($parametros)
{
	$resultado = $this->entity->login($parametros);
	return ['sucesso'=>true];
}

function cadastra($parametros)
{
	$resultado = $this->entity->cadastra($parametros);
	return ['sucesso'=>true];
}

function alterar($parametros)
{
	$resultado = $this->entity->alterar($parametros);
	return ['sucesso'=>true];
}

function verificarCep($parametros)
{
	$resultado = $this->entity->verificarCep($parametros);
	return ['sucesso'=>true];
}

}
