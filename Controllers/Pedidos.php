<?php
class Pedidos extends Controller
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

    // Método index para cargar la vista de pedidos
    public function index()
    {
        $data['title'] = 'pedidos';
        $this->views->getView('admin/pedidos', "index", $data);
    }

    // Método para listar pedidos en estado 1 (pendientes)
    public function listarPedidos()
    {
        $data = $this->model->getPedidos(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-success" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>
            <button class="btn btn-info ms-2" type="button" onclick="cambiarProceso(' . $data[$i]['id'] . ', 2)"><i class="fas fa-check-circle"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }

     // Método para listar pedidos en estado 2 (en proceso)
    public function listarProceso()
    {
        $data = $this->model->getPedidos(2);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-success" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>
            <button class="btn btn-info ms-2" type="button" onclick="cambiarProceso(' . $data[$i]['id'] . ', 3)"><i class="fas fa-check-circle"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }

    // Método para listar pedidos en estado 3 (finalizados)
    public function listarFinalizados()
    {
        $data = $this->model->getPedidos(3);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['accion'] = '<div class="d-flex">
            <button class="btn btn-success" type="button" onclick="verPedido(' . $data[$i]['id'] . ')"><i class="fas fa-eye"></i></button>
        </div>';
        }
        echo json_encode($data);
        die();
    }

    // Método para actualizar el estado de un pedido
    public function update($datos)
    {
        $array = explode(',', $datos);
        $idPedido = $array[0];
        $proceso = $array[1];
        if (is_numeric($idPedido)) {
            $data = $this->model->actualizarEstado($proceso, $idPedido);
            if ($data == 1) {
                $respuesta = array('msg' => 'pedido actualizado', 'icono' => 'success');
            } else {
                $respuesta = array('msg' => 'error al actualizar el pedido', 'icono' => 'error');
            }
            echo json_encode($respuesta);
        }
        die();
    }
}