<section class="pagina">
    <h2 class="pagina__heading">Elige hasta cinco eventos para asistir de forma presencial</h2>

    <?php ?>

    <div class="eventos-registro">
        <main class="eventos-registro__listado">
            <h3 class="eventos-registro__heading--conferencias">&lt;Conferencias/></h3>
            <p class="eventos-registro__fecha">Viernes 5 de octubre</p>
            <div class="eventos-registro__grid">
                <?php foreach($eventos["conferencias_v"] as $evento) { ?>
                    <?php include __DIR__ . "/evento.php"; ?>
                <?php } ?>
            </div>

            <p class="eventos-registro__fecha">Sábado 6 de octubre</p>
            <div class="eventos-registro__grid">
                <?php foreach($eventos["conferencias_s"] as $evento) { ?>
                    <?php include __DIR__ . "/evento.php"; ?>
                <?php } ?>
            </div>
            
            
            <h3 class="eventos-registro__heading--workshops">&lt;Workshops/></h3>
            <p class="eventos-registro__fecha">Viernes 5 de octubre</p>
            <div class="eventos-registro__grid eventos--workshops">
                <?php foreach($eventos["workshops_v"] as $evento) { ?>
                    <?php include __DIR__ . "/evento.php"; ?>
                <?php } ?>
            </div>

            <p class="eventos-registro__fecha">Sábado 6 de octubre</p>
            <div class="eventos-registro__grid eventos--workshops">
                <?php foreach($eventos["workshops_s"] as $evento) { ?>
                    <?php include __DIR__ . "/evento.php"; ?>
                <?php } ?>
            </div>
        </main>

        <aside class="registro">
            <h2 class="registro__heading">Tu registro</h2>

            <div id="registro__resumen" class="registro__resumen"></div>

            <div class="registro__regalo">
                <label for="regalo" class="registro__label">Selecciona un regalo</label>
                <select id="regalo" class="registro__select">
                    <option value="">-- Selecciona tu regalo --</option>
                    <?php foreach($regalos as $regalo) { ?>
                        <option <?php echo ($registro->regalo_id === $regalo->id)? "selected" : "" ?> value="<?php echo $regalo->id;?>"><?php echo $regalo->nombre;?></option>
                    <?php } ?>
                </select>
            </div>

            <form action="" class="formulario" id="registro">
                <div class="formulario__campo">
                    <input type="submit" class="formulario__submit formulario__submit--full" value="Registrarme">
                </div>
            </form>
        </aside>
    </div>
</section>