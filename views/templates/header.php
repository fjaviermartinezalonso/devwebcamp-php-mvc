<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if(is_auth()) {?>
                <a href="<?php echo is_admin()? "/admin/dashboard" : "/registro/ticket" ?>" class="header__enlace">
                    <?php echo is_admin()? "Panel de administración" : "Acceso al evento" ?>
                </a>
                <form action="/logout" class="header__form" method="POST">
                    <input class="header__submit" type="submit" value="Cerrar sesión">
                </form>
            <?php } else {?>
            <a href="/registro" class="header__enlace">Registro</a>
            <a href="/login" class="header__enlace">Iniciar sesión</a>
            <?php } ?>
        </nav>
        
        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">&#60;DevWebCamp/></h1>
            </a>

            <p class="header__texto">Octubre 5-6 - 2024</p>
            <p class="header__texto header__texto--modalidad">En Línea - Presencial</p>
            
            <a href="/paquetes" class="header__boton">Comprar acceso</a>
        </div>
    </div>
</header>

<div class="barra">
    <div class="barra__contenido">
        <a href="/" class="barra__logo">
            <h2>&#60DevWebCamp/></h2>
        </a>
        <nav class="navegacion">
            <a href="/" class="navegacion__enlace <?php echo pagina_actual("/")? "navegacion__enlace--actual" : ""?>">Sobre el evento</a>
            <a href="/workshops" class="navegacion__enlace <?php echo pagina_actual("/workshops")? "navegacion__enlace--actual" : ""?>">Horarios</a>
            <a href="/paquetes" class="navegacion__enlace <?php echo pagina_actual("/paquetes")? "navegacion__enlace--actual" : ""?>">Paquetes</a>
        </nav>
    </div>
</div>