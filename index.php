<?php
require('mysql_table.php');
require('db_connection.php');
// Connect to database
$link = OpenConAgendamento();

//Consulta ao DB

$sql = "Select LEFT(start,5) AS start, LEFT(c_name, 40) AS c_name, SUBSTRING(c_phone, 3, 100) AS c_phone, date from appscheduler_bookings_services left join appscheduler_bookings on appscheduler_bookings_services.booking_id = appscheduler_bookings.id where date = '2021-03-09' AND booking_status = 'confirmed' ORDER BY start;";
$resultado = $link->query($sql);
$linha = $resultado->fetch_assoc();

//Formatar data
$data = DateTime::createFromFormat('Y-m-d', $linha["date"]);
$dataformatada = $data->format('d/m/Y');
$GLOBALS['a'] = $dataformatada;

class PDF extends PDF_MySQL_Table
{
function Header()
{
	// Title
	$this->SetFont('Arial','',18);
	$this->Cell(0,6,'Agendamentos do dia: ' . $GLOBALS['a'],0,1,'C');
	$this->Ln(10);
	// Ensure table header is printed
	parent::Header();
}
}

$pdf = new PDF();
//$pdf->AddPage();
// First table: output all columns
//$pdf->Table($link,'select * from relatorio');
$pdf->AddPage();
// Second table: specify 3 columns
$pdf->AddCol('start',20,'Horario','C');
$pdf->AddCol('c_name',115,'Cliente');
$pdf->AddCol('c_phone',40,'Telefone','R');
$prop = array('HeaderColor'=>array(0,0,0),
			'color1'=>array(255,255,255),
			'color2'=>array(224,224,224),
			'textcolor1'=>array(0,0,0),
			'textcolor2'=>array(0,0,0),
			'padding'=>2);
$pdf->Table($link,$sql,$prop);
$pdf->Output();
?>
