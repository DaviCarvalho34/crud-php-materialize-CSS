<?php
  require_once('MySql.php');
  require_once('Utilidades.php');

  function clear($input)
  {
    $var = htmlspecialchars($input);
    return $var;
  }

  if(isset($_POST['btn-cadastrar'])){
    $nome = clear($_POST['nome']);
    $sobrenome = clear($_POST['sobrenome']);
    $email = clear($_POST['email']);
    $idade = clear($_POST['idade']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      Utilidades::alerta("Insira um formato de email válido");
    }

    else if(Utilidades::emailExists($email)){
      Utilidades::alerta("Este email já foi cadastrado no sistema");
      Utilidades::redirect('../adicionar.php');
    }

    else if(!filter_var($idade, FILTER_VALIDATE_INT)){
      Utilidades::alerta("Digite uma idade válida");
      Utilidades::redirect('../adicionar.php');
    }else{
      $registro = MySql::connect()->prepare("INSERT INTO clientes VALUES (null, ?, ?, ?, ?)");
      $registro->execute(array($nome,$sobrenome,$email,$idade));
      
      Utilidades::alerta("Cliente Cadastrado");
      Utilidades::redirect('../adicionar.php');
    }

  }



?>