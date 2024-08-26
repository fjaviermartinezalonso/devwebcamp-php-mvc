<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor">
    <?php if(!empty($registros)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Correo electrónico</th>
                    <th scope="col" class="table__th">Tipo de pase</th>
                </tr>
            </thead>
            <tbody class="table__tbody">
                <?php foreach($registros as $registro) {?>
                    <tr class="table__tr">
                        <td class="table__td"><?php echo $registro->usuario->nombre . " " . $registro->usuario->apellido;?></td>
                        <td class="table__td"><?php echo $registro->usuario->email?></td>
                        <td class="table__td"><?php echo $registro->paquete->nombre?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php } else { ?>
        <p class="text-center">Todavía no se han registrado registros.</p>
    <?php } ?>
</div>

<?php
    echo $paginacion;
?>