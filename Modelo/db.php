<?php
/**
 * Clase encargada de la conexión con la base de datos y la autenticación de usuarios.
 * 
 * @author Iván Cuevas <ivancs@alumnos.iesgalileo.es>
 * @version ${1:1.0.0}
 * 
 */
Class Db{
    private $host = 'localhost';
    private $db = 'mundial';
    private $user = 'root';
    private $pass = '';
    private $dsn = "mysql:host=$host;dbname=$db";
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_BOTH
    ];

/**
 * Función encargada de conectarse a la base de datos.
 * 
 * @param $dsn Referencia a la base de datos.
 * @param $user Usuario de la base de datos.
 * @param $pass Contraseña del usuario de la base de datos.
 * @param $options Opciones adicionales para la conexión con la base de datos. 
 * @return [PDO] Devuelve un objeto PDO para conectarnos a la base de datos.
 */
public function conexion($dsn, $user, $pass, $options)
{
    try {
        $conexion = new PDO($dsn, $user, $pass, $options);
        return $conexion;
    } catch (PDOException $e) {
        echo "Error al conectar: ", $e->getMessage(), (int)$e->getCode();
    }
}


/**
 * Función encargada de autentificar el usuario de la página web.
 * @param $conexion Objeto PDO con la configuración para conectarse a la base de datos.
 * @param $user Usuario a autenticar.
 * @param $password Contraseña del usuario.
 * 
 * @return [Boolean] Devuelve true si el usuario autentica correctamente, si no, false.
 */
public function autenticacion($conexion, $user, $password)
{
    $sql = 'SELECT user, password FROM usuarios WHERE user = ? AND password = ?';
    $consulta = $conexion->prepare($sql);
    $consulta->bindParam(1, $user);
    $consulta->bindParam(2, $password);
    $consulta->execute();
    $registrosEncontrados = $consulta->rowCount();
    if ($registrosEncontrados > 0) {
        session_start();
        $_SESSION['user'] = $_POST['user'];
        return true;
    }
    return false;
}


}

