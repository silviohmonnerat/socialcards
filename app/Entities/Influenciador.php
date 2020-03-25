<?php
namespace App\Entities;

use DB;

class Influenciador extends BaseModel
{
    protected $table = 'tb_influenciador_card';

    public function cadastrar($parametros)
    {
        #$parametros = json_decode($parametros);
        if(!$this->verificar($parametros)) {
            $qry = new Influenciador;
            $qry->user_id = $parametros['user_id'];
            $qry->sequencial_card = $parametros['sequencial_card'];

            $qry->save();
        }

        return true;

    }

    public function verificar($parametros)
    {
        $columns = ['user_id'];

        $qry = Influenciador::from($this->table);
        
        $qry->where('user_id', '=', $parametros['user_id']);
        
        $qry->where('sequencial_card', '=', $parametros['sequencial_card']);

        $resultado = $qry->get($columns);        
        
        $resultado = collect($resultado)->toArray();

        #dd(__LINE__,__METHOD__, $parametros,$resultado,$qry->toSql());

        if(count($resultado)>0)
            return true;
        else 
            return false;
    }

    public function verificarRelacionamento($parametros)
    {
        #$parametros = json_decode($parametros);

        $columns = ['user_id'];

        $qry = Influenciador::from($this->table);
        
        $qry->where('user_id', '=', $parametros['user_id']);
        
        $qry->where('sequencial_card', '=', $parametros['sequencial_card']);

        $resultado = $qry->get($columns);        
        
        $resultado = collect($resultado)->toArray();

        #dd(__LINE__,__METHOD__, $parametros,$resultado,$qry->toSql());

        if(count($resultado)>0)
            return true;
        else 
            return false;
    }

}

