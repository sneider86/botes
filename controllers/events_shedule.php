<?php
require_once '../config/configbd.php';
$con = new mysqli($bd['host'],$bd['user'],$bd['pass'],$bd['data']);
$con->set_charset("utf8");
$sql = "SELECT s.id as idAgenda,startdate,
DAY(startdate) as dia,MONTH(startdate) as mes,YEAR(startdate) as anio,
HOUR(startdate) as hora,MINUTE(startdate) as minuto,SECOND(startdate) as segundos,
cant,p.nombre as nombrePlan,c.nombre as nombreCliente,c.apellido,c.telefono,
c.direccion,c.email,documento,b.nombre as nombreBote,o.totalorden,IF(p.franjahoraria=1,'Día','Noche') AS horario,o.id as idOrden,o.codigoreserva,s.descripcion 
FROM wp_es_solution_shedule s
INNER JOIN wp_es_planes p ON(p.id=s.idplan) 
INNER JOIN wp_es_clientes c ON(s.cliente=c.id)
INNER JOIN wp_es_botes b ON(idbote=b.id)
INNER JOIN wp_es_orden o ON(o.reserva=s.id)
WHERE s.estado = 'A'";
$result = $con->query($sql);
$data = array();
if($result->num_rows>=1){
    while($row = $result->fetch_assoc()){
        $abono = getTotalAbonado($con,$row['idAgenda']);
        $saldo = $row['totalorden'] - $abono;
        $idOrden = $row['idOrden'];
        $codigoReserva = $row['codigoreserva'];
        $sql = "SELECT nombre,cant,a.precio FROM wp_es_ordendetalle d INNER JOIN wp_es_adicionales a ON(a.id=d.iditem) WHERE idorden=$idOrden";
        $rscat = $con->query($sql);
        $catering = array();
        if($rscat->num_rows>=1){
            while($item = $rscat->fetch_assoc()){
                $catering[] = array(
                    'nombre'=> $item['nombre'],
                    'cant'  => $item['cant'],
                    'precio'=> '$'.number_format($item['precio'],0,'.',','),
                    'total'=> '$'.number_format( ($item['precio']*$item['cant']),0,'.',','),
                    
                );

            }
        }
        $data[] = array(
            'documento' => $row['documento'],
            'nombre'    => $row['nombreCliente'],
            'apellido'  => $row['apellido'],
            'email'     => $row['email'],
            'title'     => $row['nombrePlan'],
            'year'      => $row['anio'],
            'month'     => $row['mes']-1,
            'day'       => $row['dia'],
            'hour'      => $row['hora'],
            'min'       => $row['minuto'],
            'bote'      => $row['nombreBote'],
            'npersona'  => $row['cant'],
            'horario'   => $row['horario'],
            'id'        => $row['idAgenda'],
            'observa'   => $row['descripcion'],
            'total'     => '$'.number_format($row['totalorden'],0,'.',','),
            'allDay'    => true,
            'abono'     => '$'.number_format($abono,0,'.',','),
            'saldo'     => '$'.number_format($saldo,0,'.',','),
            'catering'      => $catering,
            'codigoreserva' => $codigoReserva
        );
    }
}
echo json_encode( array("response"=>'success','data'=> $data ) );
function getTotalAbonado($con,$reserva){
    $sql = "SELECT SUM(a.abono) AS abono FROM wp_es_abonos a INNER JOIN wp_es_orden o ON(a.idorden=o.id AND o.reserva=$reserva)";
    $result = $con->query($sql);
    if($result->num_rows>=1){
        $row = $result->fetch_assoc();
        return $row['abono'];
    }else{
        return 0;
    }
}
$con->close();
?>
