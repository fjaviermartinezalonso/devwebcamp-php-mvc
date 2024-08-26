<?php
    include_once __DIR__ . "/devwebcamp.php"
?>

<section class="resumen">
    <div class="resumen__grid">
        <div class="resumen__bloque" data-aos="fade-up">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_ponentes?></p>
            <p class="resumen__texto">Ponentes</p>
        </div>
        <div class="resumen__bloque" data-aos="fade-up">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_conferencias?></p>
            <p class="resumen__texto">Conferencias</p>
        </div>
        <div class="resumen__bloque" data-aos="fade-up">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_workshops?></p>
            <p class="resumen__texto">Workshops</p>
        </div>
        <div class="resumen__bloque" data-aos="fade-up">
            <p class="resumen__texto resumen__texto--numero"><?php echo $num_asistentes?></p>
            <p class="resumen__texto">Asistentes</p>
        </div>
    </div>
</section>

<section class="speakers">
    <h2 class="speakers__heading">Conoce a nuestros expertos en DevWebCamp</h2>
    <div class="speakers__grid">
        <?php foreach($ponentes as $ponente) { ?>
            <div class="speaker">
                <picture>
                    <source srcset="/img/speakers/<?php echo $ponente->imagen . ".webp"; ?>" type="image/webp">
                    <source srcset="/img/speakers/<?php echo $ponente->imagen . ".png"; ?>" type="image/png">
                    <img class="speaker__imagen" loading="lazy" width="200" height="300" src="/img/speakers/<?php echo $ponente->imagen . ".png"; ?>" alt="Imagen ponente" srcset="">
                </picture>

                <div class="speaker__informacion">
                    <h4 class="speaker__nombre"><?php echo $ponente->nombre . " " . $ponente->apellido?></h4>
                    <p class="speaker__ubicacion"><?php echo $ponente->ciudad . ", " . $ponente->pais?></p>
                    <nav class="speaker-sociales">
                        <?php $redes = json_decode($ponente->redes);?>
                        
                        <?php if(!empty($redes->facebook)) { ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->facebook; ?>">
                                <span class="speaker-sociales__ocultar">Facebook</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($redes->x)) { ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->x; ?>">
                                <span class="speaker-sociales__ocultar">X</span>
                            </a> 
                        <?php } ?>
                        
                        <?php if(!empty($redes->youtube)) { ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->youtube; ?>">
                                <span class="speaker-sociales__ocultar">YouTube</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($redes->instagram)) { ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->instagram; ?>">
                                <span class="speaker-sociales__ocultar">Instagram</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($redes->tiktok)) { ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->tiktok; ?>">
                                <span class="speaker-sociales__ocultar">Tiktok</span>
                            </a> 
                        <?php } ?>

                        <?php if(!empty($redes->github)) { ?>
                            <a class="speaker-sociales__enlace" rel="noopener noreferrer" target="_blank" href="<?php echo $redes->github; ?>">
                                <span class="speaker-sociales__ocultar">GitHub</span>
                            </a>
                        <?php } ?>

                    </nav>
                    <ul class="speaker__listado-skills">
                        <?php $tags = explode(",", $ponente->tags);
                        foreach($tags as $tag) { ?>
                            <li class="speaker__skill"><?php echo $tag; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        <?php }?>
    </div>
</section>

<div class="mapa" id="mapa"></div>

<section class="tickets">
    <h2 class="tickets__heading">¡Adquiere ya tu pase al evento!</h2>

    <div class="tickets__grid">
        <div class="ticket ticket--virtual">
            <h4 class="ticket__logo">&#60;DevWebCamp/></h4>
            <p class="ticket__plan">Virtual</p>
            <p class="ticket__precio">49€</p>
        </div>
        <div class="ticket ticket--presencial">
            <h4 class="ticket__logo">&#60;DevWebCamp/></h4>
            <p class="ticket__plan">Presencial</p>
            <p class="ticket__precio">199€</p>
        </div>
    </div>

    <div class="ticket__enlace-contenedor">
        <a href="/paquetes" class="ticket__enlace">Comprar acceso</a>
    </div>
</section>