<?php
require_once (realpath(dirname(__FILE__)) . '/../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaManager.php');
require_once (Conf::getApplicationManagerPath() . 'CategoriasManager.php');
require_once (Conf::getApplicationManagerPath() . 'EmpregadorManager.php');
require_once (Conf::getApplicationModelPath() . 'CategoriaOferta.php');
$session = SessionManager::existSession('email');
$tipo = SessionManager::existSession('tipoUser');
if ($session && $tipo) {
    if (SessionManager::getSessionValue('tipoUser') !== 'administrador') {
        header('location: ../index.php');
    }
} else {
    if (!$session && isset($_COOKIE['email']) && isset($_COOKIE['password'])) {
        require_once '../VerificaCookies.php';
    } else {
        header('location: ../index.php');
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once '../Application/Validator/CategoriaValidator.php';
        if (count($errors) > 0) {
            require_once __DIR__ . '/AddCategoria.php';
        } else {
            $categoriaMan = new CategoriasManager();
            $categoriaMan->insertOferta(new CategoriaOferta('', $categoria, $target_file));
            ?>
            <h2>Categoria submetida com sucesso</h2>
            <a href="../index.php"><input type="submit" value="Voltar Área Pessoal"></a> 
            <?php
        }
        ?>
    </body>
</html>
