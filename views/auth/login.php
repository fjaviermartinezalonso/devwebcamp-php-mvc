<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Inicie sesión en DevWebCamp</p>

    <?php 
        require_once __DIR__ . "/../templates/alertas.php";
    ?>
    
    <form action="/login" class="formulario" method="POST">
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

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Contraseña</label>
            <input 
                type="password"
                class="formulario__input"
                placeholder="01234567"
                id="password"
                name="password"
            >
        </div> <!--.password-->

        <input type="submit" class="formulario__submit" value="Iniciar sesión">

        <div class="acciones">
            <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Regístrate</a>
            <a href="/olvide" class="acciones__enlace">¿Olvidaste tu contrasña? Recuperar contraseña</a>
        </div>
    </form>
</main>