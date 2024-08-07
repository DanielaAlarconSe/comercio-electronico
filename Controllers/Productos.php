<?php
class Productos extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['nombre_usuario'])) {
            header('Location: '. BASE_URL . 'admin');
            exit;
        }
    }

    // Muestra la vista principal de administración de productos con las categorías.
    public function index()
    {
        $data['title'] = 'productos';
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('admin/productos', "index", $data);
    }

    // Lista los productos disponibles con acciones para agregar imágenes, editar y eliminar.
    public function listar()
    {
        $data = $this->model->getProductos(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . $data[$i]['imagen'] . '" alt="' . $data[$i]['nombre'] . '" width="50">';
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-success" type="button" onclick="agregarImagenes(' . $data[$i]['id'] . ')"><i class="fas fa-images"></i></button>
            <button class="btn btn-primary ms-2" type="button" onclick="editPro(' . $data[$i]['id'] . ')"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger ms-2" type="button" onclick="eliminarPro(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }

    // Registra o actualiza un producto con los datos proporcionados y maneja la imagen.
    public function registrar()
    {
        if (isset($_POST['nombre']) && isset($_POST['precio'])) {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $cantidad = $_POST['cantidad'];
            $descripcion = $_POST['descripcion'];
            $categoria = $_POST['categoria'];
            $imagen = $_FILES['imagen'];
            $tmp_name = $imagen['tmp_name'];
            $id = $_POST['id'];
            $ruta = 'assets/images/productos/';
            $nombreImg = date('YmdHis');
            if (empty($nombre) || empty($precio) || empty($cantidad)) {
                $respuesta = array('msg' => 'todos los campos son requeridos', 'icono' => 'warning');
            } else {
                if (!empty($imagen['name'])) {
                    $destino = $ruta . $nombreImg . '.jpg';
                } else if (!empty($_POST['imagen_actual']) && empty($imagen['name'])) {
                    $destino = $_POST['imagen_actual'];
                } else {
                    $destino = $ruta . 'default.png';
                }
                if (empty($id)) {
                    $data = $this->model->registrar($nombre, $descripcion, $precio, $cantidad, $destino, $categoria);
                    if ($data > 0) {
                        if (!empty($imagen['name'])) {
                            move_uploaded_file($tmp_name, $destino);
                        }
                        $respuesta = array('msg' => 'producto registrado', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'error al registrar', 'icono' => 'error');
                    }
                } else {
                    $data = $this->model->modificar($nombre, $descripcion, $precio, $cantidad, $destino, $categoria, $id);
                    if ($data == 1) {
                        if (!empty($imagen['name'])) {
                            move_uploaded_file($tmp_name, $destino);
                        }
                        $respuesta = array('msg' => 'producto modificado', 'icono' => 'success');
                    } else {
                        $respuesta = array('msg' => 'error al modificar el producto', 'icono' => 'error');
                    }
                }
            }
            echo json_encode($respuesta);
        }
        die();
    }

    // Elimina un producto específico según el ID proporcionado.
    public function delete($idPro)
    {
        if (is_numeric($idPro)) {
            $data = $this->model->eliminar($idPro);
            if ($data == 1) {
                $respuesta = array('msg' => 'producto eliminado', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al eliminar', 'icono' => 'error');
            }
        } else {
            $respuesta = array('msg' => 'error desconocido', 'icono' => 'error');
        }
        echo json_encode($respuesta);
        die();
    }

    // Recupera la información de un producto específico para su edición.
    public function edit($idPro)
    {
        if (is_numeric($idPro)) {
            $data = $this->model->getProducto($idPro);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    // Maneja la subida de imágenes adicionales para un producto específico.
    public function galeriaImagenes()
    {
        $id = $_POST['idProducto'];
        $folder_name = 'assets/images/productos/' . $id . '/';
        if (!empty($_FILES)) {
            if (!file_exists($folder_name)) {
                mkdir($folder_name);
            }
            $temp_name = $_FILES['file']['tmp_name'];
            $ruta = $folder_name . date('YmdHis') . $_FILES['file']['name'];
            move_uploaded_file($temp_name, $ruta);
        }
    }

    // Muestra las imágenes adicionales de un producto específico.
    public function verGaleria($id_producto)
    {
        $result = array();
        $directorio = 'assets/images/productos/' . $id_producto;
        if (file_exists($directorio)) {
            $imagenes = scandir($directorio);
            if (false !== $imagenes) {
                foreach ($imagenes as $file) {
                    if ('.' != $file && '..' != $file) {
                        array_push($result, $file);
                    }
                }
            }
        }
        echo json_encode($result);
        die();
    }

    // Elimina una imagen específica del producto.
    public function eliminarImg()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $destino = 'assets/images/productos/' . $json['url'];
        if (unlink($destino)) {
            $res = array('msg' => 'IMAGEN ELIMINADO', 'icono' => 'success');
        }else{
            $res = array('msg' => 'ERROR AL ELIMINAR', 'icono' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
