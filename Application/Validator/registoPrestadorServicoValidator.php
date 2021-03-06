<?php

require_once (realpath(dirname(__FILE__)) . '/../../Config.php');

use Config as Conf;

require_once (Conf::getApplicationDatabasePath() . 'MyDataAccessPDO.php');
require_once (Conf::getApplicationManagerPath() . 'PrestadorManager.php');
require_once (Conf::getApplicationManagerPath() . 'EmpregadorManager.php');

$errors = array();
$input = INPUT_POST;

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    if (filter_has_var($input, 'emailP') && filter_input($input, 'emailP')) {
        $mail = filter_input($input, 'emailP',FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $manager = new PrestadorManager();
        $exist = $manager->verifyEmail($mail);
        $manager1 = new EmpregadorManager();
        $exist1 = $manager1->verifyEmail($mail);
        if ((!empty($exist) && $exist[0]['email'] === $mail) || (!empty($exist1) && $exist1[0]['email'] === $mail)) {
            $errors['emailP'] = 'Email já existe';
        }
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors['emailP'] = 'Email incorrecto';
        }
    } else {
        $errors['emailP'] = 'Parametro email nao existe';
    }
}

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    if (filter_has_var($input, 'nomeP') && filter_input($input, 'nomeP') != '') {
        $name = filter_input($input, 'nomeP',FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        if (strlen($name) < 5) {
            $errors['nomeP'] = 'Pelo menos 5 caracteres no nome';
        }
    } else {
        $errors['nomeP'] = 'Parametro name nao existe';
    }
}

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    if (filter_has_var($input, 'passP') && filter_input($input, 'passP') != '') {
        $pass = filter_input($input, 'passP',FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        if (strlen($pass) < 5) {
            $errors['passP'] = 'Pelo menos 5 caracter na password';
        }
    } else {
        $erros['passP'] = 'Parametro password nao existe';
    }
}

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    if (filter_has_var($input, 'contactoP') && filter_input($input, 'contactoP') != '') {
        $contato = filter_input($input, 'contactoP',FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $pattern = "/9[1236][0-9]{7}|2[1-9][0-9]{7}/";
        if (preg_match($pattern, $contato) === 0 || strlen($contato) !== 9) {
            $errors['contactoP'] = 'Parametro contacto incorreto';
        }
    } else {
        $errors['contactoP'] = 'Parametro contacto nao existe';
    }
}


if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    if (filter_has_var($input, 'codigopostalP') && filter_input($input, 'codigopostalP') != '') {
        $codPostal = filter_input($input, 'codigopostalP',FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
        $pattern = "/^[0-9]{4}-[0-9]{3}/";
        if (preg_match($pattern, $codPostal) === 0 || strlen($codPostal) !== 8) {
            $errors['codigopostalP'] = 'Parametro codigo Postal incorreto';
        }
    } else {
        $errors['codigopostalP'] = 'Parametro codido Postal nao existe';
    }
}

if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    $distrito = filter_input($input, 'distritoP',FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
    if (!(filter_has_var($input, 'distritoP') && filter_input($input, 'distritoP') != '')) {
        $erros['distritoP'] = 'Parametro distrito postal nao existe';
    }
}
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    $concelho = filter_input($input, 'concelhoP', FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
    if (!(filter_has_var($input, 'concelhoP') && filter_input($input, 'concelhoP') != '')) {
        $erros['concelhoP'] = 'Parametro concelho nao existe';
    }
}
if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST') {
    $morada = filter_input($input, 'moradaP', FILTER_SANITIZE_STRING,FILTER_SANITIZE_SPECIAL_CHARS);
    if (!(filter_has_var($input, 'moradaP') && filter_input($input, 'moradaP') != '')) {
        $erros['moradaP'] = 'Parametro morada nao existe';
    }
}
