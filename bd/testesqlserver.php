	<?php

try{	
	$conn;
	$servidor = "IP SERVIDOR";
	$instancia = "";
	$porta = ;
	$database = "NOME DA DB";
	$usuario = "USER";
	$senha = "PW";

$conn = new PDO( "sqlsrv:Server={$servidor}\\{$instancia},{$porta};Database={$database}", $usuario, $senha );

}  
catch(Exception $e)  
{   
die( print_r( $e->getMessage() ) );   
}  

$query = $conn->prepare("SELECT @@VERSION");
$query->execute();
$resultado = $query->fetchAll();
echo $resultado ['0'] ['0'] ;
?>


<table border="1" width="700" style="text-align:center;">
	<th width="50">COD</th>
	<th width="150">NOME</th>
	<th width="100">TIPO</th>
	<th width="100">QUANTIDADE</th>
	<th width="100">VALOR</th>

 
<?php

$result = $conn->query('select * from dbo.produtos');


while ( $row = $result->fetch(PDO::FETCH_ASSOC )  ) { ?>

	<tr>
		<td width="100"><?php echo  $row['CODIGO_PRODUTO']; ?></td>
		<td width="100"><?php echo  $row['NOME']; ?></td>
		<td width="100"><?php echo  $row['TIPO']; ?></td>
		<td width="100"><?php echo  $row['QUANTIDADE']; ?></td>
		<td width="100"><?php echo  $row['VALOR']; ?></td>
	</tr>
	 

<?php	
}
?>
</table>	
	