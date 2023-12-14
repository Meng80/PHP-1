<?php

/**
 * ResultsDoctrine - controllers.php
 *
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;


function funcionHomePage(): void
{
    global $routes;

    $rutaListado = $routes->get('ruta_user_list')->getPath();
    $rutaAgregarUsersFrom = $routes->get('ruta_agregar_usuario_form')->getPath();
    $rutaEliminarUsuarioForm = $routes->get('ruta_eliminar_usuario_form')->getPath();
    $rutaModificarUsuarioForm = $routes->get('ruta_modificar_usuario_form')->getPath();
    $rutaResults = $routes->get('ruta_result_list')->getPath();
    $rutaCrearResults = $routes->get('ruta_crear_result_form')->getPath();
    $rutaEliminarResults = $routes->get('ruta_eliminar_result_form')->getPath();
    $rutaBuscarResults = $routes->get('ruta_buscar_result_form')->getPath();
    echo <<< MARCA_FIN
    <ul>
        <li><a href="$rutaListado">Listado Usuarios</a></li>
        <li><a href="$rutaAgregarUsersFrom">Add Usuarios</a></li>
        <li><a href="$rutaEliminarUsuarioForm">Eliminar Usuario</a></li>
        <li><a href="$rutaModificarUsuarioForm">Modificar Usuario</a></li>
         &nbsp;
        <li><a href="$rutaResults">Listado Rsultados</a></li>
        <li><a href="$rutaCrearResults">Crear Rsultados</a></li>
        <li><a href="$rutaEliminarResults">Eliminar Rsultados</a></li>
        <li><a href="$rutaBuscarResults">Buscar Rsultados</a> </li>
    </ul>
    MARCA_FIN;
}

function funcionListadoUsuarios(): void
{
    $entityManager = DoctrineConnector::getEntityManager();

    $userRepository = $entityManager->getRepository(User::class);
    $users = $userRepository->findAll();

    echo '<h2>Listado de Usuarios</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Nombre</th><th>Email</th></tr>';

    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . $user->getId() . '</td>';
        echo '<td>' . $user->getUsername() . '</td>';
        echo '<td>' . $user->getEmail() . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

function funcionUsuario(string $name): void
{
    echo $name;  //php -S 127.0.0. -t ?
}

function funcionAgregarUsuarioForm(): void
{
    echo '<h2>Agregar Usuario</h2>';
    echo '<form action="/users/agregar" method="post">';
    echo 'Nombre: <input type="text" name="username"><br>';
    echo 'Email: <input type="text" name="email"><br>';
    echo 'Password: <input type="text" name="password"><br>';
    echo '<input type="submit" value="Agregar Usuario">';
    echo '</form>';
}

function funcionAgregarUsuario(): void
{

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $existingUser = $userRepository->findOneBy(['email' => $email]);
        if ($existingUser) {
            echo 'Error: El correo electrónico ya existe.';
            return;
        }
        $user = new User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword($password);

        $entityManager->persist($user);
        $entityManager->flush();

        echo 'Usuario agregado con éxito. Detalles del usuario:';
        echo '<ul>';
        echo '<li>Nombre: ' . $user->getUsername() . '</li>';
        echo '<li>Email: ' . $user->getEmail() . '</li>';
        echo '<li>ID: ' . $user->getId() . '</li>';
        echo '</ul>';
    } else {
        echo 'Error al procesar el formulario.';
    }
}

function funcionEliminarUsuarioForm(): void
{
    echo '<h2>Eliminar Usuario</h2>';
    echo '<form action="/users/eliminar" method="post">';
    echo 'ID del Usuario a Eliminar: <input type="text" name="userId"><br>';
    echo '<input type="submit" value="Eliminar Usuario">';
    echo '</form>';
}

function funcionEliminarUsuario(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);

        $userId = $_POST['userId'];
        $user = $userRepository->find($userId);

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();
            echo 'Usuario eliminado con éxito.';
        } else {
            echo 'Error: No se encontró un usuario con el ID proporcionado.';
        }
    } else {
        echo 'Error al procesar el formulario.';
    }
}

function funcionModificarUsuarioForm(): void
{
    echo '<h2>Modificar Usuario</h2>';
    echo '<form action="/users/modificar" method="post">';
    echo 'ID del Usuario a Modificar: <input type="text" name="userId"><br>';
    echo 'Nuevo Nombre: <input type="text" name="newUsername"><br>';
    echo 'Nuevo Email: <input type="text" name="newEmail"><br>';
    echo 'Nuevo Password: <input type="text" name="newPassword"><br>';
    echo '<input type="submit" value="Modificar Usuario">';
    echo '</form>';
}

function funcionModificarUsuario(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);

        $userId = $_POST['userId'];
        $user = $userRepository->find($userId);

        if ($user) {
            if (isset($_POST['newUsername'])) {
                $user->setUsername($_POST['newUsername']);
            }
            if (isset($_POST['newEmail'])) {
                $user->setEmail($_POST['newEmail']);
            }
            if (isset($_POST['newPassword'])) {
                $user->setPassword($_POST['newPassword']);
            }

            $entityManager->flush();
            echo 'Usuario modificado con éxito.';
        } else {
            echo 'Error: No se encontró un usuario con el ID proporcionado.';
        }
    } else {
        echo 'Error al procesar el formulario.';
    }
}


function funcionListadoResult(): void
{
    $entityManager = DoctrineConnector::getEntityManager();
    $resultRepository = $entityManager->getRepository(Result::class);
    $results = $resultRepository->findAll();

    echo '<h2>Listado de Result</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID</th><th>Results</th><th>UserID</th><th>DateTime</th></tr>';

    foreach ($results as $result) {
        echo '<tr>';
        echo '<td>' . $result->getId() . '</td>';
        echo '<td>' . $result->getResult() . '</td>';
        echo '<td>' . $result->getUser()->getId(). '</td>';
        echo '<td>' . $result->getTime()->format('Y-m-d H:i:s') . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}


function funcionCrearResultForm(): void
{
    echo <<<HTML
        <h2>Create Result</h2>
        <form action="/results/crear" method="post">
            <label for="result">Result:</label>
            <input type="text" name="result" required>
            <label for="userId">User ID:</label>
            <input type="text" name="userId" required>
            <input type="submit" value="Create Result">
        </form>
HTML;
}

function funcionCrearResult(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['result'], $_POST['userId'])) {
        $entityManager = DoctrineConnector::getEntityManager();
        $userId = (int)$_POST['userId'];
        $user = $entityManager->find(User::class, $userId);

        if ($user !== null) {
            $result = new Result(
                (int)$_POST['result'],
                $user,
                new DateTime()
            );
            try {
                $entityManager->persist($result);
                $entityManager->flush();

                echo 'Result created successfully. Detalles del resultado:';
                echo '<ul>';
                echo '<li>ID: ' . $result->getId() . '</li>';
                echo '<li>Resultado: ' . $result->getResult() . '</li>';
                echo '<li>ID del Usuario: ' . $result->getUser()->getId() . '</li>';
                echo '<li>Fecha y Hora: ' . $result->getTime()->format('Y-m-d H:i:s') . '</li>';
                echo '</ul>';
            } catch (\Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            echo 'Error: User not found.';
        }
    } else {
        echo 'Error: Invalid request.';
    }
}

function funcionEliminarResultForm(): void
{
    echo <<<HTML
        <h2>Delete Result</h2>
        <form action="/results/eliminar" method="post">
            <label for="userId">User ID:</label>
            <input type="text" name="userId" required>
            <input type="submit" value="Delete Result">
        </form>

HTML;
}

function funcionEliminarResult(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
        $userId = (int)$_POST['userId'];

        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($userId);

        if ($user) {
            $resultRepository = $entityManager->getRepository(Result::class);
            $results = $resultRepository->findBy(['user' => $user]);

            foreach ($results as $result) {
                $entityManager->remove($result);
            }
            $entityManager->flush();

            echo 'Results for User ID ' . $userId . ' deleted successfully.';
        } else {
            echo 'Result not found.';
        }
    } else {
        echo 'Error: Invalid request.';
    }
}

function funcionBuscarResultForm(): void
{
    echo <<<HTML
        <h2>Buscar Result</h2>
        <form action="/results/buscar" method="post">
            <label for="userId">User ID:</label>
            <input type="text" name="userId" required>
            <input type="submit" value="Buscar Result">
        </form>
HTML;
}

function funcionBuscarResult(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
        $userId = (int)$_POST['userId'];

        $entityManager = DoctrineConnector::getEntityManager();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->find($userId);

        if ($user) {
            $resultRepository = $entityManager->getRepository(Result::class);
            $results = $resultRepository->findBy(['user' => $user]);

            echo '<h2>Resultados para el ID de usuario ' . $userId . '</h2>';
            if (count($results) > 0) {
                echo '<table border="1">';
                echo '<tr><th>ID</th><th>Results</th><th>UserID</th><th>DateTime</th></tr>';

                foreach ($results as $result) {
                    echo '<tr>';
                    echo '<td>' . $result->getId() . '</td>';
                    echo '<td>' . $result->getResult() . '</td>';
                    echo '<td>' . $result->getUser()->getId() . '</td>';
                    echo '<td>' . $result->getTime()->format('Y-m-d H:i:s') . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo 'No se encontraron resultados para el ID de usuario ' . $userId . '.';
            }
        } else {
            echo 'Error: No se encontró un usuario con el ID proporcionado.';
        }
    } else {
        echo 'Error: Invalid request.';
    }
}






