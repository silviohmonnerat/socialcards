<?php
function in_multiarray($elem, $array)
{
    for($i=0;$i<=count($array)-1;$i++)
    {
        if(is_array($array[$i]))
            if(in_array($elem, $array[$i]))
                return true;
    }   
    return false;
}

function removeAcentos($string, $slug = '-') 
{
    $codificacao = mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1');
    
    switch ($codificacao) {
      case 'ISO-8859-1':
        $string = utf8_encode($string);
      break;
    }    
    
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = strtolower($string);
    
    // Código ASCII das vogais
    $ascii['a'] = range(224, 230);
    $ascii['e'] = range(232, 235);
    $ascii['i'] = range(236, 239);
    $ascii['o'] = array_merge(range(242, 246), array(240, 248));
    $ascii['u'] = range(249, 252);
    
    // Código ASCII dos outros caracteres
    $ascii['b'] = array(223);
    $ascii['c'] = array(231);
    $ascii['d'] = array(208);
    $ascii['n'] = array(241);
    $ascii['y'] = array(253, 255);
    
    foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
    }
    
    $string = preg_replace(array_values($troca), array_keys($troca), $string);
    
    #$slug = '-';
    if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
    }
   
   return $string;
}

function tratar_saida($string)
{
    return utf8_decode($string);
}

function http_user_agent()
{
    if( isset( $_SERVER['HTTP_USER_AGENT'])){
        $iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
        $ipad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
        $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
        $palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
        $berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
        $ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
        $symbian =  strpos($_SERVER['HTTP_USER_AGENT'],"Symbian");
        $dispositivo = NULL;
        if ($iphone)
            $dispositivo = 'iPhone';
        if ($ipad)
            $dispositivo = 'iPad';
        if ($android)
            $dispositivo = 'Android';
        if ($palmpre)
            $dispositivo = 'webOS';
        if ($ipod)
            $dispositivo = 'iPod';
        if ($berry)
            $dispositivo = 'BlackBerry';
        if ($symbian)
            $dispositivo = 'Symbian';
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $ub = "";
        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'Linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'Mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'Windows';
        }
        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/AppleWebKit/i',$u_agent))
        {
            $bname = 'AppleWebKit';
            $ub = "Opera";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
        }
        $i = count($matches['browser']);
        if ($i != 1) {
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                if(count($matches['version'])>0)
                    $version= $matches['version'][1];
            }
        }
        else {
            if(count($matches['version'])>0)
                $version= $matches['version'][0];
        }
        if ($version==null || $version=="") {$version="?";}
        $Browser = array(
                'userAgent' => $u_agent,
                'name'      => $bname,
                'version'   => $version,
                'platform'  => $platform,
                'pattern'    => $pattern
        );
        $navegador = $Browser['name'] . " " . $Browser['version'];
        $so = $Browser['platform'];
    } else {
        $navegador = 'PhpUnit';
        $so = NULL;
        $ip = NULL;
        $dispositivo = NULL;
    }
    $dados = ['navegador' => $navegador, 'so' => $so, 'ip' => $ip, 'dispositivo' => $dispositivo];
    
    return $dados;    
}

function shorten($token)
{
    return sha1($token);
}

function intervalDate($datetime)
{
    $inicio = substr($datetime,11);
	$fim = new \DateTime();
	$inicio = new \DateTime($datetime);
	$intervalo = $inicio->diff($fim);
	return $intervalo->format('%H:%I:%S');
}

function segundoEmDateTime($segundos)
{
    return gmdate("H:i:s", $segundos);
}

function file_get_contents_utf8($fn) 
{
    $fn = mb_convert_encoding($fn, 'UTF-8', mb_detect_encoding($fn, 'UTF-8, ISO-8859-1', true));
    $content = file_get_contents(htmlspecialchars_decode($fn), false);
    return $content;
}

function injection($request)
{
    $input = $request->all();
    array_walk_recursive($input, function(&$input) {
         $input = strip_tags($input);
    });
    $request->merge($input);
    return $request;
}

