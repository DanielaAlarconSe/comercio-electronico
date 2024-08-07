<?php
class Home extends Controller
{
    // Constructor que inicia la sesión
    public function __construct() {
        parent::__construct();
        session_start();
    }

    // Método index que carga la vista principal con datos
    public function index()
    {
        // Inicializar el array de datos con el perfil y título de la página
        $data['perfil'] = 'no';
        $data['title'] = 'Pagina Principal';

        // Obtener las categorías desde el modelo
        $data['categorias'] = $this->model->getCategorias();
        
        // Recorrer cada categoría y obtener los productos asociados
        for ($i=0; $i < count($data['categorias']); $i++) {
            $data['categorias'][$i]['productos'] = $this->model->getProductos($data['categorias'][$i]['id']);
        }

        // Cargar la vista 'home' y pasarle los datos
        $this->views->getView('home', "index", $data);
    }
}