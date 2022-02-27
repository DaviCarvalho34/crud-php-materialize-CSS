<?php
  include_once("includes/header.php");
  require_once("php_action/Utilidades.php");
  //Conexão
  include_once("php_action/MySql.php");
?>

<div class="row">
  
  <div class="col s12 m6 push-m3">
    <h3 class="light"> Clientes </h3>
    <table class="striped">
      <thead>
        <tr>
            <th>Nome:</th>
            <th>Sobrenome:</th>
            <th>Email:</th>
            <th>Idade:</th>
        </tr>
      </thead>
      
      <tbody>        
        <?php
          $pdo = MySql::connect();
        ?>

        

        <?php

         $exibir = Utilidades::listarClientes(); 

         
         foreach($exibir as $key=>$value){ ?>
        <tr>
            <td><?php echo $value['nome']?></td>
            <td><?php echo $value['sobrenome']?></td>
            <td><?php echo $value['email']?></td>
            <td><?php echo $value['idade']?></td>
            <td><a href="editar.php?id=<?php echo $value['id']; ?>" class="btn-floating orange"><i class="material-icons">edit</i></a></td>

            <td><a href="#modal<?php echo $value['id']?>" class="btn-floating red modal-trigger"><i class="material-icons">delete</i></a></td>

             <!-- Modal Structure -->
            <div id="modal<?php echo $value['id']?>" class="modal">
              <div class="modal-content">
                <h4>Opa!</h4>
                <p>Tem certeza que quer excluir este cliente do registro?</p>
              </div>
              <div class="modal-footer">
                
              <?php

                if(isset($_POST['btn-deletar'])){
                  $id = $_POST['id'];
                  
                  $deleta= MySql::connect()->prepare("DELETE FROM clientes WHERE id=?");
                  $deleta->execute(array($id));         
                  Utilidades::alerta('Cliente Deletado');
                  Utilidades::redirect('index.php');
              }
              ?>

                <form method="post" action="">
                  <input type="hidden" name="id" value="<?php echo $value['id']?>"></input>
                  <button type="submit" name="btn-deletar" class="btn red">Sim, quero deletar!</button>
                  <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancelar</a>
                </form>

              </div>
            </div>

        </tr>
        <?php }?>

      </tbody>
    </table>
    <br>
    <a href="adicionar.php" class="btn">Adicionar Cliente</a>
  </div>
</div>

<?php
  include_once("includes/footer.php");
?>