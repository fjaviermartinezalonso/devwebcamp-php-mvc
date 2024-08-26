<?php

namespace Controllers;

use MVC\Router;
use Model\Registro;
use Model\Usuario;
use Model\Evento;

class DashboardController {

        public static function index(Router $router) {
            if(!is_admin()) {
                header("Location: /login");
            }
            
            // Obtener los últimos 5 registros
            $registros = Registro::get(5);
            foreach($registros as $registro) {
                $registro->usuario = Usuario::find($registro->usuario_id);
            }

            // Calcular los ingresos
            $virtuales = Registro::total("paquete_id", 2);
            $presenciales = Registro::total("paquete_id", 1);
            $ingresos = ($virtuales * 49) + ($presenciales * 199);

            // Obtener eventos con más y menos plazas disponibles
            $menosPlazas = Evento::ordenarLimitar("disponibles", "ASC", 5);
            $masPlazas = Evento::ordenarLimitar("disponibles", "DESC", 5);

            $router->render("admin/dashboard/index", [
                "titulo" => "Panel de administración",
                "registros" => $registros,
                "ingresos" => $ingresos,
                "menosPlazas" => $menosPlazas,
                "masPlazas" => $masPlazas,
            ]);
        }
}