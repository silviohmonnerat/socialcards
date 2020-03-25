<?php
namespace App\Entities;

use DB;

class Social extends BaseModel
{
    protected $table = 'tb_login_social';

    public function login($parametros)
    {
        #$parametros = json_decode($parametros);
	    if (is_null($this->verificar($parametros))) {
        	$qry = new Social;
        	$qry->user_id = array_get($parametros,'user_id', null);
        	$qry->first_name = array_get($parametros,'first_name', null);
        	$qry->last_name = array_get($parametros,'last_name', null);
        	$qry->email = array_get($parametros,'email', null);
        	$qry->provider = array_get($parametros,'provider', null);
        	$qry->imagem = $parametros['picture']['data']['url'];
        	$qry->sexo = array_get($parametros,'gender', null);
        	$qry->data_nascimento = array_get($parametros,'birthday', null);

        	$qry->save();
	    }

        return true;

    }

    public function verificar($parametros)
    {
        $columns = ['user_id'];

        $qry = Social::from($this->table);
        
        $qry->where('user_id', '=', $parametros['user_id']);

        $resultado = $qry->get($columns);        
        
        $resultado = collect($resultado)->toArray();

        #dd(__LINE__,__METHOD__, $parametros,$resultado,$qry->toSql());

        if (count($resultado) > 0) {
            return $resultado[0];
        } else {
            return null;
        }
    }

    public function alterar($parametros)
    {
	    #$parametros = json_decode($parametros);
	
        if (!is_null($this->verificar($parametros))) {
            $columns = [
                'uf'     => $parametros['uf'],
                'cidade' => $parametros['cidade'],
                'bairro' => $parametros['bairro'],
                'cep'    => $parametros['cep']
            ];

            Social::where('user_id', '=', $parametros['user_id'])
                  ->update($columns);
        }

        return true;

    }

    public function verificarCep($parametros)
    {
	    #$parametros = json_decode($parametros);

        $columns = ['user_id'];

        $qry = Social::from($this->table);
        
        $qry->where('user_id', '=', $parametros['user_id']);

        $qry->whereNotNull('cep');

        $resultado = $qry->get($columns);        
        
        $resultado = collect($resultado)->toArray();

        #dd(__LINE__,__METHOD__, $parametros,$resultado,$qry->toSql());

        if (count($resultado) > 0) {
            return true;
        } else {
            return false;
        }
    }
}

