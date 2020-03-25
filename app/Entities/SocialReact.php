<?php
namespace App\Entities;

use DB;

class SocialReact extends BaseModel
{
    protected $table = 'tb_reacoes_social';

    public function verificar($parametros)
    {

            $columns = ['user_id'];

            $qry = SocialReact::from($this->table);
            
            $qry->where('user_id', '=', $parametros['user_id']);
            $qry->where('sequencial_card', '=', $parametros['sequencial_card']);
            #$qry->where('social_id', '=', $parametros['social_id']);

            $resultado = $qry->get($columns);        
            
            $resultado = collect($resultado)->toArray();

            #dd(__LINE__,__METHOD__, $parametros,$resultado,$qry->toSql());

            if(count($resultado)>0)
                return $resultado[0];
            else 
                return null;
    }

    public function cadastra($parametros)
    {
        #$parametros = json_decode($parametros);
        switch ($parametros['social_id']) {
        case 'like':
            $parametros['social_id'] = 1;
            break;
        case 'love':
            $parametros['social_id'] = 2;
            break;
        case 'haha':
            $parametros['social_id'] = 3;
            break;
        case 'wow':
            $parametros['social_id'] = 4;
            break;
        case 'sad':
            $parametros['social_id'] = 5;
            break;
        case 'angry':
            $parametros['social_id'] = 6;
            break;
    }
	if(is_null($this->verificar($parametros))) {
        	$qry = new SocialReact;
        	$qry->user_id = $parametros['user_id'];
        	$qry->sequencial_card = $parametros['sequencial_card'];
        	$qry->social_id = $parametros['social_id'];

        	$qry->save();
    }
    
    $qtdReacao = $this->qtdReacoes($parametros);

        return ['total'=>$qtdReacao];

    }

    public function qtdReacoes($parametros)
    {
        switch ($parametros['social_id']) {
            case 'like':
                $parametros['social_id'] = 1;
                break;
            case 'love':
                $parametros['social_id'] = 2;
                break;
            case 'haha':
                $parametros['social_id'] = 3;
                break;
            case 'wow':
                $parametros['social_id'] = 4;
                break;
            case 'sad':
                $parametros['social_id'] = 5;
                break;
            case 'angry':
                $parametros['social_id'] = 6;
                break;
        }
	    $columns = ['social_id'];

        $qry = SocialReact::from($this->table);
        
        $qry->where('sequencial_card', '=', $parametros['sequencial_card']);
        $qry->where('social_id', '=', $parametros['social_id']);
	
	    $total = $qry->get($columns)->count();
        return $total;

    }


    public function verificarReacao($parametros)
{
    #dd($parametros);
    #$parametros = json_decode($parametros);
        
    $columns = ['user_id'];

    $qry = SocialReact::from($this->table);
    
    $qry->where('user_id', '=', $parametros['user_id']);
    
    $qry->where('sequencial_card', '=', $parametros['sequencial_card']);

    #$qry->where('social_id', '=', $parametros['social_id']);

    $resultado = $qry->get($columns);        
    
    $resultado = collect($resultado)->toArray();

    #dd(__LINE__,__METHOD__, $parametros,$resultado,$qry->toSql());

    if(count($resultado)>0)
        return true;
    else 
        return false;
}

}

