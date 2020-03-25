<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PagSeguro;

class PagseguroControlle extends Controller
{
    public function __construct()
  {
     ///
  }

  public function getCredenciais()
  {
      //return $this->_configs->getAccountCredentials();
  }
 
  public function gerarBoleto()
  {
    $pagseguro = null;
        try {
            #$hash = PagSeguro::startSession();
            dd($hash);
            $pagseguro = PagSeguro::setReference('2')
                ->setSenderInfo([
                    'senderName' => 'Nome Completo', //Deve conter nome e sobrenome
                    'senderPhone' => '(32) 1324-1421', //Código de área enviado junto com o telefone
                    'senderEmail' => 'email@email.com',
                    'senderHash' => "'".$hash."'",
                    'senderCNPJ' => '98.966.488/0001-00' //Ou CPF se for Pessoa Física
            ])
                ->setShippingAddress([
                    'shippingAddressStreet' => 'Rua/Avenida',
                    'shippingAddressNumber' => 'Número',
                    'shippingAddressDistrict' => 'Bairro',
                    'shippingAddressPostalCode' => '12345-678',
                    'shippingAddressCity' => 'Duque de Caxias',
                    'shippingAddressState' => 'RJ'
            ])
                ->setItems([
                [
                    'itemId' => 'ID',
                    'itemDescription' => 'Nome do Item',
                    'itemAmount' => 12.14, //Valor unitário
                    'itemQuantity' => '2', // Quantidade de itens
                ],
                [
                    'itemId' => 'ID 2',
                    'itemDescription' => 'Nome do Item 2',
                    'itemAmount' => 12.14,
                    'itemQuantity' => '2',
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

        dd($pagseguro,$e);
  }
}
