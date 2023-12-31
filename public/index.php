<?php

/**
 * public/index.php
 *
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es ETS de Ingeniería de Sistemas Informáticos
 */

require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/controllers.php';

use MiW\Results\Utility\Utils;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\{MethodNotAllowedException, ResourceNotFoundException};
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

Utils::loadEnv(dirname(__DIR__));

// Empleando el componente symfony/config cargamos todas las rutas
$locator = new FileLocator([ dirname(__DIR__) . '/' . $_ENV['CONFIG_DIR'] ]);
$loader  = new YamlFileLoader($locator);
$routes  = $loader->load($_ENV['ROUTES_FILE']);

// obtenemos el contexto de la petición HTTP
$context = new RequestContext(
    $_SERVER['REQUEST_URI'],
    $_SERVER['REQUEST_METHOD']
);

// Obtiene el objeto matcher para la resolución de rutas
$matcher = new UrlMatcher($routes, $context);

// Obtenemos la información asociada a la petición
$path_info = $_SERVER['REQUEST_URI'] ?? '/';

try {
    $parameters = $matcher->match($path_info);
    $action = $parameters['_controller'];
    $param1 = $parameters['name'] ?? null;
    $action($param1);   # ejecutar la acción $action()?

    // echo '<pre>', var_dump($parameters), '</pre>';
} catch (ResourceNotFoundException $e) {
    echo 'Caught exception: The resource could not be found' . PHP_EOL;
} catch (MethodNotAllowedException $e) {
    echo 'Caught exception: the resource was found but the request method is not allowed' . PHP_EOL;
}

// El componente también sirve para mostrar la información de una ruta a través de su nombre
// echo '<br>---' . PHP_EOL . '<pre>Inverso "ruta_admin": ';
// var_dump($routes->get('ruta_admin')->getPath());
// echo '</pre>';
