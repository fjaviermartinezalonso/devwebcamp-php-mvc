<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Se enviarán las instrucciones a su correo electrónico para recuperar la contraseña</p>

    <?php 
        require_once __DIR__ . "/../templates/alertas.php";
    ?>

    <form method="POST" action="/olvide" class="formulario">
        <div class="formulario__campo">
            <label for="email" class="formulario__label">Correo electrónico</label>
            <input 
                type="email"
                class="formulario__input"
                placeholder="ejemplo@mail.com"
                id="email"
                name="email"
            >
        </div> <!--.email-->

        <input type="submit" class="formulario__submit" value="Enviar instrucciones">

        <div class="acciones">
            <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Regístrate</a>
            <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
        </div>
    </form>
</main>