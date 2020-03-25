@extends('layouts.master')

@section('pageTitle', 'Criar seu próprio Card')

@section('content')  

	<section class="App-body">
        <div class="App-body_container">
            <div class="App-body_head">
                <h1 class="App-body_title">Crie seu Card</h1> 
            </div>

            <div class="App-entry">
                <form action="/" method="post" name="formCriarCard" class="formCriarCard" id="formCriarCard" enctype="multipart/form-data">
                    <div class="group-form">
                        <label for="">Nome do Card (*)</label>
                        <input type="text" name="titulo" id="cardname" required />
                    </div>
                    <div class="group-form">
                        <label for="">Modalidade (*)</label>
                        <select name="id_categorias" id="cardcategory" required></select>
                    </div>
                    <div class="group-form">
                        <label for="">Adicionar url</label>
                        <input type="url" name="cardurl" id="cardurl" placeholder="" />
                    </div>
                    <div class="group-form">
                        <label for="">Adicionar Imagem (*)</label>
                        <input type="file" name="cardimage" id="cardimage" required />
                    </div>
                    
                    <input type="submit" id="cardsubmit" value="Criar" />
                </form>
            </div>
        </div>
	</section>
@stop