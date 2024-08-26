<?php

namespace Controllers;

use Model\Evento;
use Model\EventoHorario;
use Model\EventosRegistros;

class APIEventos {

    public static function index() {
        
        $dia_id = $_GET["dia_id"] ?? "";
        $categoria_id = $_GET["categoria_id"] ?? "";

        $dia_id = filter_var($dia_id, FILTER_VALIDATE_INT);
        $categoria_id = filter_var($categoria_id, FILTER_VALIDATE_INT);

        if(!$dia_id || !$categoria_id) {
            echo json_encode([]);
        }

        // Consultar base de datos
        $eventos = EventoHorario::whereArray(["dia_id" => $dia_id, "categoria_id" => $categoria_id] ?? []);
        echo json_encode($eventos);
    }
    
    public static function registrados() {
        
        if(!is_auth()) {
            echo json_encode([]);
            return;
        }

        $usuario_id = $_SESSION["id"];

        // Consultar base de datos
        $eventosRegistros = EventosRegistros::whereArray(["registro_id" => $usuario_id]);

        $eventos = [];
        foreach($eventosRegistros as $eventoRegistro) {
            $eventos[] = Evento::find($eventoRegistro->evento_id);
        }
        echo json_encode($eventos);
    }
}