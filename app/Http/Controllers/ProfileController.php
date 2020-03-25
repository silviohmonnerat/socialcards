<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CardsRepository;
use App\Repositories\SocialRepository;
use App\Repositories\SocialReactRepository;
use App\Repositories\InfluenciadorRepository;


class ProfileController extends BaseController 
{
    protected $Cards;

    public function __construct( 
        CardsRepository $cards,  
        SocialRepository $social,
        SocialReactRepository $socialreact,
        InfluenciadorRepository $influenciador
    ) 
    {
        $this->Cards = $cards;
        $this->Social = $social;
        $this->SocialReact = $socialreact;
        $this->Influenciador = $influenciador;
    }
        
    public function socialCard(Request $request) 
    {
        $parametros = $request->all();
        $resultado = [];
        
        if(!isset($parametros['qtd']) || !isset($parametros['page'])) {
            $parametros['qtd'] = 20;
            $parametros['page'] = 1;
        }

        if(!isset($parametros['categoria'])) {
            $parametros['categoria'] = 2;
        }

        $resultado = $this->Cards->getCards($parametros);

        if (is_array($resultado) && !empty($resultado)) {
            for ($i=0; $i < count($resultado['data']); $i++) {   
        
                $parametros['sequencial_card'] = $resultado['data'][$i]['sequencial_card'];

                $parametros['social_id'] = 'like';
                $resultado['data'][$i]['reacoes']['like'] = $this->SocialReact->qtdReacoes($parametros);

                $parametros['social_id'] = 'love';
                $resultado['data'][$i]['reacoes']['love'] = $this->SocialReact->qtdReacoes($parametros);

                $parametros['social_id'] = 'haha';
                $resultado['data'][$i]['reacoes']['haha'] = $this->SocialReact->qtdReacoes($parametros);

                $parametros['social_id'] = 'wow';
                $resultado['data'][$i]['reacoes']['wow'] = $this->SocialReact->qtdReacoes($parametros);

                $parametros['social_id'] = 'sad';
                $resultado['data'][$i]['reacoes']['sad'] = $this->SocialReact->qtdReacoes($parametros);

                $parametros['social_id'] = 'angry';
                $resultado['data'][$i]['reacoes']['angry'] = $this->SocialReact->qtdReacoes($parametros);
            }
        }
        
        return view('index')->with('resultado', $resultado);     
    }  

    public function loginSocial(Request $request)
    {
        $parametros = $request->all();

            $resultado = $this->Social->login($parametros);

        return response()->json($resultado);
    }

    public function reactSocial(Request $request)
    {
    	$parametros = $request->all();

        $resultado = $this->SocialReact->cadastra($parametros);

	return response()->json($resultado);
    }

    public function updateSocial(Request $request)
    {
        $parametros = $request->all();

            $cep = $this->Social->verificarCep($parametros);

        if(!$cep)
                $resultado = $this->Social->alterar($parametros); 
        
        $resultado = $this->Influenciador->cadastrar($parametros);

        return response()->json($resultado);
    }


    public function verificaCep(Request $request)
    {
        $parametros = $request->all();

            $cep = $this->Social->verificarCep($parametros);

        return response()->json(['sucesso' => $cep]);
    }


    public function verificaInfluenciador(Request $request)
    {
        $parametros = $request->all();

            $influenciador = $this->Influenciador->verificar($parametros);

        return response()->json($influenciador);
    }

    public function verificaReacao(Request $request)
    {
        $parametros = $request->all();

            $reacaoResultado = $this->SocialReact->verificar($parametros);

        return response()->json($reacaoResultado);
    }
    
    public function salvarImagem(Request $request) 
    {
        $parametros = $request->all();
        $parametros = json_decode($parametros['data'], true);

        $pasta = '/var/www/socialcards.com.br/html/public/assets/images/compartilhadas/';

        $img = $parametros['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);

        $data = base64_decode($img);
        $filename = str_replace(' ', '', $parametros['nome']);
        $filename = remover_caracter($filename);
        $filename = $filename.'.png';

        $file = $pasta.$filename;

        if (file_exists($file)) {
            unlink($file);
        }

        file_put_contents($file, $data);

        return response()->json($filename);
    }  
}

