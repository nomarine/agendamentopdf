<?php

include 'db_connection.php';
$conn = OpenCon();

require('fpdf.php');
class PDF extends FPDF {
	function ImprovedTable($titulo, $dados)
	{
    // Column widths
    $w = array(25, 35, 40, 50);
    // Header
    for($i=0;$i<count($titulo);$i++)
        $this->Cell($w[$i],7,$titulo[$i],1,0,'C');
    $this->Ln();
    // Data
    while($linha = $dados->fetch_assoc())
    {
        $this->Cell($w[0],6,$linha["horario"],'LR');
        $this->Cell($w[1],6,$linha["cliente"],'LR');
        $this->Cell($w[2],6,$linha["telefone"],'LR');
		$this->Cell($w[3],6,$linha["servico"],'LR');
        $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
	}

}

$sql = "SELECT * FROM relatorio WHERE data='2021-03-10'";
$resultado = $conn->query($sql);
$linha = $resultado->fetch_assoc();

$pdf = new PDF();

// Column headings
$titulo = array('Horario', 'Cliente', 'Telefone', 'Servico');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->Cell(40,10,$linha["data"]);
$pdf->Ln();

$resultado = $conn->query($sql);
$pdf->ImprovedTable($titulo,$resultado);

$pdf->Output();

$conn->close();
?>
