<?php
class Admin extends Controller
{
    // Constructor que inicia la sesión y llama al constructor de la clase padre
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    // Método que redirige a la página de inicio si el usuario ya está autenticado
    public function index()
    {
        if (!empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin/home');
            exit;
        }
        // Configura el título y carga la vista de login
        $data['title'] = 'Acceso al sistema';
        $this->views->getView('admin', "login", $data);
    }

    // Método para validar las credenciales del usuario
    public function validar()
    {
        if (isset($_POST['email']) && isset($_POST['clave'])) {
            if (empty($_POST['email']) || empty($_POST['clave'])) {
                // Respuesta si faltan campos
                $respuesta = array('msg' => 'todos los campos son requeridos', 'icono' => 'warning');
            } else {
                $data = $this->model->getUsuario($_POST['email']);
                if (empty($data)) {
                    // Respuesta si el correo no existe
                    $respuesta = array('msg' => 'el correo electrónico no existe', 'icono' => 'warning');
                } else {
                     // Verifica la contraseña
                    if (password_verify($_POST['clave'], $data['clave'])) {
                        $_SESSION['email'] = $data['correo'];
                        $_SESSION['nombre_usuario'] = $data['nombres'];
                        // Respuesta si los datos son correctos
                        $respuesta = array('msg' => 'datos correcto', 'icono' => 'success');
                    } else {
                        // Respuesta si los datos no son correctos -- Se deja general por seguridad
                        $respuesta = array('msg' => 'credenciales incorrectas', 'icono' => 'warning');
                    }
                }
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        die();
    }

    // Método que muestra la página principal si el usuario está autenticado
    public function home()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $data['title'] = 'administracion';
        $data['pendientes'] = $this->model->getTotales(1);
        $data['procesos'] = $this->model->getTotales(2);
        $data['finalizados'] = $this->model->getTotales(3);
        $data['productos'] = $this->model->getProductos();
        $this->views->getView('admin/administracion', "index", $data);
    }

    // Método que obtiene productos con cantidad mínima
    public function productosMinimos()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $data = $this->model->productosMinimos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    // Método que obtiene los productos más vendidos
    public function topProductos()
    {
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
        $data = $this->model->topProductos();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();

    }

    // Método para cerrar la sesión del usuario
    public function salir()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}
