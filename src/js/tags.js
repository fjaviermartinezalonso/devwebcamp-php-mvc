(function() {
    const tagsInput = document.querySelector("#tags_input");

    if(tagsInput) {
        const tagsDiv = document.querySelector("#tags");
        const tagsInputHidden = document.querySelector("[name='tags']");

        let tags = [];

        // Leer tags previos del input hidden
        if(tagsInputHidden.value !== "") {
            tags = tagsInputHidden.value.split(",");
            mostrarTags();
        }

        // Escuchar cambios del input
        tagsInput.addEventListener("keypress", guardarTag);
        
        function guardarTag(e) {
            if(e.key === ",") {
                
                e.preventDefault(); // no agregar la coma al input

                // Tag vacío
                if((e.target.value.trim() === "") || (e.target.value.length < 1)) {
                    return;
                }
                
                tags = [...tags, e.target.value.trim()]; // almacenar tag
                tagsInput.value = ""; // limpiar input
    
                mostrarTags();
            }
        }

        function mostrarTags() {
            tagsDiv.textContent = ""
            tags.forEach(tag => {
                const etiqueta = document.createElement("LI")
                etiqueta.classList.add("formulario__tag")
                etiqueta.textContent = tag;
                etiqueta.ondblclick = eliminarTag
                tagsDiv.appendChild(etiqueta)
            })
            actualizarInputHidden()
        }

        function eliminarTag(e) {
            e.target.remove()
            tags = tags.filter(tag => tag != e.target.textContent)
            actualizarInputHidden()
        }

        function actualizarInputHidden() {
            tagsInputHidden.value = tags.toString()
        }
    }

})();