function DateConverter($date, $locale = null) 
{    
    if (is_null($date))
        return null;
  
    if(is_null($locale)){
        if(strpos($date, '/')!==false){
            $data = explode('/', $date);
            $date = $data[2].'-'.$data[1].'-'.$data[0];
        }
    }
    
    $date = explode(" ", $date); 
    switch($locale){
        case 'br':
            $date = explode("-", $date[0]);                        
            $data = $date[2] . "/" . $date[1] . "/" . $date[0];
            break;
        case 'us':
            $data = explode('/', $date[0]);
            $data = $data[2].'-'.$data[1].'-'.$data[0]. ' '.date('H:i:s');
            break;
        default:
            $data = $date[0];
            break;
    }

    return $data;
}

function is_param($params, $importants=array())
{
    $result = [];
    $arr = [];
    
    foreach ($importants as $key=>$item) {
        if(isset($params[$key])){
            if(is_array($params[$key])){
                
                if(count($params[$key])==0){
                    $arr[$key] = $item;  
                }
                continue;
            }
        }
        
        if( !isset( $params[$key] ) || $params[$key] == null || trim($params[$key]) === "" ) 
            $arr[$key] = $item;
    }
    
    foreach($arr as $v => $k){
        if($arr[$v]) {
            $result[] = $k;
        }
    }
    
    return $result;
}

function MascaraTelefone($param, $ddd=true)
{
    if(empty($param)) { return null; }
    
    if($ddd){
       $ddd=substr($param,0,2);       
       $telefone=substr($param,2);  
    } else 
        $telefone = $param;
    if(strlen($telefone)===9){
        $telPart1=substr($telefone,0,5);
        $telPart2=substr($telefone,5);
    } elseif(strlen($telefone)>9) { 
        $ddd=substr($telefone,0,2);
        $telPart1=substr($telefone,2,4);
        $telPart2=substr($telefone,5,4);							
    } else {
        $telPart1=substr($telefone,0,4);
        $telPart2=substr($telefone,4);							
    }
    if($ddd)
        return '('.$ddd.') '.$telPart1.'-'.$telPart2;    
    else {
        if(!empty($telPart1) && !is_null($telPart1))
            return $telPart1.'-'.$telPart2;
        else 
            return null;
    }
 }

function ValidaTelefone($tel) 
{
    if(preg_match('/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/', $tel)) {
        return true;
    }
    else {
        return false;
    }
 }

function ValidaEmail($email)
{
    if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
        $dados = explode('@',$email);
        
        if(!checkdnsrr($dados[1],'MX')) {
            return false;
        }
        return true;
    }
    return false;
}

function  ValidaCpfCnpj($cpfcnpj='') 
{
      if(trim($cpfcnpj)<> '') {
         $cpfcnpj=str_replace(".","",$cpfcnpj);
         $cpfcnpj=str_replace("-","",$cpfcnpj);
         $cpfcnpj=str_replace("/","",$cpfcnpj);
                
         if(!is_numeric($cpfcnpj) || $cpfcnpj=='0'){
            return false;
         } else {
            if (strlen($cpfcnpj)<=11){ // CPF
               if(ValidaCPF($cpfcnpj)){
                   return true;
               } else {
                   return false;
               }
            }else { //CNPJ
               if(ValidaCNPJ($cpfcnpj)){
                   return true;
               } else {
                   return false;
               }
            }                    
         }
     } else return false;
}

function ValidaCPF($cpf = null) 
{ 
    if(empty($cpf)) {
        return false;
    }
    $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
    
    if (strlen($cpf) != 11) {
        return false;
    }

    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
        return false;

    } else {   
         
        for ($t = 9; $t < 11; $t++) {
             
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf{$c} != $d) {
                return false;
            }
        }
 
        return true;
    }
}

function ValidaCNPJ($cnpj) 
{
    $invalidos = [
	    '00000000000000',
	    '11111111111111',
	    '22222222222222',
	    '33333333333333',
	    '44444444444444',
	    '55555555555555',
	    '66666666666666',
	    '77777777777777',
	    '88888888888888',
	    '99999999999999'
    ];

    if (in_array($cnpj, $invalidos)) {	
	    return false;
    }

    if (strlen($cnpj) != 14)
		return false;

    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;

	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
    
	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}

