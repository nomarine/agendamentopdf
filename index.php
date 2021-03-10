<?php

include 'db_connection.php';
$conn = OpenConAgendamento();
//$conn = OpenConLocal();

require('fpdf.php');
class PDF extends FPDF {
	function ImprovedTable($titulo, $dados)
	{
    // Column widths
    $w = array(25, 115, 50);
    // Header
    for($i=0;$i<count($titulo);$i++)
        $this->Cell($w[$i],7,$titulo[$i],1,0,'C');
    $this->Ln();
    // Data
    while($linha = $dados->fetch_assoc())
    {
        $this->Cell($w[0],10,$linha["start"],'LRB',0,'C');
        $this->Cell($w[1],10,$linha["c_name"],'LRB',0,'L');
        $this->Cell($w[2],10,$linha["c_phone"],'LRB',1,'C');
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
	}

}

$sql = "Select LEFT(start,5) AS start, LEFT(c_name, 40) AS c_name, SUBSTRING(c_phone, 3, 100) AS c_phone, date from appscheduler_bookings_services left join appscheduler_bookings on appscheduler_bookings_services.booking_id = appscheduler_bookings.id where date = '2021-03-09' AND booking_status = 'confirmed' ORDER BY start;";
$resultado = $conn->query($sql);
$linha = $resultado->fetch_assoc();

$data = DateTime::createFromFormat('Y-m-d', $linha["date"]);
$dataformatada = $data->format('d/m/Y');

$pdf = new PDF();

// Column headings
$titulo = array('Horario', 'Cliente', 'Telefone');
// Data loading
$pdf->SetFont('Arial','',14);
$pdf->AddPage();

$pdf->Cell(40,10,"Relatorio do dia: " . $dataformatada);
$pdf->Ln();



$resultado = $conn->query($sql);
$pdf->ImprovedTable($titulo,$resultado);

$pdf->Output();
//$pdf->Output('F', 'C:\Users\rafael\Desktop\teste.pdf', true);

$conn->close();
?>
