<?php
require_once("dbcontroller.php");
require_once("SimpleRest.php");


class ClienteRestHandler extends SimpleRest
{

	public function adicionarCliente ()
    {

			$nome = $_GET["txtNomeCliente"];
			$telefone = $_GET["txtTelefone"];
			$endereco = $_GET["txtEndereco"];
			$cep = $_GET["txtCep"];
			$bairro = $_GET["txtBairro"];

    // Instanciar a classe DBController	
			$dbcontroller = new DBController();
			
			$query=" DECLARE @codigo int
			set @codigo=( select TOP(1) Codigo_Cliente from Cliente 
			order by Codigo_Cliente desc)+1
			select @codigo as 'Codigo'; ";
			
			$codigo = $dbcontroller->executeBuscaCodigoSelectQuery($query);

			$query ="INSERT INTO Cliente (Codigo_Cliente,Nome,Telefone,Endereco,CEP,Bairro)
			 VALUES ('{$codigo}','{$nome}','{$telefone}','{$endereco}','{$cep}','{$bairro}')";

			echo $query;

			$rawData = $dbcontroller->executeQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				$rawData = array('success' => 0);		
			} else {
				$statusCode = 200;
			}
	
			$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
			$result = $rawData;
					
			if(strpos($requestContentType,'application/json') !== false)
			{
				$response = $this->encodeJson($result);
				echo $response;
			}

    }

    public function pesquisarCliente ()
    {

        $nome = $_GET["txtpesquisarcliente"];
    //new = estancia
     //   $query = "select * from tbclientes"
    
    $query = "SELECT * FROM Cliente where Nome like '%{$nome}%' ";        
    
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
	
			$requestContentType = 'application/json';//$_POST['HTTP_ACCEPT'];
			$this ->setHttpHeaders($requestContentType, $statusCode);
			$result = $rawData;
					
			if(strpos($requestContentType,'application/json') !== false)
			{
				$response = $this->encodeJson($result);
				echo $response;
			}

    }

    public function encodeJson($responseData) 
	{
		$jsonResponse = json_encode($responseData);
		return $jsonResponse;		
	}

}

if (isset($_GET["txtNomeCliente"])) {

	$cliente = new ClienteRestHandler();
	$cliente -> adicionarCliente();




}

//se o parametro txtpesquisarcliente estiver preenchido, instancia a classe e executa
// o metodo pesquisarcliente

if (isset($_GET["txtpesquisarcliente"])) {

        $cliente = new ClienteRestHandler();
        $cliente -> pesquisarCliente();




}

?>