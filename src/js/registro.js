import Swal from "sweetalert2";

(function() {
    let eventos = [];
    const resumen = document.querySelector("#registro__resumen");

    if(resumen) {
        const eventosBoton = document.querySelectorAll(".evento__agregar");
        eventosBoton.forEach(boton => boton.addEventListener("click", seleccionarEvento));

        const formularioRegistro = document.querySelector("#registro");
        formularioRegistro.addEventListener("submit", submitFormulario);

        fetch(`/api/eventos-registrados`)
            .then( res => res.json())
            .then( res => {
                // Asignar respuesta a variable eventos
                eventos = res.map( evento => { 
                    return {
                        id: evento.id, 
                        titulo: evento.nombre,
                    }
                });

                // Deshabilitar eventos seleccionados previamente
                eventos.forEach( elem => {
                    const evento = document.querySelector(`[data-id="${elem.id}"]`);
                    evento.disabled = true;
                });

                mostrarEventos();
            })

        function mostrarEventos() {
            limpiarEventos();

            if(eventos.length > 0) {
                eventos.forEach(evento => {
                    const eventoDOM = document.createElement("DIV");
                    eventoDOM.classList.add("registro__evento");

                    const titulo = document.createElement("H3");
                    titulo.classList.add("registro__nombre");
                    titulo.textContent = evento.titulo;

                    const botonEliminar = document.createElement("BUTTON");
                    botonEliminar.classList.add("registro__eliminar");
                    botonEliminar.innerHTML = `<i class="fa-solid fa-trash"></i>`;
                    botonEliminar.onclick = function() {
                        eliminarEvento(evento.id);
                    }

                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);
                });
            }
            else {
                const noRegistro = document.createElement("P");
                noRegistro.textContent = "Ningún evento, añade hasta cinco";
                noRegistro.classList.add("texto");
                resumen.appendChild(noRegistro);
            }
        }

        function limpiarEventos() {
            while(resumen.firstChild) {
            resumen.removeChild(resumen.firstChild);
            }
        }

        function eliminarEvento(id) {
            eventos = eventos.filter(evento => evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }
        
        function seleccionarEvento(e) {
            if(eventos.length < 5) {
                // Deshabilitar evento
                e.target.disabled = true;
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    titulo: e.target.parentElement.querySelector(".evento__nombre").textContent.trim(),
                }];
        
                mostrarEventos();
            }
            else {
                Swal.fire({
                    title: "Error",
                    text: "Sólo un máximo de cinco eventos",
                    icon: "error",
                    confirmButtonText:"Ok"
                });
            }
        }

        async function submitFormulario(e) {
            e.preventDefault();

            // Obtener el regalo
            const regaloId = document.querySelector("#regalo").value;
            
            const eventosId = eventos.map(evento => evento.id);
            if(eventosId.length === 0 || regaloId === "") {
                Swal.fire({
                    title: "Error",
                    text: "Elige al menos un evento y un regalo",
                    icon: "error",
                    confirmButtonText:"Ok"
                });
                return;
            }

            const datos = new FormData();
            datos.append("eventos", eventosId);
            datos.append("regalo_id", regaloId);

            // const respuesta = await fetch("/registro/conferencias", {
            const respuesta = await fetch("/registro/ticket", {
                method: "POST",
                body: datos,
            });
            // .then(response => {
            //     console.log(response.json());
            // })
            const resultado = await respuesta.json();
            if(resultado.resultado) {
                Swal.fire(
                    "Registro completado",
                    "Se ha actualizado su asistencia a los eventos especificados",
                    "success"
                )
                //.then( () => location.href = `ticket?id=${resultado.token}`);
                .then( () => location.reload()); // mejor recargo la web por si el usuario quisiese cambiar su asistencia
            }
            else {
                Swal.fire({
                    title: "Error",
                    text: "Ha ocurrido un error",
                    icon: "error",
                    confirmButtonText:"Ok"
                })
                .then( () => location.reload());
                return;
            }
        }
    }
})();