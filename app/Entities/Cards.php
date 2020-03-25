<?php
namespace App\Entities;

use Illuminate\Pagination\Paginator;

use DB;

class Cards extends BaseModel
{
    protected $table = 'tb_categorias_cards';
    
    public function getCard($parametros)
    {
        $columns = ['id','id_categorias','titulo','sequencial_card'];

        $qry = Cards::from($this->table);
        
        if(isset($parametros['id']))
            $qry->where('id', '=', $parametros['sq']);
        
        $resultado = $qry->get($columns);        
        
        $resultado = collect($resultado)->toArray();

        if(count($resultado)>0)
            return $resultado[0];
        else 
            return null;
        
    }

    public function getCards($parametros)
    {
        $columns = [
            'tb_categorias_cards.id',
            'tb_categorias_cards.id_categorias',
            'tb_categorias_cards.titulo',
            'tb_categorias_cards.sequencial_card'
        ];

        $page = $parametros['page'];

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $cards = Cards::join('tb_categorias AS tc','tc.id', '=', 'tb_categorias_cards.id_categorias')
                      ->where('tb_categorias_cards.id_categorias', '=', $parametros['categoria'])
                      ->orderBy('tb_categorias_cards.titulo', 'asc')
                      ->paginate($parametros['qtd']);

	    if (isset($parametros['titulo'])) {
            $cards = Cards::join('tb_categorias AS tc','tc.id', '=', 'tb_categorias_cards.id_categorias')
                          ->where('tb_categorias_cards.id_categorias', '=', $parametros['categoria'])
                          ->whereRaw("tb_categorias_cards.titulo like '%".$parametros['titulo']."%'")
                          ->orderBy('tb_categorias_cards.titulo', 'asc')
                          ->paginate($parametros['qtd']);
        }
    
        $resultado = collect($cards)->toArray();

        if (count($resultado['data']) > 0) {
            return $resultado;
        }
        
        return null;
    }

    public function criar($parametros)
    {
        var_dump($parametros);
        $qry = Cards::from($this->table);
        $qry->id_categorias    = array_get($parametros, 'id_categorias', null);
        $qry->titulo           = array_get($parametros, 'titulo', null);
        $qry->sequencial_card  = array_get($parametros, 'sequencial_card', null);
        $qry->id_canais        = array_get($parametros, 'id_canais', null);
        $qry->save();
        $id = $qry->id;
        unset($qry);
        
        $result = [
            'id' =>  $id,
            'id_categorias'   => array_get($parametros, 'id_categorias', null),
            'titulo'          => array_get($parametros, 'titulo', null),
            'sequencial_card' => str_pad($id, 9, '0', STR_PAD_LEFT),
            'id_canais'       => array_get($parametros, 'id_canais', null)
        ];

        return $result;
    }


    public function cardsList($parametros)
    {
        $columns = [
            'tb_categorias_cards.id',
            'tb_categorias_cards.id_categorias',
            'tb_categorias_cards.titulo',
            'tb_categorias_cards.sequencial_card'
        ];

        $page = $parametros['page'];

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $cards = Cards::join('tb_categorias AS tc','tc.id', '=', 'tb_categorias_cards.id_categorias')
                      ->where('tb_categorias_cards.id_categorias', '=', $parametros['categoria'])
                      ->orderBy('tb_categorias_cards.titulo', 'asc')
                      ->paginate($parametros['qtd']);

	    if (isset($parametros['titulo'])) {
            $cards = Cards::join('tb_categorias AS tc','tc.id', '=', 'tb_categorias_cards.id_categorias')
                          ->where('tb_categorias_cards.id_categorias', '=', $parametros['categoria'])
                          ->whereRaw("tb_categorias_cards.titulo like '%".$parametros['titulo']."%'")
                          ->orderBy('tb_categorias_cards.titulo', 'asc')
                          ->paginate($parametros['qtd']);
        }
    
        $resultado = collect($cards)->toArray();
        
        if (count($resultado['data']) > 0) {
            return $resultado;
        }
        
        return null;
    }
}
