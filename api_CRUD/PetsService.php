<?php
    // Arquivo de controle : tipo de servicos oferecidos pelo Api   
    include 'Pets.php'; //incluir o arquivo Pets.php
    class PetsService 
    {
          //Um método "get" para consulta de dados: (protocolo: "get" - buscar os dados no BD)
          // quando "$id = null" significa que pode ter ou não este parâmetro 
          public function get( $id = null )
          {
              if ($id){// se existe $id  
                 //retornar resultado do método select($id) da class Pets            
                 return Pets::select($id) ;
              }else{
                 //retornar resultado do método selectAll() da class Pets 
                 return Pets::selectAll() ;
              }

          }
          // funcão para inclusão de dados
          public function post()
          {
              $dados = json_decode(file_get_contents('php://input'), true, 512);
              if ($dados == null){
                  throw new Exception("Falta os dados para incluir !");
              }
              return Pets::insert($dados);
          }
          // funcão para alteração de dados
          public function put($id = null)
          {
              if ($id == null){
                throw new Exception("Falta o codigo !");
              }
              //Pegar as informações para atualizar no BD
              $dados = json_decode(file_get_contents('php://input'), true, 512);
              if ($dados == null){
                throw new Exception("Falta informação!");
              }
              return Pets::update($id,$dados);              
          }
         
         // funcão para exclusão de dados
         public function delete($id = null)
         {
            if ($id == null){
               throw new Exception("Falta o codigo !");
         }   
            return Pets::delete($id);
}
    
}