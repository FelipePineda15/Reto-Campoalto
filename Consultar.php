<?php
include "Clases/Conexion.php";
include "Clases/Usuario.php";

$ObjConexion = new Conexion;
$ObjUsuario = new Usuario;

$Conexion = $ObjConexion->Conectar();
$Datos = $ObjUsuario->ConsultarDocumento($Conexion, $_POST['Documento']);
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <title>CAMPOALTO</title>
        <link rel="alternate" type="application/rss+xml" title="Latin Sport F.C – Escuela de Fútbol » Feed" href="">
        <link rel="alternate" type="application/rss+xml" title="Latin Sport F.C – Escuela de Fútbol » RSS de los comentarios" href="">
        <script src="http://www.campoalto.edu.co/campoalto/hermesoft/portalIG/home_1/recursos/recursos2010/23112010/campo.jpg" type="text/javascript"
        defer=""></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="Formato.css">   
    </head>
    <body>
        <table border="1" class="tabla table">

            <tr>
                <th>Documento</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Programa</th>
                <th>Semestre</h>                
            </tr>

            <?php
            $sql = "SELECT Documento, Nombres, Apellidos, Direccion, Telefono, Celular, Email, Nombre_Programa, Numero_Semestre "
                    . "FROM Estudiante INNER JOIN Programa ON Programa.ID_Programa = Estudiante.ID_Programa "
                    . "INNER JOIN semestre ON Semestre.ID_Semestre = Estudiante.ID_Semestre "
                    . "INNER JOIN pago ON pago.ID_Estudiante = estudiante.ID_Estudiante WHERE Documento = 1019120851";
            $Dato = mysqli_query($Conexion, $sql);
            while ($dato = mysqli_fetch_array($Dato)) {
                ?>
                <tr>
                    <td><?php echo $dato['Documento'] ?></td>
                    <td><?php echo $dato['Nombres'] ?></td>
                    <td><?php echo $dato['Apellidos'] ?></td>
                    <td><?php echo $dato['Direccion'] ?></td>
                    <td><?php echo $dato['Telefono'] ?></td>
                    <td><?php echo $dato['Celular'] ?></td>
                    <td><?php echo $dato['Email'] ?></td>
                    <td><?php echo $dato['Nombre_Programa'] ?></td>
                    <td><?php echo $dato['Numero_Semestre'] ?></td>                  
                </tr>
                <br>                   
                <?php
            }
            ?>                
        </table>   
        <p align="center"><a href="tcpdf/Factura.php?Documento=<?php echo $dato['Documento']; ?>"><input type="submit" value="PDF" title="PDF" class="login-button"></a></p>
        <p align="center"><a href="Index.php"> <input type="submit" value="Volver" title="Volver" class="login-button"></a></p>
    </body>
</html>