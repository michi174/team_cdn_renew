<?php
use wsc\application\Application;
use wsc\debug\Debugger;
use wsc\database\Database;
use wsc\acl\Acl;
use wsc\auth\Auth;
use wsc\config\Config;

session_start();
date_default_timezone_set('Europe/Vienna');
setlocale (LC_ALL, 'deu');

require_once '../framework/config.php';
require_once 'autoloader.php';

//Anwendung konfigurieren
$config = Config::getInstance();
$config->readIniFile($config->get("doc_root").'/team_cdn_renew/config/config.ini');
$config->set("abs_project_path", $config->get("doc_root")."/".$config->get("project_dir"));
$config->set("forward_link", $_SERVER['QUERY_STRING']);

//Anwendung starten
$app    = Application::getInstance();

$app->register("Debugger", new Debugger());
$app->register("Database", Database::getInstance());
$app->register("Acl", new Acl($app));
$app->register("Auth", new Auth($app));

try
{
    $db         = $app->load("Database");
    $auth       = $app->load("Auth");
    $acl        = $app->load("Acl");
    $controller = $app->load("FrontController");
}
catch (Exception $e)
{
    die("Es ist ein Fehler aufgetreten in: <br />
    <strong>". $e->getFile()." Zeile: ".$e->getLine()."</strong><br /><br />
    Meldung: <br />".$e->getMessage()."<br /><br />
    Backtrace: <br />".nl2br($e->getTraceAsString(), true));
}

//Controller hinzuf�gen
$blacklist  = array();
$controller->addSubController("head",$blacklist);
$controller->addSubController("header",$blacklist);
$controller->addSubController("content_start",$blacklist);
$controller->addSubController("informations");
$controller->addSubController("content_end",$blacklist);
$controller->addSubController("footer",$blacklist);
$controller->addSubController("livetiles");
$controller->addSubController("tools");

if(isset($_GET['logout']))
{
    $auth->logout();
    $app->load("Response")->redirect($_SERVER['HTTP_REFERER']);
}
if(isset($_POST['login_x']))
{
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $cookie     = (isset($_POST['save_login'])) ? true : false;

    $auth->login($username, $password, $cookie);
}

$app->run();

?>