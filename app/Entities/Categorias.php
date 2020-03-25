<?php
namespace App\Entities;

use DB;

class Categorias extends BaseModel
{
    protected $table = 'tb_categorias';

    public function listar()
    {
        $columns = ['id', 'categoria', 'slug'];

        $qry = Categorias::from($this->table);
        $qry->where('ativa', '=', 1);
        
        $resultado = $qry->get($columns);        
        $resultado = collect($resultado)->toArray();

        if (count($resultado) > 0) {
            return $resultado;
        }

        return $resultado = [];
    }

    public function getCategory($params)
    {
        $columns = ['id', 'categoria', 'slug'];

        $qry = Categorias::from($this->table);
        
        if (isset($params['id_categorias'])) {
            $qry->where('id', '=', $params['id_categorias']);
        }
        
        $resultado = $qry->get($columns);        
        
        $resultado = collect($resultado)->toArray();

        if(count($resultado) > 0){
            return $resultado[0];
        }
         
        return null;
    }
}