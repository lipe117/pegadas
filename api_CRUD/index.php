<?php
    // Este programa é para execução do Api_Consultas
    include 'PetsService.php'; //incluir arquivo PetsService.php  
    include 'loginService.php';  
    //Colocando o cabecalho para retornar os dados em formado json na saida
    header("Content-Type: application/json; charset=UTF-8"); 
    header("Access-Control-Allow-Origin: *");  // Necessário para a mesma máquina (localhost)
    header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
    header("Access-Control: no-cache, no-store, must-revalidate");
    header("Access-Control-Allow-Headers: *");
    header("Access-Control-Max-Age: 86400");
    // $_GET eh uma variável do tipo array() que pegar link (endereço)
    // Metodo GET é um protocolo de solicitação.
    
    if ($_GET['url']){// se houver url ele cria a variável $url 
       
        // O comando var_dump(..) é para imprimir (mostrar)
        //var_dump($_GET); //testar !!!
        //var_dump($_GET['url']); //testar !!!
        $url = explode('/' , $_GET['url']);
        //var_dump($url);  // mostrar a url
         
        if ($url[0] === 'api' ){//se estiver tentando acessar a api 
            // Removendo a primeira posição do registro e retorna o resto (neste caso api)          
            array_shift($url);
            
            /*ucfirst — Converte para maiúscula o primeiro caractere de uma string;
              Retorna uma string com o primeiro caractere de str em maiúscula, 
              se o caractere for do alfabeto. */
            //var_dump($url);  // mostrar a url 
            $service = ucfirst($url[0]).'Service' ; 
            //Removendo a primeira posição do registro (neste caso Pets)
            array_shift($url); //neste caso $url ficar como um vetor vazio                      
            
            $method = strtolower( $_SERVER['REQUEST_METHOD']); // metodo get ou post (minusculo)  
            //$method = $_SERVER['REQUEST_METHOD']; // metodo get ou post (Maiusculo)           
            //var_dump($service) ;  //  testar !!         
            //var_dump($method) ;   //testar !!             
           
            //Acesso aos dados do BD: get, post, put e delete
            try {
                // chamando o metodo call_user_func_array(..) para buscar os dados
                $response =  call_user_func_array(array(new  $service , $method), $url) ;                
                http_response_code(200) ; // ok
                //convertendo o resultado em json e mostrando os dados;
                echo json_encode( array('status' => 'sucess' , 'information' => $response));                
            } catch (Exception $e) {
                http_response_code(404) ; // erro
                //mostrando a mensagem de erro (não encontrado);
                echo json_encode( array('status' => 'error' , 'information' => $e->getMessage()));                
            }  
        } 
    }
