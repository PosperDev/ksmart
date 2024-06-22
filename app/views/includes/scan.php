<?php
if (isset($_POST['barcode'])) {
    // Desactivar la generación de warnings
    error_reporting(E_ALL & ~E_WARNING);
    // Se ha enviado el valor del código de barras
    $barcode = $_POST['barcode'];

    // Almacena el código de barras en la sesión
    $_SESSION['barcode'] = $barcode;
    
    function extractPWOCID($barcode)
    {
        if (!is_string($barcode)) {
            return null; // Formato de código de barras inválido
        }

        // Buscar la posición del carácter 'Q' en el código de barras
        $qPos = strpos($barcode, 'Q');
        if ($qPos === false) {
            return null; // El código de barras no contiene 'Q'
        }

        // Calcular la longitud del PWOCID en función de la posición del carácter 'Q'
        $pwocidLength = $qPos - 1;

        // Extraer el PWOCID utilizando la longitud calculada
        $pwocid = substr($barcode, 1, $pwocidLength);

        // Devolver el PWOCID extraído
        return $pwocid;
    }

    $pwocid = extractPWOCID($barcode);

    require '../controllers/Controller.php';

    // Create a Controller instance
    $Controller = new Controller();

    // Attempt query1 using the Controller
    $data = $Controller->runFetchAllData($pwocid);

    if ($data !== false) {
        // Mostrar datos recibidos del Query
    } else {
        echo "Error obteniendo datos de producto.";
    }

    $ip = $_SESSION['ip']; //'192.168.10.99'
    $port = $_SESSION['port']; //9100

    $conn = fsockopen($ip, $port, $errno, $errstr);
    if (!$conn) {
        echo 'No se pudo conectar, revise la configuracion IP o puerto';
        exit();
    }

    $project = $data['contractData']['Description'];

    if (strlen($project) <= 28) {
        $part1 = $project;
        $part2 = '';
        $part3 = '';
    } elseif (strlen($project) <= 56) {
        $part1 = substr($project, 0, 28);
        $part2 = substr($project, 28);
        $part3 = '';
    } else {
        $part1 = substr($project, 0, 28);
        $part2 = substr($project, 28, 28);
        $part3 = substr($project, 56);
    }

    $logos = '^FO0,0^GFA,04608,04608,00048,:Z64:eJztlzFv20YUx+9MRRRqg5SHIh2cnr9BvBQV0CL05tUZvDtogawKiqJD3ZCBBgkIYH+EZk2H9iOYhmJ7CVJ0NwoKGmp0kBgkA9sQ9/p/R8q2SAWktg5+9Pkg8qcfj4/vjqIQt3Ebt5FHMAiC1mAwaLXEoAa+fnrvtHHv9I+L9sadixr8V2Nv7HjTD7rzwE1q8N+df/FX4/udd7T1tdutwf846Uycy+fPDzvaqTP+H866Z2vbst/sHmzUwMU3k+7E+dvqOd3J5y9q8I+/7Z5t+JZ98OSViivpSEwm0WSDekfp6I2qzI8MxdnBo9cbO307fvRnozI/K5ti8nT0poPhR2MtKvnmPvwnF23LbnbPn1bzDvwp/fxheugk08P7URXf2JSvfyL1lpprT85sP6ziW5sS99Uda8fBXfaCKr7driLmo9NZjt9a0r+5hH/9oRDbbbG3tyfRhNzbRRP4LNZ3P90V+JuLVaJIhC1BRM/QgvukhUuRhd1e4iUCH+fCJYplYPgTtNAnEooiG7v9WMWyyHs4YGX8mHk+h0cRa7zYS6wir5gXDXnT71PsGr8X4zxlvxOsydzP3wmIEvAJX4FLOpjj4Ysb135u7OfT+pHP5yn5o5ZoWrl/nPljL/ODL4yf/W3RnPmH7Kdrvyr6SVPUESsWTeGegp+a8Xua/RSpkh+afWFJkEM6xyaxqVglKvZDP1Kjoj/2okhYPbreLM2Z94zfG5f8UmKBsFANfZhtkkJqhcyvt43/pOiHPBCyZ/geHVEg4Efm+dACP3gb3RDuPlnwC2Gl7MehEGc4KfMOujHczLvM8/gNT5Ff8oeC1+MdmG26a/w2/H4sJPjQH5b9PLmmdKRdUmiozdSDd/ISNyKi3jwPidhC/5hUapuG2mf/iN4af4mPxD76L0klLvJi/An76R384SL/Nvq7pEJbq9DwuFrjlygpa563wIfoPX2cwp/M/CimMW7JswV+GaBXWqW4zhT1GCL7kT+kkfHbRX9gMQ+35qZ4XYhzf1ZMBX9giYwnN/Vv+semVMv+FXHTr38JvH+R92HuPyrxTe5tXK1KecumKDLJUwHTdDHvauY5QzkfwG/BX+JFI/Pb6cyPKT0Cf27Ktew/nI0H2U+9pDWgjP9d83Qo8JhPac6nmLOmGf8J/FyylBb4ntlhcfUkZkvNMoTppm1Mh5K/n/NwxwrjufL3yfDzfpemV7yx87qTLXNH9Jte4M8EduZP4P4HVT8C3wfLRVXwU5L589EzH+R+4pQt9ls8dq57Qt0HPvN8SCV2yZ+Ph+3HyTGP/cqfftRvYwX0+YnCy7Qwy7TNy25cGP+soJjnVc278muL+aJf+vQ+52P2Q4qS4kcBHo1IVKzm/eKYfjXXcWnW4+QT0qtm3aFLPBoC/7LgR5h6Xivu/XiY+dWqz5v5+9kSfIB/S/xAMevPMj+AIrTNJfjtvNWNS7RwCb6dX0PdeJDntG7g+VjrlWIWq5Go80Z0FfL9neo3ipvh0YuleLlbzczFEtX5/4n/ADLV4SI=:7A87^FO480,1088^GFA,02560,02560,00040,:Z64:eJztlLFu1EAQhsdZIUtExLwAup4niJTCPAIFJ16DJ7AXUSBBkVe4MnKalNG5MVWeIB2FURqLhkURipVb7TAzvr2s7bNpKW6K9e569Pn3P7MLcIhDdKHur9dnXy9XND0uyzWosixXsJZXV2elrDji3zZbnN/UNF0g4htFg4ms5BnewUryko116fkvzktos+G8FtwJ89uU8+p9PBPTYCMb86uQF9+3nse7LfMcuETTd2d4lvOQeNWQt2lDfU7ytEvaGV4FBDIAubaxZZ7swUgfDU4RKCWeYx5Nd3nM++x5kCmGfLQxsn8Bb+tfw9OQh5r8C7/b0weZiPpGvGqgb7NfHxrR1+clu/91LCplfWaSl/wsLp16vCjYPyrKmDesB9j4Aaf98/VFqu8dapFa7+cZX98fWO3zz9d31y8NNpP+cXP4/qtzM6dvxbyGeHXqJv/3dvkO1J/3yG1TxzjpX601mfaFSku8Y/w0U182LdfkXx3hzUz/cRFS4QHezfQfN92iYn2QP8z0n/Bq4aXY1/c9e/Wip2/L45YJ8gw4OEpCfUnHU32egaw7Wjt9sRFe1OfRZULS2kAfLZgH/+S17B8d45E+UI+BPrXlpb3+E57C5fKt50XSL4P7IBF9cut5fUr6rxM90BdxnvfP86KxPpC8LQ9cpw/GPMg9jw9F3vHgw8g/KuaTPuDzy/PTMe9Zj6c73ssg72gFBT+K4uK57tbwWhf84JC9Q/xf8Rc5TUvq:5F61';

    // Datos de etiqueta que se obtuvieron para imprimir
    $impData = '^XA~TA000~JSN^LT0^MNW^MTT^PON^PMN^LH0,0^JMA^PR6,6~SD15^JUS^LRN^CI0^XZ
^XA
^MMT
^PW812
^LL1218
^LS0'.$logos.'
^FO35,928^BY4,2.0,10^BQN,2,10^FDQA,' . $barcode . '^FS
^FT17,170^A0N,37,36^FH\^FDProyecto:^FS
^FO7,120^GB800,172,1^FS
^FT257,176^A0N,37,36^FH\^FD' . $part1 . '^FS
^FT257,222^A0N,37,36^FH\^FD' . $part2 . '^FS
^FT257,268^A0N,37,36^FH\^FD' . $part3 . '^FS
^FT40,240^A0N,37,36^FH\^FD' . $data['contractData']['Name'] . '^FS
^FO23,195^GB204,60,1^FS
^FT17,361^A0N,37,36^FB500,1,0,L^FH\^FDPerfil: ' . $data['markData']['MainMemberItemName'] . '^FS
^FT17,407^A0N,37,36^FB500,1,0,L^FH\^FDFase: ' . $data['phaseData'] . '^FS
^FT17,453^A0N,37,36^FB500,1,0,L^FH\^FDLote: ' . $data['lotData'] . '^FS
^FT17,518^A0N,37,36^FH\^FDLongitud: ' . $data['markData']['MainMemberLength'] . 'mm^FS
^FT452,518^A0N,37,36^FH\^FD\B5rea: ' . $data['markMainData']['Area'] . '^FS
^FT452,564^A0N,37,36^FH\^FD(m\FD)^FS
^FT42,564^A0N,37,36^FB400,1,0,L^FH\^FDPeso: ' . $data['markMainData']['Weight'] . '^FS
^FT42,610^A0N,37,36^FB111,1,0,L^FH\^FD(kg)^FS
^FT42,656^A0N,37,36^FB111,1,0,R^FH\^FDBundle:^FS
^FT183,817^A0N,135,134^FH\^FD' . $data['markData']['Name'] . '^FS
^FT338,868^A0N,37,36^FB137,1,0,C^FH\^FD' . $data['markData']['Description'] . '^FS
^FT307,1053^A0N,62,62^FH\^FD' . $barcode . '^FS 
^FT307,1113^A0N,45,45^FB201,1,0,C^FH\^FD' . '' . '^FS
^FT294,1206^A0N,28,28^FB224,1,0,C^FH\^FD' . '' . '^FS
^PQ1,0,1,Y^XZ';

    //echo $impData;
    
    // Enviamos los datos a la impresora
    $fput = fwrite($conn, $impData, strlen($impData));
    if ($fput === false) {
        echo "Error al enviar datos a la impresora.";
        exit();
    }

    // Actualizar la última actividad del usuario después de una interacción
    $_SESSION['last_activity'] = time();

    // Cerramos la conexión
    fclose($conn);

    // Reactivar la generación de warnings
    error_reporting(E_ALL);

    // Redirigir al usuario a una página limpia sin datos POST
    header("Location: index.php");
    exit();
}
?>