<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CandidatosRepository;
use App\Repositories\BoletosRepository;
use App\Repositories\AplicativosCandidatoRepository;

use PagSeguro;

class PagamentosController extends Controller
{
    protected $Candidato,$Boletos,$AplicativosCandidato;

    public function __construct(CandidatosRepository $candidato, BoletosRepository $boletos,
    AplicativosCandidatoRepository $aplicativoscandidato)
  {        
        $this->Candidato = $candidato;
        $this->Boletos = $boletos;
        $this->AplicativosCandidato = $aplicativoscandidato;
     ///
  }

  public function getCredenciais()
  {
      //return $this->_configs->getAccountCredentials();
  }
 
  public function gerarBoleto(Request $request)
  {
      $parametros = $request->all();
      $resultado = $this->Candidato->getCandidato($parametros); 
      #dd($parametros);
      $pagseguro = null;
      $dadosPagamento = null;  


     if(isset($parametros['senderHash'])) {
        try {
            #$hash = PagSeguro::startSession();
            #dd($hash);
            $pagseguro = PagSeguro::setReference('1')
                ->setSenderInfo([
                    'senderName' => $nomeDoCandidato, //Deve conter nome e sobrenome
                    'senderPhone' => null, //Código de área enviado junto com o telefone
                    'senderEmail' => $emailDoCandidato,
                    'senderHash' => $parametros['senderHash'],
                    'senderCPF' => $cpfDoCandidato //Ou CPF se for Pessoa Física
            ])
                ->setShippingAddress([
                    'shippingAddressStreet' => null,
                    'shippingAddressNumber' => null,
                    'shippingAddressDistrict' => null,
                    'shippingAddressPostalCode' => null,
                    'shippingAddressCity' => null,
                    'shippingAddressState' => null
            ])
                ->setItems([
                [
                    'itemId' => $hashDoBoleto,
                    'itemDescription' => 'Pagamento referente ao mês: '.$mes.'/'.$ano,
                    'itemAmount' => $valor, //Valor unitário
                    'itemQuantity' => '1', // Quantidade de itens
                ]
            ])
                ->send([
                'paymentMethod' => 'boleto'
            ]);
        }
        catch(\Artistas\PagSeguro\PagSeguroException $e) {
            $e->getCode(); //codigo do erro
            $e->getMessage(); //mensagem do erro
        }

        $dadosPagamento = xml2array($pagseguro);
        #dd($dadosPagamento,$e);
    }

      return view('boleto')->with(
        [
            'candidato' => $resultado,
            'dadosPagamento' => $dadosPagamento
        ]
        );
        
      #dd($parametros);
      /**
    
        **/
  }

    public function lista(Request $request)
    { 
        $dadosBoleto = null;
        $parametros = $request->all();
        $resultado = $this->Candidato->getCandidato($parametros); 
        $valor_plugins = $this->AplicativosCandidato->calcularPlugins($resultado);  
        #dd($valor_plugins);
        $dados_insert_boleto = [
            'candidato_cpf' => $resultado['candidato_cpf'],
            'data_vencimento'	=> date('Y-m-d H:i:s', strtotime('+10 days', strtotime(date('Y-m-d H:i:s')))),
            'status_boleto' => 1,
            'valor' => 25.00, #$valor_plugins['valor'],	
            'referencia_mes' => $valor_plugins['mes'],
            'referencia_ano' => $valor_plugins['ano']
        ];
        $existeBoleto = $this->Boletos->existeBoletoGerado($dados_insert_boleto);

        $dadosBoleto = [
            'data_vencimento' =>  date('d/m/Y', strtotime($dados_insert_boleto['data_vencimento'])),
            'valor' => number_format($dados_insert_boleto['valor'],2,',','.')
        ];

        #dd($existeBoleto);
        if(!is_array($existeBoleto)) {
            $this->Boletos->cadastrar($dados_insert_boleto);
        }

        return view('pagamentos')->with(
            [
                'candidato' => $resultado,
                'boleto' => $dadosBoleto
            ]
        );       
    }
}
