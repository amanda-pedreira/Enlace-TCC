<?php
session_start();

if(!isset($_SESSION["id_adm"]) || $_SESSION["id_adm"] == ""){
    session_abort();
    ?>
        <form action="../index.php" name="return" id="return" method="post">
            <input type="hidden" name="cod" value="OA02">
        </form>
        <script>
            document.getElementById("return").submit();
        </script>
    <?php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/gh/eliyantosarage/font-awesome-pro@main/fontawesome-pro-6.5.1-web/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        body {
    font-family: 'Roboto', sans-serif;
    margin: 20px;
    background-color: #f0f4f8;
    color: #333;
    line-height: 1.6;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

th, td {
    border: 1px solid #e0e0e0;
    padding: 12px;
    text-align: left;
    transition: background-color 0.3s ease;
}

th {
    background-color: #335e92;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

tr:hover {
    background-color: rgba(51, 94, 146, 0.1);
}

input[type="submit"] {
    background-color: #335e92;
    color: white;
    border: none;
    padding: 12px 24px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

input[type="submit"]:hover {
    background-color: #2a4b6e;
    transform: scale(1.05);
}

button {
    background-color: transparent;
    color: #ba6d67;
    border: none;
    cursor: pointer;
    font-size: 18px;
    transition: color 0.3s ease, transform 0.2s ease;
}

button:hover {
    color: #9c4a48;
    transform: scale(1.1);
}

.fa-trash {
    font-size: 20px;
    transition: color 0.3s ease;
}

.fa-trash:hover {
    color: #ba6d67;
}

input[type="text"], input[type="email"], textarea {
    width: calc(100% - 24px);
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus, input[type="email"]:focus, textarea:focus {
    border-color: #335e92;
    outline: none;
}
    </style>
    <script>
        function confirmDelete(id) {
            var resp = confirm("Tem certeza que deseja apagar este registro?");
            if (resp == true) {
                location.href = "../Controller/controller.php?carrossel_delete=1&id=" + id;
            } else {
                return null;
            }
        }
    </script>
</head>
<body>
    <form action="carrosselNew.php" method="post">
        <input type="submit" value="Novo +">
    </form>
    
    <?php
        require "../Model/manager.class.php";
        $manager = new Manager();
        $dados = $manager->carrosselList(); 
        
        if (isset($dados["num"]) && $dados["num"] > 0){
    ?>
    <table>
        <tr>
            <th>ID</th>
            <th>imggd</th>
            <th>imgpq</th>
            <th>Status</th>
            <th>Editar</th>
            <th>Deletar</th>
        </tr>
        <?php
            for($i = 1; $i <= $dados["num"]; $i++){
                echo "<tr>";
                echo "<td>" . $dados[$i]["id"] . "</td>";
                echo "<td><img src='../../Assets/carrossel/" . $dados[$i]["imggd"] . "' alt='". $dados[$i]["altgd"] ."' style='width:100px;'></td>";
                echo "<td><img src='../../Assets/carrossel/" . $dados[$i]["imgpq"] . "' alt='". $dados[$i]["altpq"] ."' style='width:100px;'></td>";

                echo "<td>";
                echo $dados[$i]["status"] == 1 ? "Ativo" : "Inativo";
                echo "</td>";

                echo "<td>";
                ?>
                    <form name="formEdit" action="carrosselEdit.php" method="post">
                        <input type="hidden" name="id" value="<?=$dados[$i]['id'];?>">
                        <input type="submit" name="sbmt" value="Editar">
                    </form>
                <?php
                echo "</td>";
                echo "<td>";
                ?>
                    <button onclick="confirmDelete(<?= $dados[$i]['id']; ?>)"><i class="fas fa-trash"></i></button>
                <?php   
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <?php
    } else {
        echo "Nenhuma imagem do carrossel encontrado!";
    }
    ?>

<div class="modal fade" id="textomodalcelsomito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Aviso!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="textomodal"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>

<?php
   if (isset($_REQUEST["msg"])) {
    require_once "../Model/msg.php";
    $cod = $_REQUEST["msg"];
    $msgExibir = $MSG[$cod];
    echo "<script>
    var textomodal = document.getElementById('textomodal')
    textomodal.innerHTML = '".$MSG[$cod]."'
    $('#textomodalcelsomito').modal('show');
    </script>";
}

?>
