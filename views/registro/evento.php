
<div class="evento">
    <p class="evento__hora"><?php echo $evento->hora->hora; ?></p>
    <div class="evento__informacion">
        <h4 class="evento__nombre"><?php echo $evento->nombre; ?></h4>
        <p class="evento__descripcion"><?php echo $evento->descripcion; ?></p>

        <div class="evento__autor-info">
            <picture>
                <source srcset="<?php echo $_ENV["HOST"]; ?>/img/speakers/<?php echo $evento->ponente->imagen . ".webp"; ?>" type="image/webp">
                <source srcset="<?php echo $_ENV["HOST"]; ?>/img/speakers/<?php echo $evento->ponente->imagen . ".png"; ?>" type="image/png">
                <img class="evento__autor-imagen" loading="lazy" width="200" height="300" src="/img/speakers/<?php echo $evento->ponente->imagen . ".png"; ?>" alt="Imagen ponente" srcset="">
            </picture>
            <p class="evento__autor-nombre"><?php echo $evento->ponente->nombre . " " . $evento->ponente->apellido; ?></p>
        </div>

        <button
            type="button"
            data-id="<?php echo $evento->id?>"
            class="evento__agregar"
            <?php echo ($evento->disponibles === "0")? "disabled" : ""?>
        >
        <?php if($evento->disponibles === "0") { ?>
            Agotado
        <?php } else { ?> 
            Añadir (<?php echo $evento->disponibles;?> plazas)    
        <?php } ?>
        </button>
    </div>
</div>
