<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Ponente;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;

class PonentesController {

    public static function index(Router $router) {
        if(!is_admin()) {
            header("Location: /login");
        }

        $pagina_actual = $_GET["page"];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if(!$pagina_actual || $pagina_actual < 1) {
            header("Location: /admin/ponentes?page=1");
        }

        $registros_por_pagina = 8;
        $total_registros = Ponente::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total_registros);
        if($paginacion->total_paginas() < $pagina_actual) {
            header("Location: /admin/ponentes?page=1");
        }

        $ponentes = Ponente::paginar($registros_por_pagina, $paginacion->offset());

        $router->render("admin/ponentes/index", [
            "titulo" => "Ponentes",
            "ponentes" => $ponentes,
            "paginacion" => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router) {
        if(!is_admin()) {
            header("Location: /login");
        }

        $alertas = [];
        $ponente = new Ponente;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            //Leer imagen
            if(!empty($_FILES["imagen"]["tmp_name"])) {
                $carpeta_imagenes = "../public/img/speakers";
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,800)->encode("png", 80);
                $imagen_webp = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,800)->encode("webp", 80);
                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST["imagen"] = $nombre_imagen; // añadir campo imagen que se sincronizara y validara mas abajo
            }

            $_POST["redes"] = json_encode($_POST["redes"], JSON_UNESCAPED_SLASHES); // "redes" de array a string
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            // Guardar el registro
            if(empty($alertas)) {
                // Guardar imagen
                $imagen_png->save($carpeta_imagenes . "/" . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . "/" . $nombre_imagen . ".webp");

                $resultado = $ponente->guardar();
                if($resultado) {
                    header("Location: /admin/ponentes");
                }
            }
        }

        $router->render("admin/ponentes/crear", [
            "titulo" => "Registrar ponente",
            "alertas" => $alertas,
            "ponente" => $ponente,
            "redes" => json_decode($ponente->redes)
        ]);
    }

    public static function editar(Router $router) {
        if(!is_admin()) {
            header("Location: /login");
        }

        $alertas = [];

        // Validar ID de la URL
        $id = $_GET["id"];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if(!$id) {
            header("Location: /admin/ponentes");
        }

        // Obtener el ponente
        $ponente = Ponente::find($id);
        if(!$ponente) {
            header("Location: /admin/ponentes");
        }

        $ponente->imagen_actual = $ponente->imagen;

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            //Leer imagen
            if(!empty($_FILES["imagen"]["tmp_name"])) {
                $carpeta_imagenes = "../public/img/speakers";
                if(!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $imagen_png = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,800)->encode("png", 80);
                $imagen_webp = Image::make($_FILES["imagen"]["tmp_name"])->fit(800,800)->encode("webp", 80);
                $nombre_imagen = md5(uniqid(rand(), true));

                $_POST["imagen"] = $nombre_imagen; // añadir campo imagen que se sincronizara y validara mas abajo
            }
            else {
                $_POST["imagen"] = $ponente->imagen_actual;
            }

            $_POST["redes"] = json_encode($_POST["redes"], JSON_UNESCAPED_SLASHES); // "redes" de array a string
            $ponente->sincronizar($_POST);
            $alertas = $ponente->validar();

            // Guardar el registro
            if(empty($alertas)) {
                // Guardar imagen
                if(isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . "/" . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . "/" . $nombre_imagen . ".webp");
                }

                $resultado = $ponente->guardar();
                if($resultado) {
                    header("Location: /admin/ponentes");
                }
            }      
        }

        $router->render("admin/ponentes/editar", [
            "titulo" => "Editar ponente",
            "alertas" => $alertas,
            "ponente" => $ponente,
            "redes" => json_decode($ponente->redes)
        ]);
    }

    public static function eliminar(Router $router) {
        if(!is_admin()) {
            header("Location: /login");
        }

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            $ponente = Ponente::find($id);
            
            if(!isset($ponente)) {
                header("Location: /admin/ponentes");
            }

            $resultado = $ponente->eliminar();
            if($resultado) {
                header("Location: /admin/ponentes");
            }
        }
    }
}