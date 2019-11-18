<?php
/* funcoes : logar/ativar cmd/inserir produtos  */

require_once("dbcontroller.php");
require_once("SimpleRest.php");


class LoginRestHandler extends SimpleRest 
{
	   
    
    public function appLogin ()
	{
		
		if (isset($_POST["txtUsuario"])) 
		{
			$nome	= $_POST["txtUsuario"];
			$senha	= $_POST["txtSenha"];
		
			/*$query ="
			declare @logado int,@usuario varchar(30)
			set @logado =(Select COUNT(*) from tbLogiin where Nomeusuario ='{$nome}' 
			and senhausuario='{$senha}');
			if (@logado=0)
				begin
				set @logado=2
				end
			else
				begin
				if (@logado=1)
					begin
					set @logado =(Select COUNT(*) from tbLogiin where logado='1' and NomeUsuario='{$nome}' and senhausuario='{$senha}');
					end
				end
				
				if (@logado=1)
					begin
						set @logado=3
					end
				else
					begin
					if (@logado=0)
						begin
						set @logado=4
						set @usuario = '{$nome}'
					 end
					end
				select @logado as 'logado', @usuario as 'usuario'
				if (@logado=4)
					begin
					update tbLogiin
					set logado='1'
					where NomeUsuario='{$nome}' and senhausuario='{$senha}'
					end";
			*/		
			$query = "sp_VerificarUsuario '{$nome}','{$senha }'";	
			//echo $query;
			// Instanciar a classe DBController		
			$dbcontroller = new DBController();
			
			$rawData = $dbcontroller->executeSelectQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				$rawData = array('success' => 0);		
			} else {
				$statusCode = 200;
			}
			
			$requestContentType = $_POST['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
			//$result = $rawData;
			
			$result["RetornoDados"] = $rawData;
					
			if(strpos($requestContentType,'application/json') !== false)
			{
				$responses = $this->encodeJson($result);
				echo $responses;
			}
		
		}
	}


	
	public function appDesconectarLogin ()
	{
		if (isset($_POST["txtLogout"])) 
		{
			$nome	= $_POST["txtLogout"];
			
			// Instanciar a classe DBController		
			$dbcontroller = new DBController();
		
			/*$query ="declare @logado int
					set @logado =(SELECT COUNT(*) FROM tbLogiin where Logado='1' and NomeUsuario='{$nome}');
					if(@logado=1)
					begin
						set @logado=5
							select @logado as 'logado';
					end  
				   
					if (@logado =5)
					begin
						update tblogiin
							set Logado ='0'
								where NomeUsuario='{$nome}'
					end"; 
			*/	  
				// $query ="exec sp_Desconectar '{$nome}'";
			$query= "sp_LogoutUsuario '{$nome}'";
			//echo $query;
			$rawData = $dbcontroller->executeSelectQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				//$rawData = array('logado' => 0);		
			} else {
				$statusCode = 200;
			}
	
			$requestContentType =  $_GET['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
			//$result = $rawData;
			$result["RetornoDados"] = $rawData;
								
			if(strpos($requestContentType,'application/json') !== false)
			{
				$response = $this->encodeJson($result);
				echo $response;
			}
		
		}
	}

	public function appAtivarComanda()
	{
		if(isset($_POST["txtComanda"]))
		{
			$comanda = $_POST["txtComanda"];

			// Instanciar a classe DBController		
			$dbcontroller = new DBController();

			$query = " sp_AtivarComanda '{$comanda}'";
			echo $query;

			$rawData = $dbcontroller->executeQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				$rawData = array('successo' => 0);		
			} else {
				$statusCode = 200;
			}
			
			$requestContentType = $_POST['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
			//$result = $rawData;
			
			$result["RetornoDados"] = $rawData;
					
			if(strpos($requestContentType,'application/json') !== false)
			{
				$responses = $this->encodeJson($result);
				echo $responses;
			}
			
		}
	}

	public function appInserirProdutosComanda()
	{
		if (isset($_POST["txtCodigo"]))
		{
			$codigo     =     $_POST["txtCodigo"];
			$quantidade = $_POST["txtQuantidade"];
			$produto    =    $_POST["txtProduto"];

			// Instanciar a classe DBController		
			$dbcontroller = new DBController();

			$query=" sp_InserirProdutosComanda '{$codigo}','{$quantidade}','{$produto}' ";
			echo $query;
			$rawData = $dbcontroller->executeQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				$rawData = array('sucesso' => 0);		
			} else {
				$statusCode = 200;
			}
	
			$requestContentType = $_POST['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
			//$result = $rawData;
			$result["RetornoDados"] = $rawData;
								
			if(strpos($requestContentType,'application/json') !== false)
			{
				$response = $this->encodeJson($result);
				echo $response;
			}

		}
	}
	
		
	
	public function encodeJson($responseData) 
	{
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}

	public function appCadastrar()
	{
		if (isset($_GET["txtNomeProduto"])) {
			
			$nomeProduto = $_GET["txtNomeProduto"]; 
			$quantidade  = $_GET["txtQuantidade"];
			$preco		 = $_GET["txtPreco"];
			$movimento	 = $_GET["txtMovimento"];

			
			// Instanciar a classe DBController		
			$dbcontroller = new DBController();

			$query = " sp_IncluirProdutos '{$nomeProduto}','{$quantidade}',{$preco},'{$movimento}' ";
			//echo $query;
			$rawData = $dbcontroller->executeSelectQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				//$rawData = array('logado' => 0);		
			} else {
				$statusCode = 200;
			}
	
			//$requestContentType =  $_POST['HTTP_ACCEPT'];
			//$this ->setHttpHeaders($requestContentType, $statusCode);
			//$result = $rawData;
			$result["RetornoDados"] = $rawData;
								
			//if(strpos($requestContentType,'application/json') !== false)
		//	{
		//		$response = $this->encodeJson($result);
		//		echo $response;
		//	}
			$response = $this->encodeJson($result);
			echo $response;


		}
	}

		
}	




if(isset($_GET["page_key"]))
	{
			
		$usuario = new LoginRestHandler() ;
		$usuario -> appLogin();
			
	}
	
if(isset($_GET["page_sair"]))
	{
			
		$usuario = new LoginRestHandler() ;
		$usuario -> appDesconectarLogin();
			
	}
	
if (isset($_GET["page_inserir"])) 
	{

		$produtos = new LoginRestHandler();
		$produtos -> appInserirProdutosComanda();	
	
	}
	
if(isset($_GET["page_ativar"]))
	{
		$comanda = new LoginRestHandler();
		$comanda -> appAtivarComanda();
	}
		

?>






