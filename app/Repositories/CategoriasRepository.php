<?php
namespace App\Repositories;

use DB;

use App\Entities\Categorias;

class CategoriasRepository extends BaseRepository
{
    protected $Categorias;
    
    public function __construct(
        Categorias $entity 
    )
    {
        $this->entity = $entity;    
    }

    public function listar()
    {
        return $this->entity->listar();
    }
    
    public function getCategory($params)
    {
        return $this->entity->getCategory($params);
    }
}
