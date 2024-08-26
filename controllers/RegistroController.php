<?php

namespace Controllers;

use Model\Registro;
use Model\Usuario;
use Model\Paquete;
use Model\Evento;
use Model\Categoria;
use Model\Dia;
use Model\Hora;
use Model\Ponente;
use Model\Regalo;
use Model\EventosRegistros;
use MVC\Router;

class RegistroController {

    // public static function crear(Router $router) {
    //     if(!is_auth()) {
    //         header("Location: /login");
    //     }

    //     $router->render("registro/paquetes", [
    //         "titulo" => "Finalizar registro"
    //     ]);
    // }
    
    public static function virtual(Router $router) {

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!is_auth()) {
                header("Location: /login");
            }

            // Verificar si el usuario ya creó un registro virtual o presencial
            $registro = Registro::where("usuario_id", $_SESSION["id"]);
            if(isset($registro) && $registro->paquete_id > 0) {
                header("Location: /registro/ticket?id=" . urlencode($registro->token));
                return;
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos = array(
                "paquete_id" => 2,
                "pago_id" => "",
                "token" => $token,
                "usuario_id" => $_SESSION["id"],
            );

            // Crear registro, guardarlo y redirigir al ticket comprado
            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if($resultado) {
                header("Location: /registro/ticket?id=" . urlencode($registro->token));
            }
        }
    }

    public static function presencial(Router $router) {

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!is_auth()) {
                header("Location: /login");
            }

            // Verificar si el usuario ya creó un registro
            $registro = Registro::where("usuario_id", $_SESSION["id"]);
            if(isset($registro)) {
                // Si el registro es presencial se le enseña
                if($registro->paquete_id === "1") {
                    header("Location: /registro/ticket?id=" . urlencode($registro->token));
                    return;
                }
                else { // Si no, significa que era virtual y que sustituye el previo por este presencial
                    $registro->eliminar();
                }
            }

            $token = substr(md5(uniqid(rand(), true)), 0, 8);
            $datos = array(
                "paquete_id" => 1,
                "pago_id" => "",
                "token" => $token,
                "usuario_id" => $_SESSION["id"],
            );

            // Crear registro, guardarlo y redirigir al ticket comprado
            $registro = new Registro($datos);
            $resultado = $registro->guardar();
            if($resultado) {
                header("Location: /registro/ticket?id=" . urlencode($registro->token));
            }
        }
    }

//     public static function ticket(Router $router) {
//         if(!is_auth()) {
//             header("Location: /login");
//         }

//         // Validar token del ticket
//         $id = $_GET["id"];
//         if(!$id || strlen($id) !== 8) {
//             header("Location: /");
//         }
//         $registro = Registro::where("token", $id);
//         if(!$registro) {
//             header("Location: /");
//         }

//         // Llenar tablas de referencia
//         $registro->usuario = Usuario::find($registro->usuario_id);
//         $registro->paquete = Paquete::find($registro->paquete_id);

//         $router->render("registro/ticket", [
//             "titulo" => "Ticket de acceso",
//             "registro" => $registro,
//         ]);
//     }

//     public static function conferencias(Router $router) {
//         if(!is_auth()) {
//             header("Location: /login");
//         }

//         // Si el usuario no compró el pase presencial no puede reservar plaza
//         $usuario_id = $_SESSION["id"];

// //todo: avisar al usuario de por que no puede seguir!!!
        
//         $registro = Registro::where("usuario_id", $usuario_id);
//         if(!$registro || $registro->paquete_id !== "1") {
//             header("Location: /");
//         }

//         // Obtener los eventos disponibles
//         $eventos = Evento::ordenar("hora_id", "ASC");

//         $eventos_formateados = [];
//         foreach($eventos as $evento) {
//             $evento->categoria = Categoria::find($evento->categoria_id);
//             $evento->dia = Dia::find($evento->dia_id);
//             $evento->hora = Hora::find($evento->hora_id);
//             $evento->ponente = Ponente::find($evento->ponente_id);

//             // Conferencias
//             if($evento->categoria_id === "1" && $evento->dia_id === "1") {
//                 $eventos_formateados["conferencias_v"][] = $evento;
//             }
//             if($evento->categoria_id === "1" && $evento->dia_id === "2") {
//                 $eventos_formateados["conferencias_s"][] = $evento;
//             }
//             // Workshops
//             if($evento->categoria_id === "2" && $evento->dia_id === "1") {
//                 $eventos_formateados["workshops_v"][] = $evento;
//             }
//             if($evento->categoria_id === "2" && $evento->dia_id === "2") {
//                 $eventos_formateados["workshops_s"][] = $evento;
//             }
//         }

//         $regalos = Regalo::all("ASC");

//         // Manejar el registro mediante $_POST
//         if($_SERVER["REQUEST_METHOD"] === "POST") {
//             $eventos = explode(",", $_POST["eventos"]);
//             if(empty($eventos)) {
//                 echo json_encode(["resultado" => false]);
//                 return;
//             }

