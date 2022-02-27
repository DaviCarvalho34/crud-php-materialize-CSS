<?php
	require_once('MySql.php');
	

	class Utilidades
	{
		
		public static function redirect($url)
    {
			echo '<script>window.location.href="'.$url.'"</script>';
			die();
		}

		public static function alerta($mensagem)
    {
			echo '<script>alert("'.$mensagem.'")</script>';
			
		}

    public static function emailExists($email)
    {
      $pdo = MySql::connect();
      $verificar = $pdo->prepare("SELECT email FROM clientes WHERE email = ?");
      $verificar->execute(array($email));

      if($verificar->rowCount() == 1){
        //Email existente
        return true;
      }else{
        return false;
      }
    }

    public static function listarClientes(){

			$pdo = MySql::connect();

			$exibir = $pdo->prepare("SELECT * FROM clientes");

			$exibir->execute();

			return $exibir->fetchAll();

		}

		public static function editarPlaceholder(){
			$pdo = MySql::connect();

			$id = $_GET['id'];

    	$campos = MySql::connect()->prepare("SELECT * FROM clientes WHERE id = ?");
    	$campos->execute(array($id));

			return $campos->fetchAll();
		}

		public static function getUsuarioById($id){
			$pdo = MySql::connect();

			$usuario = $pdo->prepare("SELECT * FROM clientes WHERE id = ? ");

			$usuario->execute(array($id));

			return $usuario->fetch();
		}

		
	}
?>