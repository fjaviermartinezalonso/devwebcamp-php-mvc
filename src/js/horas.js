(function() {
    const horas = document.querySelector("#horas");

    if(horas) {
        const categoria = document.querySelector("[name='categoria_id'");
        const dias = document.querySelectorAll("[name='dia'");
        const inputHiddenDia = document.querySelector("[name='dia_id'");
        const inputHiddenHora = document.querySelector("[name='hora_id'");

        categoria.addEventListener("change", terminoBusqueda);
        dias.forEach(dia => dia.addEventListener("change", terminoBusqueda));

        let busqueda = {
            categoria_id: +categoria.value || "",
            dia: +inputHiddenDia.value || ""
        };

        const busqueda_original = {...busqueda}; // para no perder la referencia de la hora seleccionada al editar
        const hora_original = inputHiddenHora.value || "";

        // En caso de que haya datos se trata de una edicion
        if(!Object.values(busqueda).includes("")) {
            // Necesario await, mientras hace fetch se ejecutan las siguientes lineas y al
            // acabar se añade la hora deshabilitada desde buscarEventos, con lo que no hariamos nada.
            // Para no crear una funcion nueva se ejecuta un async IIFE
            (async () => {
                await buscarEventos();

                // Resaltar hora seleccionada actualmente
                const id = inputHiddenHora.value;
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);
                horaSeleccionada.classList.remove("horas__hora--deshabilitada");
                horaSeleccionada.classList.add("horas__hora--seleccionada");
                horaSeleccionada.onclick = seleccionarHora;
            })();
        }

        function terminoBusqueda(e) {
            busqueda[e.target.name] = e.target.value;

            // Reiniciar campos ocultos y selector de horas
            inputHiddenDia.value = "";
            
            inputHiddenHora.value = "";
            const horaPrevia = document.querySelector(".horas__hora--seleccionada");
            if(horaPrevia) {
                horaPrevia.classList.remove("horas__hora--seleccionada");
            }

            // Solo llamar a la API si el objeto busqueda tiene todos los campos asignados 
            if(!Object.values(busqueda).includes("")) {
                buscarEventos();
            }
        }

        async function buscarEventos() {
            const {dia, categoria_id} = busqueda;
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

            const resultado = await fetch(url);
            const eventos = await resultado.json();
            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {
            // Reiniciar las horas
            const listadoHoras = document.querySelectorAll("#horas li");
            listadoHoras.forEach(li => li.classList.add("horas__hora--deshabilitada"));

            // Comprobar horas ocupadas
            const horasOcupadas = eventos.map(evento => evento.hora_id);
            const listadoHorasArray = Array.from(listadoHoras);
            
            const resultado = listadoHorasArray.filter(li => {
                // habia valor previo porque se esta editando y se cambio el dia
                if( (+busqueda.categoria_id === +busqueda_original.categoria_id) && (+busqueda.dia === +busqueda_original.dia)) {
                    hora_original_seleccionada = li.dataset.horaId === hora_original;
                    return hora_original_seleccionada;
                }
                else {
                    return !horasOcupadas.includes(li.dataset.horaId);
                }
            });
            resultado.forEach(li => li.classList.remove("horas__hora--deshabilitada"));

            const horasDisponibles = document.querySelectorAll("#horas li:not(.horas__hora--deshabilitada)");
            horasDisponibles.forEach( hora => hora.addEventListener("click", seleccionarHora));
        }

        function seleccionarHora(e) {
            // Deshabilitar hora previa
            const horaPrevia = document.querySelector(".horas__hora--seleccionada");
            if(horaPrevia) {
                horaPrevia.classList.remove("horas__hora--seleccionada");
            }
            e.target.classList.add("horas__hora--seleccionada");
            inputHiddenHora.value = e.target.dataset.horaId;
            inputHiddenDia.value = document.querySelector("[name='dia']:checked").value;
        }
    }
})();