<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<main class="bloques">
    <div class="bloques__grid">
        <div class="bloque">
            <h3 class="bloque__heading">Los últimos 5 usuarios registrados</h3>
            <?php foreach($registros as $registro) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto"><?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido?></p>
                </div>
            <?php } ?>
        </div>
        
        <div class="bloque">
            <h3 class="bloque__heading">Ingresos totales</h3>
            <p class="bloque__texto--cantidad"><?php echo $ingresos?>€</p>
        </div>
        
        <div class="bloque">
            <h3 class="bloque__heading">Los 5 eventos con menos plazas disponibles</h3>
            <?php foreach($menosPlazas as $evento) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto"><?php echo $evento->nombre . ": " . $evento->disponibles?></p>
                </div>
            <?php } ?>
        </div>
        
        <div class="bloque">
            <h3 class="bloque__heading">Los 5 eventos con más plazas disponibles</h3>
            <?php foreach($masPlazas as $evento) { ?>
                <div class="bloque__contenido">
                    <p class="bloque__texto"><?php echo $evento->nombre . ": " . $evento->disponibles?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</main>