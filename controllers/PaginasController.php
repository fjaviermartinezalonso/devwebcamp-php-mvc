<?php

namespace Controllers;

use Model\Evento;
use Model\Categoria;
use Model\Dia;
use Model\Hora;
use Model\Ponente;
use Model\Registro;
use MVC\Router;

class PaginasController {
    public static function index(Router $router) {

        $eventos = Evento::ordenar("hora_id", "ASC");

        $eventos_formateados = [];
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            // Conferencias
            if($evento->categoria_id === "1" && $evento->dia_id === "1") {
                $eventos_formateados["conferencias_v"][] = $evento;
            }
            if($evento->categoria_id === "1" && $evento->dia_id === "2") {
                $eventos_formateados["conferencias_s"][] = $evento;
            }
            // Workshops
            if($evento->categoria_id === "2" && $evento->dia_id === "1") {
                $eventos_formateados["workshops_v"][] = $evento;
            }
            if($evento->categoria_id === "2" && $evento->dia_id === "2") {
                $eventos_formateados["workshops_s"][] = $evento;
            }
        }

        // Obtener total de cada bloque
        $num_ponentes = Ponente::total();
        $num_conferencias = Evento::total("categoria_id", 1);
        $num_workshops = Evento::total("categoria_id", 2);
        $num_asistentes = 500;

        // Obtener todos los ponentes
        $ponentes = Ponente::all();

        // Render a la vista 
        $router->render('paginas/index', [
            'titulo' => 'Conoce el evento',
            "eventos" => $eventos_formateados,
            "num_ponentes" => $num_ponentes,
            "num_conferencias" => $num_conferencias,
            "num_workshops" => $num_workshops,
            "num_asistentes" => $num_asistentes,
            "ponentes" => $ponentes,
        ]);
    }
    
    public static function evento(Router $router) {

        // Render a la vista 
        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre el evento',
        ]);
    }

    public static function paquetes(Router $router) {

        // Para habilitar/deshabilitar el botón del pase que ya se haya comprado
        $pase_actual = 0;
        if(is_auth()) {
            $registro = Registro::where("usuario_id", $_SESSION["id"]);
            if(isset($registro)) {
                $pase_actual = $registro->paquete_id; 
            }
        }

        // Render a la vista 
        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes de acceso',
            "pase_actual" => $pase_actual,
        ]);
    }

    public static function conferencias(Router $router) {

        $eventos = Evento::ordenar("hora_id", "ASC");

        $eventos_formateados = [];
        foreach($eventos as $evento) {
            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            // Conferencias
            if($evento->categoria_id === "1" && $evento->dia_id === "1") {
                $eventos_formateados["conferencias_v"][] = $evento;
            }
            if($evento->categoria_id === "1" && $evento->dia_id === "2") {
                $eventos_formateados["conferencias_s"][] = $evento;
            }
            // Workshops
            if($evento->categoria_id === "2" && $evento->dia_id === "1") {
                $eventos_formateados["workshops_v"][] = $evento;
            }
            if($evento->categoria_id === "2" && $evento->dia_id === "2") {
                $eventos_formateados["workshops_s"][] = $evento;
            }
        }


        // Render a la vista 
        $router->render('paginas/conferencias', [
            'titulo' => 'Conferencias & Workshops disponibles',
            "eventos" => $eventos_formateados
        ]);
    }

    public static function error(Router $router) {

        // Render a la vista 
        $router->render('paginas/error', [
            'titulo' => 'Página no encontrada',
        ]);
    }
}