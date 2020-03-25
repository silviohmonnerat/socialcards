@extends('layouts.master')

@section('pageTitle', $resultado['data'][0]['categoria'])

@section('content')
	<section class="App-cards">
		@for ($i = 0; $i < count($resultado['data']); $i++)
			<article class="Card" 
					 id="Card-{{$resultado['data'][$i]['sequencial_card']}}" 
					 data-sequencial="{{$resultado['data'][$i]['sequencial_card']}}"
					 data-titulo="{{$resultado['data'][$i]['titulo']}}"
					 data-categoria="{{$resultado['data'][$i]['categoria']}}"
					 data-cat="1">
				<header class="Card--header">
					<div class="Card--inner">
						<div class="Card--figure">
							<!--<img src="{{'./assets/images/cards/'.$resultado['data'][$i]['slug'].'/logo-big-brother-brasil-logo.png'}}" 
								 alt="{{$resultado['data'][$i]['categoria']}}" />-->
							{{$resultado['data'][$i]['categoria']}}
						</div>
						<div class="Card--action">
							<a href="javascript:void(0);" 
							   class="Card--action-item button-text" 
							   data-target="compartilhar"
							   data-toggle="tooltip" 
							   data-placement="top" 
							   title="Compartilhar">Compartilhar</a>
						</div>
					</div>					
				</header>
				<div class="Card--body">
					<div class="Card--thumbnail">
						@if(file_exists("./assets/images/cards/".$resultado['data'][$i]['slug']."/".$resultado['data'][$i]['sequencial_card'].".jpg"))
							<img src="{{'./assets/images/cards/'.$resultado['data'][$i]['slug'].'/'.$resultado['data'][$i]['sequencial_card']}}.jpg" 
								 alt="{{$resultado['data'][$i]['titulo']}}" />
						@else
							<img src="./assets/images/user-placeholder.png" 
								 alt="{{$resultado['data'][$i]['titulo']}}" />
						@endif

						<h4 class="Card--name">{{$resultado['data'][$i]['titulo']}}</h4>
					</div>
				</div>
				<footer class="Card--footer">
					<a href="javascript:void(0);" data-target="reagir" data-react="like" class="Card--footer-item">
						<i class="reaction like"></i><span>{{$resultado['data'][$i]['reacoes']['like']}}</span>
					</a>
					<a href="javascript:void(0);" data-target="reagir" data-react="love" class="Card--footer-item">
						<i class="reaction love"></i><span>{{$resultado['data'][$i]['reacoes']['love']}}</span>
					</a>
					<a href="javascript:void(0);" data-target="reagir" data-react="haha" class="Card--footer-item">
						<i class="reaction haha"></i><span>{{$resultado['data'][$i]['reacoes']['haha']}}</span>
					</a>
					<a href="javascript:void(0);" data-target="reagir" data-react="wow" class="Card--footer-item">
						<i class="reaction wow"></i><span>{{$resultado['data'][$i]['reacoes']['wow']}}</span>
					</a>
					<a href="javascript:void(0);" data-target="reagir" data-react="sad" class="Card--footer-item">
						<i class="reaction sad"></i><span>{{$resultado['data'][$i]['reacoes']['sad']}}</span>
					</a>
					<a href="javascript:void(0);" data-target="reagir" data-react="angry" class="Card--footer-item">
						<i class="reaction angry"></i><span>{{$resultado['data'][$i]['reacoes']['angry']}}</span>
					</a>
				</footer>
			</article>
		@endfor
	</section>

@stop