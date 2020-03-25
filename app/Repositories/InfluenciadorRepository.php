<?php
namespace App\Repositories;

use DB;

use App\Entities\Influenciador;

class InfluenciadorRepository extends BaseRepository
{
    protected $Influenciador;
    
    public function __construct( Influenciador $entity )
    {
        $this->entity = $entity;    
    }

function cadastrar($parametros)
{
	$resultado = $this->entity->cadastrar($parametros);
	return ['sucesso'=>true];
}

function verificar($parametros)
{
	$resultado = $this->entity->verificarRelacionamento($parametros);
	return ['sucesso'=>$resultado];
}


}
