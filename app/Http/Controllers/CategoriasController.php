<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoriasRepository;


class CategoriasController extends BaseController
{
    protected $Categorias;

    public function __construct( 
        CategoriasRepository $categorias
    ) 
    {
        $this->Categorias = $categorias;
    }
        
    public function listar() 
    {
        $response = $this->Categorias->listar();
        
        $resultado = [
            'success' => true,
            'total'   => count($response),
            'data'    => $response
        ];

        return response()->json($resultado);
    } 

    public function getCategory(Request $request) 
    {
        $parametros = $request->all();
        $response = $this->Categorias->getCategory($parametros);
        
        $resultado = [
            'success' => true,
            'total'   => count($response),
            'data'    => $response
        ];

        return response()->json($resultado);
    } 
}

