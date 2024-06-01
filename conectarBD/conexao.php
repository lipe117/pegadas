<?php
    $conexao = mysqli_connect("localhost","root","","projwebservices");
    $dados = array();
    $dados ['erro'] = false;
    $dados ['mensagem'] = "Tudo certo !";

    $sql = "SELECT * FROM pets" ;

    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0){
        while ($registro = mysqli_fetch_array($resultado)){
            $dados['Dados Cadastrados:'][] = array (
                'codigo' => intval($registro['codigo']),
                'especie' => $registro['especie'],
                'raca' => $registro['raca'],
                'nome' => $registro['nome'],
                'ult_local' => $registro['ult_local']
            );
        }
    }
    else{
        $dados['erro'] = true;
        $dados['mensagem'] = "Nenhum registro encontrado";
    }
    echo json_encode($dados);
?>