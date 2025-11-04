
<?php
require_once '../models/imagem.php';

// $host= "177.136.241.55";
// $user= "hostdeprojetos_dbsarah";
// $pass= "admin@sarahElizabeth";
// $port = "3128";
// $dbase = "hostdeprojetos_dbsarah";

$host = "localhost";
$user = "root";
$pass = "";
$dbase = "dbsarah";

$p = new Imagem($dbase, $host, $user, $pass);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Edição - Adição de Projeto</title>
</head>
<body>
    
<?php
        if(isset($_POST['projeto'])){

            // if(isset($_GET['id_up']) && !empty($_GET['id_up'])){
            //     $id_upd = addslashes($_GET['id_up']);
            //     $projeto = addslashes($_POST['projeto']);
            //     $tipo = addslashes($_POST['tipo']);
            //     $posicao = addslashes($_POST['posicao']);
            //     $descricao = addslashes($_POST['descricao']);
            //     $endereco = ($_FILES['endereco']['name']); 
                
            //     if(!empty($projeto) && !empty($tipo) && !empty($posicao) &&  !empty($descricao)){
            //         $novo_endereco= $_FILES['endereco']['name'];
            //         $velho_endereco= $_POST['velho_endereco'];

            //         if($novo_endereco !=''){
            //             $update_filename = $novo_endereco;

            //             if(file_exists("uploads/".$_FILES['endereco']['name'])){
            //                 $filename = $_FILES['endereco']['name'];
            //                 echo "esse nome existe";
            //             }
            //         }else{
            //             $update_filename = $velho_endereco;
            //         }

                //     if($p->atualizarDados($id_upd, $apelido, $tipo, $posicao, $update_filename)){
                        
                //         if (!empty($novo_endereco)) {
                //             move_uploaded_file($_FILES['endereco']['tmp_name'], "uploads/".$_FILES['endereco']['name']);
                //             unlink("uploads/".$velho_endereco);
                //         }
                //         echo "editada a imagem";

                //     }else{
                //         echo "nao foi editada";
                //     } 

                // }
                // header("location: fotos.php");
            // }else{
                $projeto = addslashes($_POST['projeto']);
                $tipo = addslashes($_POST['tipo']);
                $posicao = addslashes($_POST['posicao']);
                $descricao = addslashes($_POST['descricao']);
                $endereco = ($_FILES['endereco']['name']);

                if(!empty($projeto) && !empty($tipo) && !empty($posicao) && !empty($endereco) && !empty($descricao)){

                    if(file_exists("../uploads/".$_FILES['endereco']['name'])){
                        $filename = $_FILES['endereco']['name'];
                        echo "esse nome existe";
                    }else{
                            
                        if($p->cadastrarDados($projeto, $tipo, $posicao, $endereco, $descricao)){
                            move_uploaded_file($_FILES['endereco']['tmp_name'], "../uploads/".$_FILES['endereco']['name']);
                            echo "imagem salva";
                                
                            header("location: cadastro-imagem.php");
                            exit;
                        } else {
                                echo "Erro: Apelido já cadastrado ou falha no banco de dados.";
                        }
                    } 
                }
            }
        // }
        ?>

        <?php
        // if(isset($_GET['id_up'])){
        //     $id_update = addslashes($_GET['id_up']);
        //     $res = $p->buscarDadosEditar($id_update);
        // }
        
        ?>

        <div class="pagina-principal">
            <div class="titulo">
                <h1>SEJA BEM-VINDA,</h1>
                <img src="" alt="">
            </div>
        </div>
    
        <div>
            <h1>PAINEL DE EDIÇÃO - ADIÇÃO DE PROJETO</h1>

            <form method="POST" enctype="multipart/form-data" >
                <input type="text" name="projeto" placeholder="Nome do projeto" value="" required>
                <!-- <input type="text" placeholder="Digite o nome do projeto" required> nao entendi para que isso serve-->
                <select name="tipo" placeholder="Tipo de Projeto" value="" required>
                    <option value="">-- Escolha uma opção --</option>
                    <option value="Maquiagem">Maquiagem</option>
                    <option value="Cabelo">Cabelo</option>
                </select>

                <select name="posicao" placeholder="Posição da imagem" value="" required>
                    <option value="">-- Escolha uma opção --</option>
                    <option value="Imagem 1">Imagem 1</option>
                    <option value="Paralax 2">Paralax 2</option>
                    <option value="Imagem Sarah">Imagem Sarah</option>
                    <option>Nenhum</option>
                </select>
                <textarea name="descricao" placeholder="Descrição da imagem" required></textarea><!--descrisao da img para a acessibilidade -->

                <div id="img-add-proj">
                    <input type="file" name="endereco" placeholder="+"><!-- botei para colocar uma img pq e mais facil no momento -->
                    <!-- <input type="file" placeholder="+">
                    <input type="file" placeholder="+">
                    <input type="file" placeholder="+">
                    <input type="file" placeholder="+"> -->
                </div> 

                <button type="submit" id="button-ed-proj" name="button-add-proj" value="salve">Salvar</button>
            </form>

            <a>VOLTAR</a>
            
        </div>    
</body>
</html>