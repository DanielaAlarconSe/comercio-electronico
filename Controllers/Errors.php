<?php
class Errors extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Método index para cargar la vista de errores
    public function index()
    {
        $this->views->getView('errors', "index");
    }
}