function ValidaData($data)
{
    // data é menor que 8
    if ( strlen($data) < 8){
        return false;
    }else{
        // verifica se a data possui
        // a barra (/) de separação
        if(strpos($data, "/") !== FALSE){
            //
            $partes = explode("/", $data);
            // pega o dia da data
            $dia = $partes[0];
            // pega o mês da data
            $mes = $partes[1];
            // prevenindo Notice: Undefined offset: 2
            // caso informe data com uma única barra (/)
            $ano = isset($partes[2]) ? $partes[2] : 0;
 
            if (strlen($ano) < 4) {
                return false;
            } else {
                // verifica se a data é válida
                if (checkdate($mes, $dia, $ano)) {
                     return true;
                } else {
                     return false;
                }
            }
        }else{
            return false;
        }
    }
}
function ValidaCelular($telefone){
    $telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));
    if (preg_match('/(\(?\d{2}\)?) ?9?\d{4}-?\d{4}/', $telefone)) {
        return true;
    } else {
        return false;
    }
}
function retirarMascara($campo){
    $campo=str_replace(" ","",$campo);
    $campo=str_replace(".","",$campo);
    $campo=str_replace("-","",$campo);
    $campo=str_replace("/","",$campo);
    $campo=str_replace("(","",$campo);
    $campo=str_replace(")","",$campo);
    return $campo;
}
function verificarDataMaior($data1, $data2) {
    if (strtotime($data1) > strtotime($data2)) {
        return true;
    }
}
function BooleanToInt($args,$key){
    if(isset($args[$key])){
        if(!empty($args[$key])){
            if($args[$key]==true && $args[$key]=='true'){
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}
function IntToBoolean($args,$key){
    if(isset($args[$key])){
        if(!empty($args[$key])){
            if($args[$key]==1 && $args[$key]=='1'){
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function va_sql($arrValores,$strNomeVar,$default=NULL,$string=true,$limpaslashes=true){
    $Result = array_get($arrValores, $strNomeVar);  # Valor padrão, se nada for feito (em caso do valor ser numerico)
	$arrValores=array_change_key_case($arrValores,CASE_UPPER);
	$strNomeVar=strtoupper($strNomeVar);
    if(!isset($arrValores[$strNomeVar]) || is_null($arrValores[$strNomeVar]) || empty($arrValores[$strNomeVar])){    
        return $default;
	}else{
		if ($string) {
			if ($limpaslashes){
                # Se for a palavra "null" (como por exemplo vindo do mongoDB), converte para o tipo null
                if($arrValores[$strNomeVar] == 'NULL'){     
                    $arrValores[$strNomeVar] = null;
                }
                if($arrValores[$strNomeVar]!=='NULL'){  		
                        $encoding = mb_detect_encoding($arrValores[$strNomeVar], array('UTF-8', 'Windows-1252', 'ISO-8859-1'), true);
                        
                        if ($encoding == 'ISO-8859-1' || $encoding == 'Windows-1252') {
                            $Result = iconv('Windows-1252', 'UTF-8//TRANSLIT', $arrValores[$strNomeVar]);
                        }
				    #$Result=utf8_decode(trim($arrValores[$strNomeVar]));
                } else {
                    $Result=trim($arrValores[$strNomeVar]);
                }
			}else{
				$Result=trim($arrValores[$strNomeVar]);
			}
		}else{
			if (strtoupper($arrValores[$strNomeVar])=='TRUE' || strtoupper($arrValores[$strNomeVar])=='FALSE'){
				$Result=(strtoupper($arrValores[$strNomeVar])=='TRUE')?true:0;
			}else if (strpos($arrValores[$strNomeVar],',')===false){
				$Result=trim($arrValores[$strNomeVar]);
			}else{
				$tmp=trim($arrValores[$strNomeVar]);
				#Se numero for float trocar virgula por ponto retirando
				#o separador de milhar tb para ser compativel com sqlserver
				$tmp=str_replace(".", "", $tmp);
				$tmp=str_replace(",", ".", $tmp);
				$Result=$tmp;
				
			}
		}
		return $Result;
	}
}
function mssql_LimpaSlashes($valor){
	$valor = stripslashes($valor);
	$valor = str_replace("'","''",$valor);
	$valor = str_replace("\\","",$valor);
	return $valor;
}
function quebraTelefone($campo){
    $campo=str_replace(" ","",$campo);
    $campo=str_replace(".","",$campo);
    $campo=str_replace("-","",$campo);
    $campo=str_replace("/","",$campo);
    $campo=str_replace("(","",$campo);
    $campo=str_replace(")","",$campo);
    $ddd=substr($campo,0,2);
    $numero=substr($campo,2, strlen($campo)-2);
    
    return ['ddd'=>$ddd,'telefone'=>$numero];
}

function array_msort($array, $cols) {
    $colarr = array();
    foreach ($cols as $col => $order) {
        $colarr[$col] = array();
        foreach ($array as $k => $row) { 
            #if(is_null($row[$col])) return $array;
            if(isset($row[$col]))
                $colarr[$col]['_'.$k] = strtolower($row[$col]); 
        }
    }
    $eval = 'array_multisort(';
    foreach ($cols as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    $p=0;
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array[$k];
            $ret[$k][$col] = $array[$k][$col];
        }
    }
    $newArr = [];
    foreach ($ret as $col => $arr){ 
        $newArr[$p] = $arr;
        $p++;
    }
    
    return $newArr;
}
function dinheiro_to_decimal($decimal){
    $decimal = str_replace(array('.'), '', $decimal);
    return str_replace(array(','), '.', $decimal);
}
function decimal_to_dinheiro($decimal){
    $decimal = number_format($decimal, 2, ',', '.');
     return $decimal;//str_replace(array('.'), ',', $decimal);
}
function decimal_to_dinheiro_2($decimal){
    $decimal = preg_replace('/[R$]*/', '', $decimal);    
    $decimal = dinheiro_to_decimal(trim($decimal));
    $decimal = number_format($decimal, 2, ',', '.');
    return $decimal;
}
/* converte data dd/mm-YYYY para YYYY-mm-dd ou vice-versa */
function converterData($data){
    if(str_contains($data, '-')){
        $data             = explode('-', $data);
        $data             = $data[2] .'/' . $data[1] . '/' . $data[0];
        return $data;
    }else{
        $data             = explode('/', $data);
        $data             = $data[2] .'-' . $data[1] . '-' . $data[0];
        return $data;
    }
}

function tratar_insert($value){
    if (is_string($value)) {					
        $encoding = mb_detect_encoding($value, array('UTF-8', 'Windows-1252', 'ISO-8859-1'), true);
        
        if ($encoding == 'ISO-8859-1' || $encoding == 'Windows-1252') {
            $value = iconv('Windows-1252', 'UTF-8//TRANSLIT', $value);
        }
    }
    return $value;
}
function arrRemoverRepetidos($array, $campo = 'uid'){
    $ids = array_column($array, $campo);
    $ids = array_unique($ids);
    $array = array_filter($array, function ($key, $value) use ($ids) {
        return in_array($value, array_keys($ids));
    }, ARRAY_FILTER_USE_BOTH);
    return $array;
}


function xml_convert($string) { 
    $string = (string) $string;
    $string = trim($string);
    $string = addslashes($string);
    $string = strip_tags($string);
    return $string;
} // convert
#############################################
# FIM FUNÇÕES DE LEITURA DO XML - 21/10/2017#
#############################################
function calcula_resto_hora($entrada,$saida,$intervalo){
    $hora1 = explode(":",$entrada);
    $hora2 = explode(":",$saida);
    
    $acumulador1 = ($hora1[0] * 3600) + ($hora1[1] * 60) + $hora1[2];
    $acumulador2 = ($hora2[0] * 3600) + ($hora2[1] * 60) + $hora2[2];
    
    $resultado = $acumulador2 - $acumulador1;
    
    $hora_ponto = floor($resultado / 3600);
    
    $resultado = $resultado - ($hora_ponto * 3600);
    
    $min_ponto = floor($resultado / 60);
    $resultado = $resultado - ($min_ponto * 60);
    $secs_ponto = $resultado;
        
    $tempo = $hora_ponto.":".$min_ponto.":".$secs_ponto;
    
    $hora_inteira = explode(":",$tempo);
    $hora_inteira = (($hora_inteira[0]*3600)*60);
    #dd(__LINE__,__METHOD__,$hora1,$hora2,$acumulador1,$acumulador2,$resultado,$hora_ponto,$tempo,$hora_inteira,$intervalo);
    if($hora_inteira<$intervalo)
        return false;
    else
        return true;
}
function limita_caracteres($texto, $limite, $quebra = true) {
    $tamanho = strlen($texto);
    if ($tamanho <= $limite) { //Verifica se o tamanho do texto é menor ou igual ao limite
        $novo_texto = $texto;
    } else { // Se o tamanho do texto for maior que o limite
        if ($quebra == true) { // Verifica a opção de quebrar o texto
            $novo_texto = trim(substr($texto, 0, $limite)) . "...";
        } else { // Se não, corta $texto na última palavra antes do limite
            $ultimo_espaco = strrpos(substr($texto, 0, $limite), " "); // Localiza o útlimo espaço antes de $limite
            $novo_texto = trim(substr($texto, 0, $ultimo_espaco)) . "..."; // Corta o $texto até a posição localizada
        }
    }
    return $novo_texto; // Retorna o valor formatado
}
function checkAcento($string) {
    $regex = "[\"áàâãäªéèêëíìîïóòôõöºúùûüçñ'~^´`\/]+";
    return (bool) preg_match("/" . $regex . "/i", $string);
}
function checkString($string,$texto) {
    return strstr($texto, $string);
}
function buscaLongitudeLatitude($endereco) {
    $endereco = strtolower( preg_replace("[^A-Za-z0-9]", "", strtr(utf8_decode(trim($endereco)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ "), "aaaaeeiooouuncAAAAEEIOOOUUNC+")) );
    $endereco = preg_replace( "/\\s+/" , "+" , $endereco );
    $endereco = preg_replace( "/,/" , "" , $endereco );
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$endereco.'&sensor=false');
    $output= json_decode($geocode);
    if(count($output->results) > 0) {
        $latitude  = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        return ['latitude' => $latitude, 'longitude' => $longitude];
    } else { 
        # quando o resultado de latitude e longitude é zero, retorna informações da BaseSoft como padrão
        return ['latitude' => '-22.9043793', 'longitude' => '-43.1797733'];
    }
} // buscaLongitudeLatitude
// Funcao de validacao de arquivo
function valida_type_arq ($arq , $type_valido){
    $type_arq = explode (".",$arq);
    if (in_array(end($type_arq), $type_valido)){
        return true;
    } else {
        return false;
    }
}
function tamanho_arquivo($arquivo) {
    $tamanhoarquivo = \filesize($arquivo);
 
    /* Medidas */
    $medidas = array('KB', 'MB', 'GB', 'TB');
 
    /* Se for menor que 1KB arredonda para 1KB */
    if($tamanhoarquivo < 999){
        $tamanhoarquivo = 1000;
    }
 
    for ($i = 0; $tamanhoarquivo > 999; $i++){
        $tamanhoarquivo /= 1024;
    }
 
    return round($tamanhoarquivo) . $medidas[$i - 1];
}
function convert_bytes( $size_in_bytes, $precision = 2, $i = 0 ) {
	$notation = [ '', 'K', 'M', 'G', 'T', 'P', 'E', 'Z', 'Y' ];
	return ( $size_in_bytes < 1024 ) ? \sprintf('%.'.$precision.'f%s',$size_in_bytes, $notation[$i] . 'B') : convert_bytes( $size_in_bytes / 1024 , $precision , ++$i );
}
function find_filesize($file){
    if(\substr(PHP_OS, 0, 3) == "WIN") {
        \exec('for %I in ("'.$file.'") do @echo %~zI', $output);
        $return = $output[0];
    } else {
        $return = \filesize($file);
    }
    return $return;
}    
function find_extensao($extensao){
    $types = [
        'ai'      => 'application/postscript',
        'aif'     => 'audio/x-aiff',
        'aifc'    => 'audio/x-aiff',
        'aiff'    => 'audio/x-aiff',
        'asc'     => 'text/plain',
        'atom'    => 'application/atom+xml',
        'atom'    => 'application/atom+xml',
        'au'      => 'audio/basic',
        'avi'     => 'video/x-msvideo',
        'bcpio'   => 'application/x-bcpio',
        'bin'     => 'application/octet-stream',
        'bmp'     => 'image/bmp',
        'cdf'     => 'application/x-netcdf',
        'cgm'     => 'image/cgm',
        'class'   => 'application/octet-stream',
        'cpio'    => 'application/x-cpio',
        'cpt'     => 'application/mac-compactpro',
        'csh'     => 'application/x-csh',
        'css'     => 'text/css',
        'csv'     => 'text/csv',
        'dcr'     => 'application/x-director',
        'dir'     => 'application/x-director',
        'djv'     => 'image/vnd.djvu',
        'djvu'    => 'image/vnd.djvu',
        'dll'     => 'application/octet-stream',
        'dmg'     => 'application/octet-stream',
        'dms'     => 'application/octet-stream',
        'doc'     => 'application/msword',
        'dot'     => 'application/msword',
        'docx'    => 'application/vnd.openxmlformats',
        'dotx'    => 'application/vnd.openxmlformats',
        'docm'    => 'application/vnd.ms-word.document.macroEnabled.12',
        'dotm'    => 'application/vnd.ms-word.template.macroEnabled.12',
        'dtd'     => 'application/xml-dtd',
        'dvi'     => 'application/x-dvi',
        'dxr'     => 'application/x-director',
        'eps'     => 'application/postscript',
        'etx'     => 'text/x-setext',
        'exe'     => 'application/octet-stream',
        'ez'      => 'application/andrew-inset',
        'gif'     => 'image/gif',
        'gram'    => 'application/srgs',
        'grxml'   => 'application/srgs+xml',
        'gtar'    => 'application/x-gtar',
        'hdf'     => 'application/x-hdf',
        'hqx'     => 'application/mac-binhex40',
        'htm'     => 'text/html',
        'html'    => 'text/html',
        'ice'     => 'x-conference/x-cooltalk',
        'ico'     => 'image/x-icon',
        'ics'     => 'text/calendar',
        'ief'     => 'image/ief',
        'ifb'     => 'text/calendar',
        'iges'    => 'model/iges',
        'igs'     => 'model/iges',
        'jpe'     => 'image/jpeg',
        'jpeg'    => 'image/jpeg',
        'jpg'     => 'image/jpeg',
        'js'      => 'application/x-javascript',
        'json'    => 'application/json',
        'kar'     => 'audio/midi',
        'latex'   => 'application/x-latex',
        'lha'     => 'application/octet-stream',
        'lzh'     => 'application/octet-stream',
        'm3u'     => 'audio/x-mpegurl',
        'man'     => 'application/x-troff-man',
        'mathml'  => 'application/mathml+xml',
        'me'      => 'application/x-troff-me',
        'mesh'    => 'model/mesh',
        'mid'     => 'audio/midi',
        'midi'    => 'audio/midi',
        'mif'     => 'application/vnd.mif',
        'mov'     => 'video/quicktime',
        'movie'   => 'video/x-sgi-movie',
        'mp2'     => 'audio/mpeg',
        'mp3'     => 'audio/mpeg',
        'mpe'     => 'video/mpeg',
        'mpeg'    => 'video/mpeg',
        'mpg'     => 'video/mpeg',
        'mpga'    => 'audio/mpeg',
        'ms'      => 'application/x-troff-ms',
        'msh'     => 'model/mesh',
        'mxu'     => 'video/vnd.mpegurl',
        'nc'      => 'application/x-netcdf',
        'oda'     => 'application/oda',
        'ogg'     => 'application/ogg',
        'pbm'     => 'image/x-portable-bitmap',
        'pdb'     => 'chemical/x-pdb',
        'pdf'     => 'application/pdf',
        'pgm'     => 'image/x-portable-graymap',
        'pgn'     => 'application/x-chess-pgn',
        'png'     => 'image/png',
        'pnm'     => 'image/x-portable-anymap',
        'ppm'     => 'image/x-portable-pixmap',
        'ppt'     => 'application/vnd.ms-powerpoint',
        'pot'     => 'application/vnd.ms-powerpoint',
        'pps'     => 'application/vnd.ms-powerpoint',
        'ppa'     => 'application/vnd.ms-powerpoint',
        'pptx'    => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'potx'    => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx'    => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'ppam'    => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'pptm'    => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'potm'    => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'ppsm'    => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'ps'      => 'application/postscript',
        'qt'      => 'video/quicktime',
        'ra'      => 'audio/x-pn-realaudio',
        'ram'     => 'audio/x-pn-realaudio',
        'ras'     => 'image/x-cmu-raster',
        'rdf'     => 'application/rdf+xml',
        'rgb'     => 'image/x-rgb',
        'rm'      => 'application/vnd.rn-realmedia',
        'roff'    => 'application/x-troff',
        'rss'     => 'application/rss+xml',
        'rtf'     => 'text/rtf',
        'rtx'     => 'text/richtext',
        'sgm'     => 'text/sgml',
        'sgml'    => 'text/sgml',
        'sh'      => 'application/x-sh',
        'shar'    => 'application/x-shar',
        'silo'    => 'model/mesh',
        'sit'     => 'application/x-stuffit',
        'skd'     => 'application/x-koan',
        'skm'     => 'application/x-koan',
        'skp'     => 'application/x-koan',
        'skt'     => 'application/x-koan',
        'smi'     => 'application/smil',
        'smil'    => 'application/smil',
        'snd'     => 'audio/basic',
        'so'      => 'application/octet-stream',
        'spl'     => 'application/x-futuresplash',
        'src'     => 'application/x-wais-source',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc'  => 'application/x-sv4crc',
        'svg'     => 'image/svg+xml',
        'svgz'    => 'image/svg+xml',
        'swf'     => 'application/x-shockwave-flash',
        't'       => 'application/x-troff',
        'tar'     => 'application/x-tar',
        'tcl'     => 'application/x-tcl',
        'tex'     => 'application/x-tex',
        'texi'    => 'application/x-texinfo',
        'texinfo' => 'application/x-texinfo',
        'tif'     => 'image/tiff',
        'tiff'    => 'image/tiff',
        'tr'      => 'application/x-troff',
        'tsv'     => 'text/tab-separated-values',
        'txt'     => 'text/plain',
        'ustar'   => 'application/x-ustar',
        'vcd'     => 'application/x-cdlink',
        'vrml'    => 'model/vrml',
        'vxml'    => 'application/voicexml+xml',
        'wav'     => 'audio/x-wav',
        'wbmp'    => 'image/vnd.wap.wbmp',
        'wbxml'   => 'application/vnd.wap.wbxml',
        'wml'     => 'text/vnd.wap.wml',
        'wmlc'    => 'application/vnd.wap.wmlc',
        'wmls'    => 'text/vnd.wap.wmlscript',
        'wmlsc'   => 'application/vnd.wap.wmlscriptc',
        'wrl'     => 'model/vrml',
        'xbm'     => 'image/x-xbitmap',
        'xht'     => 'application/xhtml+xml',
        'xhtml'   => 'application/xhtml+xml',
        'xls'     => 'application/vnd.ms-excel',
        'xlt'     => 'application/vnd.ms-excel',
        'xla'     => 'application/vnd.ms-excel',
        'xlsx'    => 'application/vnd.openxmlformats',
        'xltx'    => 'application/vnd.openxmlformats',
        'xlsm'    => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xltm'    => 'application/vnd.ms-excel.template.macroEnabled.12',
        'xlam'    => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb'    => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'xml'     => 'application/xml',
        'xpm'     => 'image/x-xpixmap',
        'xsl'     => 'application/xml',
        'xslt'    => 'application/xslt+xml',
        'xul'     => 'application/vnd.mozilla.xul+xml',
        'xwd'     => 'image/x-xwindowdump',
        'xyz'     => 'chemical/x-xyz',
        'zip'     => 'application/zip'
    ];
    return $types[$extensao];
}
function remover_caracter($string) {
    $map = array(
        'á' => 'a',
        'à' => 'a',
        'ã' => 'a',
        'â' => 'a',
        'é' => 'e',
        'ê' => 'e',
        'í' => 'i',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ú' => 'u',
        'ü' => 'u',
        'ç' => 'c',
        'Á' => 'A',
        'À' => 'A',
        'Ã' => 'A',
        'Â' => 'A',
        'É' => 'E',
        'Ê' => 'E',
        'Í' => 'I',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ú' => 'U',
        'Ü' => 'U',
        'Ç' => 'C'
    );
     
    $string =  strtr($string, $map);
    $string = preg_replace("/[áàâãä]/", "a", $string);
    $string = preg_replace("/[ÁÀÂÃÄ]/", "A", $string);
    $string = preg_replace("/[éèê]/", "e", $string);
    $string = preg_replace("/[ÉÈÊ]/", "E", $string);
    $string = preg_replace("/[íì]/", "i", $string);
    $string = preg_replace("/[ÍÌ]/", "I", $string);
    $string = preg_replace("/[óòôõö]/", "o", $string);
    $string = preg_replace("/[ÓÒÔÕÖ]/", "O", $string);
    $string = preg_replace("/[úùü]/", "u", $string);
    $string = preg_replace("/[ÚÙÜ]/", "U", $string);
    $string = preg_replace("/ç/", "c", $string);
    $string = preg_replace("/Ç/", "C", $string);
    $string = preg_replace("/[][><}{)(:;,!?*%~^`@]/", "", $string);
    $string = preg_replace("/ /", "_", $string);
    $string = str_replace(".", "", $string);
    
    return $string;
}
    
function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}