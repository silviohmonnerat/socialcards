<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CandidatosRepository;
use App\Repositories\EleitoresRepository;
use App\Repositories\SegurancaRepository;
use App\Repositories\TwitterRepository;
use App\Repositories\AplicativosRepository;
use App\Repositories\AplicativosCandidatoRepository;


class PluginsController extends BaseController 
{
    protected $Candidato;

    public function __construct( 
        CandidatosRepository $candidato,  
        EleitoresRepository $eleitores, 
        SegurancaRepository $segurancaPublica,
        TwitterRepository $twitter,
        AplicativosRepository $aplicativos,
        AplicativosCandidatoRepository $aplicativoscandidato
    ) 
    {
        $this->Candidato = $candidato;
        $this->Eleitores = $eleitores;
        $this->SegurancaPublica = $segurancaPublica;
        $this->Twitter = $twitter;
        $this->Aplicativos = $aplicativos;
        $this->AplicativosCandidato = $aplicativoscandidato;
    }
    
    public function plugins(Request $request) 
    {

        $parametros = $request->all();


        $resultado = $this->Candidato->getCandidato($parametros); 
        $aplicativos = $this->Aplicativos->getAplicativos($parametros);   
        #dd($parametros,$resultado);
        for($i=0;$i<count($aplicativos);$i++){
            $resultado['aplicativo'] = $aplicativos[$i]['id'];
            $totalRetorno = $this->AplicativosCandidato->aplicativoDoCandidato($resultado);

            $aplicativos[$i]['ativado'] = 0;

            if($totalRetorno > 0)
                $aplicativos[$i]['ativado'] = 1;
        }


        #dd($aplicativos);
        return view('plugin')->with(
            [
                'candidato' => $resultado,
                'aplicativos' => $aplicativos
            ]
        );       
    }  

    public function pluginsAdicionar(Request $request)
    {
        $parametros = $request->all();

        $resultado = $this->Candidato->getCandidato($parametros); 
        #dd($parametros,$resultado);
        $this->AplicativosCandidato->ativar($parametros);
      
        return view('pluginativado')->with(
            [
                'candidato' => $resultado
            ]
        );       
    }

    public function pluginsRetirar(Request $request)
    {
        $parametros = $request->all();

        $resultado = $this->Candidato->getCandidato($parametros); 

        $this->AplicativosCandidato->desativar($parametros);

        return view('plugindesativado')->with(
            [
                'candidato' => $resultado
            ]
        );       
    }
}