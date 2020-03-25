<?php
namespace App\Repositories;

use DB;

use App\Entities\Cards;

class CardsRepository extends BaseRepository
{
    protected $entity;
    
    public function __construct( Cards $Entity )
    {
        $this->entity = $Entity;    
    }

    public function cardsList($parametros) 
    {
        return $this->entity->cardsList($parametros);
    }

    public function getCards($parametros) 
    {
        return $this->entity->getCards($parametros);
    }

    public function criar($parametros)
    {
        return $this->entity->criar($parametros);        
    }
}