//             // Obtener registro de usuario
//             $registro = Registro::where("usuario_id", $_SESSION["id"]);
//             // solo los usuarios presenciales pueden tener camiseta
//             if(!isset($registro) || $registro->paquete_id !== "1") { 
//                 echo json_encode(["resultado" => false]);
//                 return;
//             }

//             $eventos_array = [];
//             // Validar disponibilidad de los eventos seleccionados
//             foreach($eventos as $evento_id) {
//                 $evento = Evento::find($evento_id);
//                 if(!isset($evento) || $evento->disponibles === "0") { 
//                     echo json_encode(["resultado" => false]);
//                     return;
//                 }
//                 $eventos_array[] = $evento;
//             }

//             // Actualizar registros en la DB, tras haberse hecho las validaciones
//             foreach($eventos_array as $evento) {
//                 $evento->disponibles--;
//                 $evento->guardar();

//                 // Almacenar el registro
//                 $datos = [
//                     "evento_id" => (int) $evento->id,
//                     "registro_id" => (int) $registro->id,
//                 ];

//                 $registro_usuario = new EventosRegistros($datos);
//                 $registro_usuario->guardar();
//             }

//             // Almacenar el regalo
//             $registro->sincronizar(["regalo_id" => $_POST["regalo_id"]]);
//             $resultado = $registro->guardar();
//             echo json_encode([
//                 "resultado" => $resultado,
//                 "token" => $registro->token,
//             ]);
//             return;
//         }

//         $router->render("registro/conferencias", [
//             "titulo" => "Registra tu asistencia a los eventos",
//             "eventos" => $eventos_formateados,
//             "regalos" => $regalos,
//         ]);
//     }


    public static function acceso(Router $router) {
        if(!is_auth()) {
            header("Location: /login");
        }

        // Verificar si el usuario ya creó un registro virtual o presencial
        $registro = Registro::where("usuario_id", $_SESSION["id"]);
        // Llenar tablas de referencia
        if(isset($registro)) {
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }
        else {
            // No hay registro, relleno paquete_id a 0 para la vista
            $registro = new Registro();
            $registro->paquete_id = "0";
        }

        // Obtener los eventos disponibles
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

        $regalos = Regalo::all("ASC");

        // Manejar el registro mediante $_POST
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $eventos = explode(",", $_POST["eventos"]);
            if(empty($eventos)) {
                echo json_encode(["resultado" => false]);
                return;
            }

            // Solo los usuarios presenciales pueden tener camiseta
            if(!isset($registro) || $registro->paquete_id !== "1") { 
                echo json_encode(["resultado" => false]);
                return;
            }

            // Validar disponibilidad de los eventos seleccionados
            $eventos_array = [];
            foreach($eventos as $evento_id) {
                $evento = Evento::find($evento_id);
                if(!isset($evento) || $evento->disponibles === "0") { 
                    echo json_encode(["resultado" => false]);
                    return;
                }
                $eventos_array[] = $evento;
            }

            // Obtener los id de los eventos que habian sido escogidos previamente para poder diferenciar los nuevos, los viejos y los que se mantienen
            $registros_usuario_previo = EventosRegistros::whereArray(["registro_id" => $_SESSION["id"]]);
            $registros_usuario_previo_id = [];
            foreach($registros_usuario_previo as $prev) {
                $registros_usuario_previo_id[] = $prev->evento_id;
            }

            // Obtener los id de los eventos seleccionados actualmente
            $registros_usuario_id = [];
            foreach($eventos_array as $reg) {
                $registros_usuario_id[] = $reg->id;
            }

            // Borrar eventos deseleccionados
            foreach($registros_usuario_previo_id as $previo_id) {
                if(!in_array($previo_id, $registros_usuario_id)) { // el id previo no esta entre los nuevos
                    $reg = array_shift(EventosRegistros::whereArray(["registro_id" => $_SESSION["id"], "evento_id" => $previo_id]));
                    $reg->eliminar();

                    $event = Evento::find($previo_id);
                    $event->disponibles++;
                    $event->guardar();
                }
            }

            // Actualizar registros en la DB, tras haberse hecho las validaciones
            foreach($eventos_array as $evento) {
                // Si no estaba en la DB se añadira
                if(!in_array($evento->id, $registros_usuario_previo_id)) {
                    
                    $evento->disponibles--;
                    $evento->guardar();
                    
                    // Almacenar el registro
                    $datos = [
                        "evento_id" => (int) $evento->id,
                        "registro_id" => (int) $registro->id,
                    ];
                    
                    $registro_usuario = new EventosRegistros($datos);
                    $registro_usuario->guardar();
                }
            }

            // Almacenar el regalo
            $registro->sincronizar(["regalo_id" => $_POST["regalo_id"]]);
            $resultado = $registro->guardar();
            echo json_encode([
                "resultado" => $resultado,
                "token" => $registro->token,
            ]);
            return;
        }

        $router->render("registro/ticket", [
            "titulo" => "Este es tu ticket de acceso",
            "registro" => $registro,
            "eventos" => $eventos_formateados,
            "regalos" => $regalos,
        ]);
    }
}