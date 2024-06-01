<?php
      // Arquivo de "Regras de negócio": 
      // MODELO -> Operações para ter acesso ao BD e realizar CRUD !!

     /* criarmos uma classe para ter acesso ao BD e criarmos dois métodos  de consulta:
       1) consultar um determinado o registro através de um parâmetro "id" 
       2) consultar todos os registros sem parâmetro     */
      
      //inserir o arquivo 'config.php'
      require_once 'config.php' ; // ou include 'config.php'
      
      /* Criamos uma class chamada "Pets"  */
      class Pets
      {
        //1) um método para fazer consulta atráves do parâmetro $id
        public static function select(int $id)
        {
            //Criar duas variáveis para tabela e primeira coluna
            $tabela = "apets"; //variável para nome da tabela
            $coluna = "codigo"; //variável para chave primaria
            
            // Conectando com o banco de dados através da classe (objeto) PDO
            // pegando as informações do config.php (variáveis globais)
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            
            // Usando comando sql que será executado no banco de dados para consultar um 
            // determinado registro 
            $sql = "select * from $tabela where $coluna = :id" ;
            
            //preparando o comando Select do SQL para ser executado usando método prepare()
            $stmt = $connPdo->prepare($sql);  

            //configurando (ou mapear) o parametro de busca
            $stmt->bindValue(':id' , $id) ;
           
            // Executando o comando select do SQL no banco de dados
            $stmt->execute() ;
           
            if ($stmt->rowCount() > 0) // se houve retorno de dados (Registros)
            {
                //imprimir usando : var_dump( $stmt->fetch(PDO::FETCH_ASSOC) );

                // retornando os dados do banco de dados através do método fetch(...)
                return $stmt->fetch(PDO::FETCH_ASSOC) ;
                
            }else{// se não houve retorno de dados, jogar no classe Exception (erro)
                  // e mostrar a mensagem "Sem registro do pet"                
                throw new Exception("Sem registro do pet");
            }

        }
        
        //2) Um método para fazer consultado de todos os dados sem parâmetro
        public static function selectAll()
        {
            $tabela = "pets"; //uma variável para nome da tabela "Pets"
            
            // conectando com o banco de dados através da classe (objeto) PDO
            // pegando as informações do config.php (variáveis globais)
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            //criar execução de consulta usando a linguagem SQL
            $sql = "select * from $tabela"  ;
            // preparando o comando Select do SQL para ser executado usando método prepare()
            $stmt = $connPdo->prepare($sql);
            // Executando o comando select do SQL no banco de dados
            $stmt->execute() ;

            if ($stmt->rowCount() > 0) // se houve retorno de dados (Registros)
            {
                // retornando os dados do banco de dados através do método fetchAll(...)
                return $stmt->fetchAll(PDO::FETCH_ASSOC) ;
            }else{
                throw new Exception("Sem registros");
            }

        }

        public static function insert($dados)
        {
            $tabela = "Pets"; //uma variável para nome da tabela "Pets"
            $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
            $sql = "insert into $tabela (especie,raca,nome,ult_local,nome_dono,contato_dono) values (:especie,:raca,:nome,:ult_local,:nome_dono,:contato_dono)";
            $stmt = $connPdo->prepare($sql);
            //Mapear os parâmetros para obter os dados de inclusão
            $stmt->bindValue(':especie', $dados['especie']);
            $stmt->bindValue(':raca', $dados['raca']);
            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':ult_local', $dados['ult_local']);
            $stmt->bindValue(':nome_dono', $dados['nome_dono']);
            $stmt->bindValue(':contato_dono', $dados['contato_dono']);
            $stmt->execute() ;

            if ($stmt->rowCount() > 0) // se houve os dados (Registros)
            {                
                return 'Dados cadastrados com sucesso!' ;
            }else{
                throw new Exception("Erro ao inserir os dados");
            }
        }

        public static function delete($id)
{
     $tabela = "Pets"; //uma variável para nome da tabela "Pets"
     $coluna = "codigo"; //uma variável para nome "codigo"
     $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
     $sql = "delete from $tabela where $coluna = :id";
     $stmt = $connPdo->prepare($sql);
     $stmt->bindValue(':id', $id) ;
     $stmt->execute() ;

     if ($stmt->rowCount() > 0) // se houve os dados (Registros)
     {                
         return 'Dados excluidos com sucesso!' ;
     }else{
                throw new Exception("Erro ao excluir os dados");
     }
}

//5) Um método para fazer atualização (alteração) de dados no BD
public static function update($id,$dados)
{ 
    $tabela = "pets"; //uma variável para nome da tabela "Pets"
    $coluna = "codigo"; //uma variável para nome "codigo"
    $connPdo = new PDO(dbDrive.':host='.dbHost.'; dbname='.dbName, dbUser, dbPass);
    $sql = "update $tabela set especie=:especie,raca=:raca,nome=:nome,ult_local=:ult_local,nome_dono=:nome_dono,contato_dono=:contato_dono where $coluna=:id";
    $stmt = $connPdo->prepare($sql);
    //Mapear os parâmetros para obter os dados de inclusão
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':especie', $dados['especie']);
    $stmt->bindValue(':raca', $dados['raca']);
    $stmt->bindValue(':nome', $dados['nome']);
    $stmt->bindValue(':ult_local', $dados['ult_local']);
    $stmt->bindValue(':nome_dono', $dados['nome_dono']);
    $stmt->bindValue(':contato_dono', $dados['contato_dono']);
    $stmt->execute() ;

    if ($stmt->rowCount() > 0) // se houve os dados (Registros)
    {                
        return 'Dados alterados com sucesso!' ;
    }else{
        throw new Exception("Erro ao alterar os dados");
    }
}
      }