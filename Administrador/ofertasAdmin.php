<?php
require_once (realpath(dirname(__FILE__)) . '/../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationManagerPath() . 'EmpregadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaManager.php');
require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
$session = SessionManager::existSession('email');
$tipo = SessionManager::existSession('tipoUser');
if ($session && $tipo) {
    if (SessionManager::getSessionValue('tipoUser') !== 'administrador') {
        header('location: ../index.php');
    }
} else {
    header('location: ../index.php');
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" href="../Application/Styles/verCSS.css"/>
        <script src="../Application/Libs/jquery-2.2.4.js"></script>
        <script src="../Application/JS/adminOfertasJS.js"></script>
    </head>
    <body id="adminT">
        <?php
        $manOfer = new OfertaManager();
        $res = $manOfer->getOfertas();
        ?>
        <table id="tableOfertas" border="1">
            <h1>Lista Ofertas</h1>
            <th> Titulo </th>
            <th> Estado </th>
            <th> Tipo </th>
            <th> Data Limite</th>
            <th> Opcao</th>
            <?php
            foreach ($res as $key => $value) {
                ?>
                <tr id="<?= $value['idOferta'] ?>">
                    <td><?= $value['tituloOferta'] ?></td>
                    <td><?= $value['statusO'] ?></td>
                    <td><?= $value['tipoOferta'] ?></td>
                    <td><?= $value['dataFim'] ?></td>
                    <td><input class="eliminarOferta" type="button" value="Eliminar"><input class="opcao" type="button" value="<?= ($value['statusO'] === 'desativada') ? 'Ativar' : 'Desativar' ?>"></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>