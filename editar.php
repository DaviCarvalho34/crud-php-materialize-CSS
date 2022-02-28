<?php
  include_once("includes/header.php");
  include_once("php_action/MySql.php");
  include_once("php_action/Utilidades.php");
  //SELECT
  if(isset($_GET['id'])){
    $campos = Utilidades::editarPlaceholder();
  }
?>

<div class="row">
  <div class="col s12 m6 push-m3">
    <h3 class="light"> Editar Cliente </h3>

    <?php

      require_once('php_action/MySql.php');
      
      function clear($input)
      {
        $var = htmlspecialchars($input);
         return $var;
      }

      if(isset($_POST['btn-editar'])){
        $nome = clear($_POST['nome']);
        $sobrenome = clear($_POST['sobrenome']);
        $email = clear($_POST['email']);
        $idade = clear($_POST['idade']);
        $id = $_GET['id'];
        
        //Para Capturar o email do id especifico
        foreach($campos as $key=>$value){

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          Utilidades::alerta("Insira um formato de email válido");
        }

        else if($nome == '' or $sobrenome == '' or $email == '' or $idade == ''){
          Utilidades::alerta("Você precisa preencher todos os campos!");
        }

        else if(!filter_var($idade, FILTER_VALIDATE_INT)){
          Utilidades::alerta("Digite uma idade válida");
          Utilidades::redirect('../adicionar.php');
        }

       else{
          if(Utilidades::emailExists($email)){

            if($value['email'] != $email){
              Utilidades::alerta("Este email já foi cadastrado no sistema");
              Utilidades::redirect('');
            }else{
              $edita = MySql::connect()->prepare("UPDATE clientes SET nome=?, sobrenome=?, idade=? WHERE id=?");
              $edita->execute(array($nome,$sobrenome,$idade,$id));         
              Utilidades::alerta('Cliente Editado');
              Utilidades::redirect('index.php');
            }           
          }else{
            $edita = MySql::connect()->prepare("UPDATE clientes SET nome=?, sobrenome=?, email=?, idade=? WHERE id=?");
            $edita->execute(array($nome,$sobrenome,$email,$idade,$id));         
            Utilidades::alerta('Cliente Editado');
            Utilidades::redirect('index.php');
          }           
        }
      }

      }

    ?>

    <form action="" method="POST">
      <input type="hidden" value="<?php echo $value['id'];?>">
      <div class="input-field col s12">
          <?php foreach($campos as $key=>$value){?>
          <input type="text" name="nome" id="nome" value="<?php echo $value['nome'];?>">
         
          <label for="nome">Nome</label>
      </div>

      <div class="input-field col s12">
          <input type="text" name="sobrenome" id="sobrenome" value="<?php echo $value['sobrenome'];?>">
          <label for="sobrenome">Sobrenome</label>
      </div>

      <div class="input-field col s12">
          <input type="email" name="email" id="email" value="<?php echo $value['email'];?>">
          <label for="email">E-mail</label>
      </div>

      <div class="input-field col s12">
          <input type="text" name="idade" id="idade" value="<?php echo $value['idade'];?>">
          <label for="idade">Idade</label>
      </div>
      <?php } ?>

      <button type="submit" name="btn-editar" class="btn">Cadastrar</button>
      <a href="index.php" class="btn green">Lista de clientes</a>
    </form>
  </div>
</div>

<?php
include_once("includes/footer.php");
?>