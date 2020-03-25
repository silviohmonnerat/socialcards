<!DOCTYPE html>
<html lang="pt-br">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<meta property="fb:app_id"         content="598321220616638" /> 
		<meta property="og:type"           content="article" /> 
		<meta property="og:url"            content="https://www.socialcards.com.br/" /> 
		<meta property="og:title"          content="Social Cards" /> 
		<meta property="og:image"          content="https://www.socialcards.com.br/screenshot.jpg" /> 
		<meta property="og:description"    content="Social Cards, é uma plataforma aonde os usuários interagem em diversas categorias. Mostrando suas reações e também compartilhando essas informações no Facebook." />
		
		<title>@yield('pageTitle') - Social Cards</title> 

		<!-- Bootstrap -->
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,300,700,600" />
		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Josefin+Sans" />
		<link rel="stylesheet" href="./assets/css/lib/normalize.css" />
		<link rel="stylesheet" href="./assets/css/lib/font-awesome.min.css" />
		<link rel="stylesheet" href="./assets/css/lib/animate.min.css" />
		<link rel="stylesheet" href="./assets/css/app.min.css?v=1.0" />
    </head>
    
    <body>
    	<div id="fb-root"></div>

        <div class="App">
			@include('includes.sidebar')
			@include('includes.filtro')