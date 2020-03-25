@extends('layouts.master')

@section('pageTitle', 'Sobre')

@section('content')

    <section class="App-pagename">
        <div class="App-container">
            <h1 class="App-pagename_title">Contato</h1>
        </div>
    </section>   

    <section class="App-contact">
        <div class="App-container">
            <div class="App-content">
                <form action="/enviar" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome">
                    </div>
                    <div class="form-group">
                        <label for="email">E-Mail</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="E-Mail">
                    </div>
                    <div class="form-group">
                        <textarea id="mensagem" name="mensagem" class="form-control" placeholder="Digite sua mensagem"></textarea>
                    </div>
                    <input type="submit" class="btn btn-default" value="Enviar" />
                </form>
            </div>
        </div>
    </section>

@stop