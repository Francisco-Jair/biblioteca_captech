<?php
date_default_timezone_set('America/Sao_Paulo');
$json = file_get_contents("php://input");
$dados = json_decode($json);

$date = date('ymd_his');

$nomeArquivo = __DIR__ . "/dados_" . $date . '.txt';
$file = fopen($nomeArquivo, "w+");
fwrite($file, $json);

$caminhoFisicoDoCliente = __DIR__.'/../';
$repositorioGitDoCliente = null;

if(is_null($repositorioGitDoCliente))
    die('Configure $repositorioGitDoCliente');

$comandos[] = 'cd '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.' && git reset --hard HEAD && git pull';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/resources '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/database '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/config '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/bootstrap '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/app '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/tests '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/composer.phar '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/composer.json '.$caminhoFisicoDoCliente.'';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/pull '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/site '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/ckeditor '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/admin '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/filemanager '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/index.php '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/robots.txt '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cp -R '.$caminhoFisicoDoCliente.''.$repositorioGitDoCliente.'/aplicacao/public_html/favicon.ico '.$caminhoFisicoDoCliente.'public_html/';
$comandos[] = 'cd '.$caminhoFisicoDoCliente.'public_html/ && php56 composer.phar dump-autoload';

foreach ($comandos as $comando) {
    shell_exec($comando);
}

$nomeArquivo = __DIR__ . "/dados_" . $date . '.payload';
$file = fopen($nomeArquivo, "w+");
fwrite($file, json_encode($comandos));