<main class="paquetes">
    <h2 class="paquetes__heading">Elige tu plan de acceso</h2>

    <div class="paquetes__grid">
        <div class="paquete">
            <div>
                <h3 class="paquete__nombre">Pase Virtual</h3>
                <ul class="paquete__lista">
                    <li class="paquete__elemento">Acceso virtual a DevWebCamp</li>
                    <li class="paquete__elemento">Pase por 2 días</li>
                    <li class="paquete__elemento">Acceso a conferencias y workshops</li>
                    <li class="paquete__elemento">Acceso a las grabaciones</li>
                </ul>
            </div>
            <div>
                <p class="paquete__precio <?php echo ($pase_actual>0)? "paquete__precio--comprado" : ""; ?>">49€</p>
                <form action="/registro/virtual" method="post">
                    <input 
                        class="paquete__submit" 
                        type="submit" 
                        value="<?php echo ($pase_actual>0)? "Ver pase" : "Inscripción virtual"; ?>"
                    >
                </form>
            </div>
        </div>
        
        <div class="paquete">
            <div>
                <h3 class="paquete__nombre">Pase Presencial</h3>
                <ul class="paquete__lista">
                    <li class="paquete__elemento">Acceso presencial a DevWebCamp</li>
                    <li class="paquete__elemento">Pase por 2 días</li>
                    <li class="paquete__elemento">Acceso a conferencias y workshops</li>
                    <li class="paquete__elemento">Acceso a las grabaciones</li>
                    <li class="paquete__elemento">Camiseta del evento</li>
                    <li class="paquete__elemento">Comida y bebida gratis</li>
                </ul>
            </div>
            <div>
                <p class="paquete__precio <?php echo ($pase_actual==1)? "paquete__precio--comprado" : ""; ?>">199€</p>
                <form action="/registro/presencial" method="post">
                    <input 
                        class="paquete__submit" 
                        type="submit" 
                        value="<?php echo ($pase_actual==1)? "Ver pase" : "Inscripción presencial"; ?>"
                    >
                </form>
            </div>
        </div>
    </div>
</main>