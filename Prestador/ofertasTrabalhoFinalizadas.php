<?php
require_once (realpath(dirname(__FILE__)) . '/../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationManagerPath() . 'PrestadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'CandidaturaManager.php');
require_once (Conf::getApplicationManagerPath() . 'OfertaManager.php');
require_once (Conf::getApplicationManagerPath() . 'SessionManager.php');
$session = SessionManager::existSession('email');
$tipo = SessionManager::existSession('tipoUser');
if ($session && $tipo) {
    if (SessionManager::getSessionValue('tipoUser') !== 'prestador') {
        header('location: index.php');
    }
} else {
    header('location: index.php');
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>      
        <?php require_once __DIR__ . '/../Application/imports/Header.php'; ?>

        <section id="categorias">
            <?php
            $prestadorMan = new PrestadorManager();
            $prest = PrestadorServico::convertArrayToObject($prestadorMan->verifyEmail(SessionManager::getSessionValue('email'))[0]);
            ?>
            <!--Adicionar Imagem -->
            <img id="fotoPerfil" src="../<?= $prest->getFotoPath() ?>" >
            <p><b>Nome:</b> <?= $prest->getNome() ?></p>
            <p><b>Email:</b> <?= $prest->getEmail() ?></p>
            <p><b>Contato:</b> <?= $prest->getContato() ?></p>
            <p><b>Morada:</b> <?= $prest->getMorada() ?></p>
            <p><b>Código Postal:</b> <?= $prest->getCodPostal() ?></p>
            <p><b>Distrito:</b> <?= $prest->getDistrito() ?></p>
            <p><b>Concelho:</b> <?= $prest->getConcelho() ?></p>
            <a class="button2" id="editarButton" href="verPerfilPrestador.php">Editar dados...</a>
        </section>
        <section id="opcoes">

            <?php
            $man = new PrestadorManager();
            $res = $man->verifyEmail(SessionManager::getSessionValue('email'));
            $manCand = new CandidaturaManager();
            $ofertasMan = new OfertaManager();
            $cand = $manCand->getCandidaturaByIdPrestadorAndStatusCandidatura($res[0]['idPrestador'], 'aceitada');
            ?>
            <h1>Foi aceite nas seguintes Ofertas</h1>
            <?php
            if (!empty($cand)) {
                ?>

                <table>
                    <?php
                    foreach ($cand as $key => $value) {
                        ?>
                        <tr>
                            <td> <?= $ofertasMan->getOfertaByID($value['idOferta'])[0]['tituloOferta'] ?></td>
                            <td><a class="button2" href="../verCandidatura.php?oferta=<?= $value['idOferta'] ?>">Ver Oferta de trabalho</td> 
                        </tr>
                        <?php
                    }
                    ?>
                </table>          
                <?php
            } else {
                ?>
                <p>Não foi o vencedor de nenhuma das ofertas de trabalho</p>
                <?php
            }
            $cand2 = $manCand->getCandidaturaByIdPrestadorAndStatusCandidatura($res[0]['idPrestador'], 'rejeitada');
            ?>
            <h1>Foi Rejeitado nas seguintes Ofertas</h1>
            <?php
            if (!empty($cand2)) {
                ?>

                <table>
                    <?php
                    foreach ($cand2 as $key => $value) {
                        ?>
                        <tr>
                            <td> <?= $ofertasMan->getOfertaByID($value['idOferta'])[0]['tituloOferta'] ?></td>
                            <td><a class="button2" href="../verCandidatura.php?oferta=<?= $value['idOferta'] ?>">Ver Oferta de trabalho</td> 
                        </tr>
                        <?php
                    }
                    ?>
                </table>          
                <?php
            } else {
                ?>
                <p>Não foi o rejeitado em nenhuma das ofertas de trabalho</p>
                <?php
            }
            ?>

        </section>
        <a href="areaPessoalPrestador.php"><button>Voltar</button></a>
    </body>
</html>