<?php

include '../Clases/Conexion.php';
include '../Clases/Usuario.php';
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
require_once('conexion.php');
require_once './tcpdf/barcodes.php';

$ObjConexion = new Conexion();
$ObjUsuario = new Usuario();

$Documento = $_GET['Documento'];
$Conexion = $ObjConexion->Conectar();
$Datos = $ObjUsuario->Consultar($Conexion, $Documento);

$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('PDF Autogenerado en PHP'); //Titlo del pdf
$pdf->setPrintHeader(false); //No se imprime cabecera
$pdf->setPrintFooter(false); //No se imprime pie de pagina
$pdf->SetMargins(20, 20, 20, false); //Se define margenes izquierdo, alto, derecho
$pdf->SetAutoPageBreak(true, 20); //Se define un salto de pagina con un limite de pie de pagina
$pdf->addPage();

$sql = "SELECT Documento, Nombres, Apellidos, Nombre_Programa, Numero_Semestre, Valor_Pago, Valor_Semestre FROM Estudiante INNER JOIN Programa ON Programa.ID_Programa = Estudiante.ID_Programa INNER JOIN semestre ON Semestre.ID_Semestre = Estudiante.ID_Semestre INNER JOIN pago ON pago.ID_Estudiante = estudiante.ID_Estudiante WHERE Documento = 1019120851";
$Datos = mysqli_query($Conexion, $sql);
$html = '';
$item = 1;

while ($row = mysqli_fetch_array($Datos)) {
    $Documento = $row['Documento'];
    $Nombres = $row['Nombres'];
    $Apellidos = $row['Apellidos'];
    $Nombre_Programa = $row['Nombre_Programa'];
    $Numero_Semestre = $row['Numero_Semestre'];
    $Valor_Semestre = $row['Valor_Semestre'];
    $Valor_Pago = $row['Valor_Pago'];
    $FechaLimite = date("Ymd");
    $barcode = '(420)7709998075146(8020)'.$Documento.'(3900)'.$Valor_Pago.'(96)'.$FechaLimite;
    $Barcode = $pdf->serializeTCPDFtagParameters(array($barcode, 'C128', '', '', 72, 25, 0.5,
        array('position' => 'S', 'border' => false, 'padding' => 2, 'fgcolor' => array(0, 0, 0), 'bgcolor' => array(255, 255, 255), 'text' => true, 'font' => 'helvetica', 'fontsize' => 7, 'stretchtext' => 6), 'N'));

    $html .= '<page_header>
        <table>
            <tr>
                <td>
                <p align="left"><img src="https://www.cmasdcomunicacion.com/wp-content/uploads/2016/12/Clientes-cmasd-Campoalto.jpg" width="100" height=100></p>
                </td>
                <td>
                    <span id="span1"> CAMPOALTO</span>
                    <br>
                    <span id="span2">Inspiramos tu futuro </span>
                    <br>
                    <span>Fecha: '. date("d/m/Y").'</span>
                </td>
            </tr>
        </table>
    </page_header>
    <p align="center"><b> DATOS DEL ESTUDIANTE </b></p>
        <table border="1" cellpadding="5">
                                        <tr>
						<td width="100" bgcolor="#E6E6E6"><b>Documento: </b></td>
						<td width="220">' . $Documento . '</td>
					</tr>
					<tr>
						<td width="100" bgcolor="#E6E6E6"><b>Nombres: </b></td>
						<td width="220">' . $Nombres . '</td>
					</tr>
					<tr>
						<td bgcolor="#E6E6E6"><b>Apellidos: </b></td>
						<td>' . $Apellidos . '</td>
					</tr>
					<tr>
						<td bgcolor="#E6E6E6"><b>Programa: </b></td>
                                                <td>' . $Nombre_Programa . '</td>
					</tr>
					<tr>
						<td bgcolor="#E6E6E6"><b>Semestre: </b></td>
                                                <td>' . $Numero_Semestre . '</td>
					</tr>										
	</table><br><br><br>
    <p align="center"><b> CONCEPTOS DE COBRO </b></p>
        <table border="1" cellpadding="5">
					<tr>
						<td width="100" bgcolor="#E6E6E6"><b>Valor Semestre: </b></td>
						<td width="220">' . $Valor_Semestre . '</td>
					</tr>
					<tr>
						<td bgcolor="#E6E6E6"><b>Valor Cuota: </b></td>
						<td>' . $Valor_Pago . '</td>
					</tr>
                                        <tr>
						<td bgcolor="#E6E6E6"><b>Saldo: </b></td>
						<td>' . ($Valor_Semestre-$Valor_Pago). '</td>
					</tr>
                                        <tr>
						<td bgcolor="#E6E6E6"><b>Barcode: </b></td>
						<td><tcpdf method="write1DBarcode" params="' . $Barcode . '" /></td>
					</tr>
															
	</table><br><br><br>';

    $item = $item + 1;
}

$pdf->SetFont('Helvetica', '', 10);
$pdf->writeHTML($html, true, 0, true, 0);

$pdf->lastPage();
$pdf->output('Factura.pdf', 'I');