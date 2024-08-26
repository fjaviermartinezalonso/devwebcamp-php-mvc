<main class="pagina">
    <h2 class="pagina__heading"><?php echo $titulo;?></h2>

    <?php if($registro->paquete_id !== "0") { ?>
        <div class="ticket-virtual">
            <div class="ticket ticket--<?php echo strtolower($registro->paquete->nombre);?> ticket--acceso">
                <div class="ticket__contenido">
                    <h4 class="ticket__logo">&#60;DevWebCamp/></h4>
                    <p class="ticket__plan"><?php echo $registro->paquete->nombre;?></p>
                    <p class="ticket__nombre"><?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido;?></p>
                </div>

                <p class="ticket__codigo"><?php echo "#" . $registro->token;?></p>
            </div>
        </div>
    <?php } else { ?>
        <p class="ticket__descripcion">Todavía no has comprado ningún ticket</p>
        <div class="ticket__enlace-contenedor">
            <a href="/paquetes" class="ticket__enlace">Comprar acceso</a>
        </div>
    <?php } ?>
</main>

<?php if($registro->paquete_id === "1") { ?>
    <?php include __DIR__ . "/conferencias.php"; ?>
<?php } ?>