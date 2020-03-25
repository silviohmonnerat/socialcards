<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CardsRepository;
use App\Repositories\CategoriasRepository;
use App\Repositories\SocialReactRepository;


class CardsController extends BaseController
{
    protected $Cards;
    protected $Categorias;

    public function __construct( 
        CardsRepository $cards,
        SocialReactRepository $socialreact,
        CategoriasRepository $categorias
    ) 
    {
        $this->Cards = $cards;
        $this->SocialReact = $socialreact;
        $this->Categorias = $categorias;
    }

    public function cardsList(Request $request) 
    {
        $parametros = $request->all();

        if(!isset($parametros['qtd']) || !isset($parametros['page'])) {
            $parametros['qtd'] = 20;
            $parametros['page'] = 1;
        }

        if(!isset($parametros['categoria'])) {
            $parametros['categoria'] = 2;
        }

        $resultado = $this->Cards->cardsList($parametros);
        if (is_array($resultado) && !empty($resultado)) {
            for ($i=0; $i < count($resultado['data']); $i++) {   
        
                $parametros['sequencial_card'] = $resultado['data'][$i]['sequencial_card'];

                $parametros['social_id'] = 'like';
                $resultado['data'][$i]['reacoes'][] = [ 
                    'name' => 'like',
                    'value' => $this->SocialReact->qtdReacoes($parametros)
                ];

                $parametros['social_id'] = 'love';
                $resultado['data'][$i]['reacoes'][] = [ 
                    'name' => 'love',
                    'value' => $this->SocialReact->qtdReacoes($parametros)
                ];

                $parametros['social_id'] = 'haha';
                $resultado['data'][$i]['reacoes'][] = [ 
                    'name' => 'haha',
                    'value' => $this->SocialReact->qtdReacoes($parametros)
                ];

                $parametros['social_id'] = 'wow';
                $resultado['data'][$i]['reacoes'][] = [ 
                    'name' => 'wow',
                    'value' => $this->SocialReact->qtdReacoes($parametros)
                ];

                $parametros['social_id'] = 'sad';
                $resultado['data'][$i]['reacoes'][] = [ 
                    'name' => 'sad',
                    'value' => $this->SocialReact->qtdReacoes($parametros)
                ];

                $parametros['social_id'] = 'angry';
                $resultado['data'][$i]['reacoes'][] = [ 
                    'name' => 'angry',
                    'value' => $this->SocialReact->qtdReacoes($parametros)
                ];
            }
        }

        return response()->json($resultado);
    }
        
    public function criar(Request $request) 
    {
        $parametros = $request->all();
        var_dump($parametros);

        $response = $this->Cards->criar($parametros);
        var_dump($response);
        
        $resultado = [
            'success' => true,
            'title'   => 'Sucesso!',
            'message' => 'Card criado com sucesso.',
            'data'    => [
                'id_categorias'   => $response['id_categorias'],
                'titulo'          => $response['titulo'],
                'sequencial_card' => $response['sequencial_card'],
                'id_canais'       => $response['id_canais']
            ]
        ];

        return response()->json($resultado);
    }

    public function salvarImagem(Request $request) 
    {
        $parametros = $request->all();

        $category = $this->Categorias->getCategory($parametros);

        $slug = 'geral';
        if (is_array($category) && !empty($category)) {
            $slug = $category['slug'];
        }

        $resultado['success'] = false;
        if($request->hasFile('cardimage')) {
            $file = $request->file('cardimage');

            //you also need to keep file extension as well
            $name = $parametros['sequencial_card'].'.'.$file->getClientOriginalExtension();

            //using the array instead of object
            $file->move(public_path()."/assets/images/cards/{$slug}", $name);
            $filepath = public_path()."/assets/images/cards/{$slug}". $name;

            file_put_contents($filepath, $name);

            $resultado['success'] = true;
        }

        return response()->json($resultado);
    } 
}

