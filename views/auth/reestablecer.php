<main class="auth">
    <h2 class="auth__heading"><?php echo $titulo;?></h2>
    <p class="auth__texto">Introduzca su nueva contraseña</p>
    
    <?php 
        require_once __DIR__ . "/../templates/alertas.php";
    ?>

    <?php if($token_valido) {?>
        <form method="POST" class="formulario">
            <div class="formulario__campo">
                <label for="password" class="formulario__label">Nueva contraseña</label>
                <input 
                    type="password"
                    class="formulario__input"
                    placeholder="01234567"
                    id="password"
                    name="password"
                >
            </div> <!--.password-->

            <input type="submit" class="formulario__submit" value="Cambiar contraseña">

            <div class="acciones">
                <a href="/registro" class="acciones__enlace">¿Aún no tienes cuenta? Regístrate</a>
                <a href="/login" class="acciones__enlace">¿Ya tienes cuenta? Iniciar sesión</a>
            </div>
        </form>
    <?php } ?>
</main>