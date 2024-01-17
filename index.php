<?php
session_start();
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new \Routing\Router();
//require_once 'routes.php';
require_once 'function.php';
$self =$_SERVER['PHP_SELF'];
$uri =$_SERVER['REQUEST_URI'];
$uriInfo = explode('/',$uri);

$junk =array_shift($uriInfo);
$controllerName = array_shift($uriInfo);
$uri  =substr($uri,1);
$methodName = array_shift($uriInfo);
$mvcContext = new Core\MvcContext($controllerName, $methodName, $uriInfo);
$app = new \Core\Application($mvcContext, $uri, $_SERVER, $router);
$app->registerDependency(
    \ViewEngine\ViewInterface::class,
    \ViewEngine\View::class
);


$app->registerDependency(
    \Services\Narqd\NarqdServiceInterface::class,
    \Services\Narqd\NarqdService::class
);
$app->registerDependency(
    \Repositories\Narqd\NarqdRepositoryInterface::class,
    \Repositories\Narqd\NarqdRepository::class
);
$app->registerDependency(
    \Repositories\Users\UserRepositoryInterface::class,
    \Repositories\Users\UserRepository::class
);
$app->registerDependency(
    \Repositories\Note\NoteRepositoryInterface::class,
    \Repositories\Note\NoteRepository::class
);
$app->registerDependency(
   \Services\Encryption\EncryptionServiceInterface::class,
    \Services\Encryption\ArgonEncryptionService::class

);
$app->registerDependency(
    \Services\Users\UserServiceInterface::class,
    \Services\Users\UserService::class
);
$app->registerDependency(
    \Services\Note\NoteServiceInterface::class,
    \Services\Note\NoteService::class
);
$app->registerDependency(
    \Database\DatabaseInterface::class,
    \Database\PDODatabase::class
);
$app->registerDependency(
    \Services\Otpuska\OtpuskaServiceInterface::class,
    \Services\Otpuska\OtpuskaService::class
);
$app->registerDependency(
    \Repositories\Otpuska\OtpuskaRepositoryInterface::class,
    \Repositories\Otpuska\OtpuskaRepository::class
);
$app->registerDependency(
    \Repositories\Chat\ChatRepositoryInterface::class,
    \Repositories\Chat\ChatRepository::class
);
$app->registerDependency(
    \Services\Chat\ChatServiceInterface::class,
    \Services\Chat\ChatService::class
);
$app->addBean(
    \Database\DatabaseInterface::class,
    new Database\PDODatabase(new PDO("mysql:dbname=MVC;host=localhost", "root", ""))
);
$app->start();

