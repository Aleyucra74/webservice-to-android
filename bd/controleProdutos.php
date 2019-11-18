<?php
require_once("dbcontroller.php");
require_once("SimpleRest.php");


class ProdutosRestHandler extends SimpleRest 
{
	   
    
    public function IncluirProdutos ()
	{
		
		if (isset($_POST["txtNomeProduto"])) 
		{
			$nome	= $_POST["txtNomeProduto"];
			$unidade	= $_POST["txtUnidade"];
            $validade	= $_POST["txtValidade"];
		
			$query ="declare @codigo int
            
            set @codigo = (Select top(1) CODIGO_PRODUTO
            from Produtos order by CODIGO_PRODUTO desc) +1;
            
            if @codigo is null
                begin
                    set @codigo = 1;
                end
                
            insert into Produtos ( CODIGO_PRODUTO, NOME, TIPO, VALIDADE ) values (@codigo, '{$nome}', '{$unidade}', '{$validade}')";
            
			//echo $query;
			// Instanciar a classe DBController		
			$dbcontroller = new DBController();
			
			$rawData = $dbcontroller->executeQuery($query);
		
				//Verificar se o retorno está "vazio"
			if(empty($rawData))
			{
				$statusCode = 404;
				$rawData = array('sucesso' => 0);		
			} else {
				$statusCode = 200;
                //$rawData = array('sucesso' => 1);
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


	
	public function ListarProdutos ()
	{
		if (isset($_POST["txtLista"])) 
		{
			$nome	= $_POST["txtLista"];
			
			// Instanciar a classe DBController		
			$dbcontroller = new DBController();
		
			$query ="select TbProdutos.Cod_Produto, TbProdutos.Nome_Produto, TbPrecoProdutos.Preco_Produto from TbProdutos
			inner join TbPrecoProdutos on TbProdutos.Cod_Produto = TbPrecoProdutos.Cod_Preco where Nome_Produto like '%{$nome}%'"; 
				  
				//$query ="exec sp_Desconectar '{$nome}'";
			echo $query;
			$rawData = $dbcontroller->executeSelectQuery($query);
		
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

		
}	




if(isset($_GET["page_incluir"]))
	{
			
		$produtos = new ProdutosRestHandler() ;
		$produtos -> IncluirProdutos();
			
	}
	
	if(isset($_GET["page_lista"]))
	{
			
		$listar = new ProdutosRestHandler() ;
		$listar -> ListarProdutos();
			
	}
	
	

		

?>






