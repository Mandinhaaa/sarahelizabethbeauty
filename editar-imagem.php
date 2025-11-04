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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Painel de Edição - Projeto</title>
  </head>
  <body>

<?php
        if (isset($_POST['projeto'])) {

            if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {
                $id_upd = addslashes($_GET['id_up']);
                $projeto = addslashes($_POST['projeto']);
                $tipo = addslashes($_POST['tipo']);
                $posicao = addslashes($_POST['posicao']);
                $descricao = addslashes($_POST['descricao']);
                $velho_endereco = $_POST['velho_endereco'];
                $novo_endereco = $_FILES['endereco']['name'];
        
                if (!empty($projeto) && !empty($tipo) && !empty($posicao) && !empty($descricao)) {
        
                    // Decide qual arquivo usar
                    if ($novo_endereco != '') {
                        $update_filename = $novo_endereco;
        
                        if (file_exists("../uploads/" . $novo_endereco)) {
                            echo "Esse nome de arquivo já existe.";
                            exit;
                        }
        
                    } else {
                        $update_filename = $velho_endereco;
                    }
        
                    // Atualiza no banco
                    if ($p->atualizarDados($id_upd, $projeto, $tipo, $posicao, $update_filename, $descricao)) {
                        
                        // Atualiza arquivo se for novo
                        if ($novo_endereco != '') {
                            move_uploaded_file($_FILES['endereco']['tmp_name'], "../uploads/" . $novo_endereco);
                            if (file_exists("../uploads/" . $velho_endereco)) {
                                unlink("../uploads/" . $velho_endereco);
                            }
                        }
        
                        echo "Projeto atualizado com sucesso!";
                        header("Location: editar-imagem.php");
                        exit;
                    } else {
                        echo "Erro ao editar o projeto.";
                    }
                } else {
                    echo "Preencha todos os campos obrigatórios.";
                }
            }
        }
                // header("location: editar-imagem.php");
            // }else{
            //     $projeto = addslashes($_POST['projeto']);
            //     $tipo = addslashes($_POST['tipo']);
            //     $posicao = addslashes($_POST['posicao']);
            //     $descricao = addslashes($_POST['descricao']);
            //     $endereco = ($_FILES['endereco']['name']);

                // if(!empty($apelido) && !empty($tipo) && !empty($posicao) && !empty($endereco) !empty($descricao)){

                //     if(file_exists("uploads/".$_FILES['endereco']['name'])){
                //         $filename = $_FILES['endereco']['name'];
                //         echo "esse nome existe";
                //     }else{
                            
                //         if($p->cadastrarDados($apelido, $tipo, $posicao, $endereco)){
                //             move_uploaded_file($_FILES['endereco']['tmp_name'], "uploads/".$_FILES['endereco']['name']);
                //             echo "imagem salva";
                                
                //             header("location: fotos.php");
                //             exit;
                //         } else {
                //                 echo "Erro: Apelido já cadastrado ou falha no banco de dados.";
                //         }
                //     } 
                // }
        ?>

        <?php
        if(isset($_GET['id_up'])){
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosEditar($id_update);
        }
        
        ?>

    <div class="pagina-principal">
      <div class="titulo">
        <h1>SEJA BEM-VINDA,</h1>
        <img src="" alt="" />
      </div>
    </div>

    <div>
      <h1>PAINEL DE EDIÇÃO - PROJETO</h1>

            <form method="POST" enctype="multipart/form-data" >
                <input type="text" name="projeto" placeholder="Nome do projeto" value="<?php if(isset($res)){echo $res['projeto'];}  ?>" required>
                <!-- <input type="text" placeholder="Digite o nome do projeto" required> nao entendi para que isso serve-->
                <select name="tipo" required>
                    <option value="" disabled selected hidden>-- Escolha uma opção --</option>
                    <option value="Maquiagem" <?php if(isset($res) && $res['tipo']=="Maquiagem") echo "selected"; ?>>Maquiagem</option>
                    <option value="Cabelo" <?php if(isset($res) && $res['tipo']=="Cabelo") echo "selected"; ?>>Cabelo</option>
                </select>

                <select name="posicao" required>
                    <option value="" disabled selected hidden>-- Escolha uma opção --</option>
                    <option value="Imagem 1" <?php if(isset($res) && $res['posicao']=="Imagem 1") echo "selected"; ?>>Imagem 1</option>
                    <option value="Paralax 2" <?php if(isset($res) && $res['posicao']=="Paralax 2") echo "selected"; ?>>Paralax 2</option>
                    <option value="Imagem Sarah" <?php if(isset($res) && $res['posicao']=="Imagem Sarah") echo "selected"; ?>>Imagem Sarah</option>
                    <option value="Nenhum" <?php if(isset($res) && $res['posicao']=="Nenhum") echo "selected"; ?>>Nenhum</option>
                </select>

                <textarea name="descricao" required><?php if(isset($res)){echo $res['descricao'];} ?></textarea>
                <input type="file" name="endereco" value="<?php if(isset($res)){echo $res['endereco'];}  ?>" ><!--descrisao da img para a acessibilidade -->

                <div id="img-add-proj">
                <input type="hidden" name="velho_endereco" value="<?php if(isset($res)){echo $res['endereco'];}  ?>" >
                <img src="<?php echo "../uploads/".$res['endereco'];?>" width=75px alt="">
                    <!-- botei para colocar uma img pq e mais facil no momento -->
                    <!-- <input type="file" placeholder="+">
                    <input type="file" placeholder="+">
                    <input type="file" placeholder="+">
                    <input type="file" placeholder="+"> -->
                </div> 

                <button type="submit" id="button-ed-proj" name="button-add-proj" value="salve">Atualizar</button>
            </form>

        <p>VOLTAR</p>
    </div>

        <?php
            $dados = $p->buscarDados();
            if (count($dados) > 0) {
                for ($i = 0; $i < count($dados); $i++) {
                    echo "<p> ";
                    if ($dados[$i]['id'] != "id") {
                        echo " ".$dados[$i]['id'];
                        echo " ".$dados[$i]['projeto'];
                        echo " ".$dados[$i]['tipo'];
                        echo " ".$dados[$i]['posicao'];
                        echo " ".$dados[$i]['descricao'];
                        echo '<img src="../uploads/'.$dados[$i]['endereco'].'" width=75px alt="imagem">';
                    } 
                    
                    ?>
                    <a href="editar-imagem.php?id=<?php echo $dados[$i]['id']; ?>">Excluir</a>
                    <a href="editar-imagem.php?id_up=<?php echo $dados[$i]['id']; ?>">Editar</a>
                    <?php
                    echo "</p> ";
                }
            } else {
                echo "Ainda não há imagem cadastrada";
            }
?>

  </body>
</html>
<?php
    if(isset($_GET['id'])){
        $id_img = addslashes($_GET['id']);
        $dados_img = $p->buscarEndereco($id_img); 
        $endereco_arquivo = $dados_img['endereco'];
        $p->excluirDados($id_img, $endereco_arquivo);
        
        header("location: editar-imagem.php");
    }
?>