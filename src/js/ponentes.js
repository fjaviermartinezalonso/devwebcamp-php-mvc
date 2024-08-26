(function() {
    const ponentesInput = document.querySelector("#ponentes");
    const listadoPonentes = document.querySelector("#listado-ponentes");
    const ponenteHidden = document.querySelector("[name='ponente_id']");

    if(ponentesInput) {
        let ponentes = [];
        let ponentesFiltrados = [];

        obtenerPonentes();

        ponentesInput.addEventListener("input", buscarPonentes);

        if(ponenteHidden.value) {
            (async () => {
                const ponente = await obtenerPonente(ponenteHidden.value);

                // Insertar en el HTML
                const ponenteDOM = document.createElement("LI");
                ponenteDOM.classList.add("listado-ponentes__ponente", "listado-ponentes__ponente--seleccionado");
                ponenteDOM.textContent = `${ponente.nombre} ${ponente.apellido}`;
                listadoPonentes.appendChild(ponenteDOM);
            })();
        }

        async function obtenerPonente(id) {
            const url = `/api/ponente?id=${id}`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            return resultado;
        }

        async function obtenerPonentes() {
            const url = `/api/ponentes`;

            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            
            formatearPonentes(resultado);
        }

        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map( ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            });
        }

        function buscarPonentes(e) {
            const busqueda = e.target.value;

            ponentesFiltrados = [];

            if(busqueda.length > 0) { // reaccionar tras escribir al menos 3 caracteres
                const regExp = new RegExp(busqueda, "i"); // tanto mayusculas como minusculas

                ponentesFiltrados = ponentes.filter(ponente => {
                    if(ponente.nombre.toLowerCase().search(regExp) != -1) { // coincidencia
                        return ponente;
                    }
                });
            }

            mostrarPonentes();
        }

        function mostrarPonentes() {
            while(listadoPonentes.firstChild) {
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }

            if(ponentesFiltrados.length > 0) {
                ponentesFiltrados.forEach(ponente => {
                    const ponenteHTML = document.createElement("LI");
                    ponenteHTML.classList.add("listado-ponentes__ponente");
                    ponenteHTML.textContent = ponente.nombre;
                    ponenteHTML.dataset.ponenteId = ponente.id;
                    ponenteHTML.onclick = seleccionarPonente;
        
                    listadoPonentes.appendChild(ponenteHTML);
                });
            }
            else {
                const sinResultados = document.createElement("P");
                sinResultados.classList.add("listado-ponentes__no-resultado");
                sinResultados.textContent = "No hay coincidencias";

                listadoPonentes.appendChild(sinResultados);
            }
        }

        function seleccionarPonente(e) {
            const ponente = e.target;

            // Eliminar seleccion previa
            const ponentePrevio = document.querySelector(".listado-ponentes__ponente--seleccionado");
            if(ponentePrevio) {
                ponentePrevio.classList.remove("listado-ponentes__ponente--seleccionado");
            }

            ponente.classList.add("listado-ponentes__ponente--seleccionado");
            ponenteHidden.value = ponente.dataset.ponenteId;
        }
    }
})();