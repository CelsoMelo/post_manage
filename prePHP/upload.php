<?php
    //verifica se existem arquivos para serem upados
    if(isset($_FILES['image_post']['name']) && $_FILES['image_post']['error'] == 0) {
        //exibe informações do arquivo
        echo 'Informações do arquivo: <br/>';
        echo 'Nome: <strong>' . $_FILES['image_post']['name'] . '</strong><br/>';
        echo 'Tipo: <strong>' . $_FILES['image_post']['type'] . '</strong><br/>';
        echo 'Tamanho: <strong>' . $_FILES['image_post']['size'] . '</strong><br/>';
        
        //pega o arquivo carregado
        $file_tmp = $_FILES['image_post']['tmp_name'];
        $file_name = $_FILES['image_post']['name'];

        //pega a extensão do arquivo e deixa em miniatura
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_ext = strtolower($file_ext);

        //verificar o tipo de arquivo (nesse caso, imagens)
        if(strstr('.jpg;.jpeg;.png;', $file_ext)) {
            //define um novo nome para o arquivo
            //o "uniqid" adiciona caracteres aleatorios no final do nome
            $new_name = uniqid(time()) . '.' . $file_ext;
            
            //define o destino do arquivo e ja adiciona o novo nome
            $destiny = '../image/posts/' . $new_name;

            //tenta mover o arquivo temporario para o destino
            if(@move_uploaded_file($file_tmp, $destiny)) {
                echo 'Arquivo salvo em: <strong>' . $destiny . '</strong></br>';
                echo '<img src = "' . $destiny . '">';

            } else {
                echo 'ERRO AO SALVAR O ARQUIVO!';
            } 
        } else {
            echo 'Tipo de arquivo não suportado!';
        }
    }
