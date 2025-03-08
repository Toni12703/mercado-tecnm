<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Encuesta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>
<body>
    @include('components.header2')
    <section>
        <div class="container">
            <h2 class="mt-5">Crear Encuesta</h2>

            <form action="{{ route('encuestas.store') }}" method="POST">
                @csrf

                <section class="formulario-crear">
                    <div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Código de Encuesta</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="code" name="code" value="{{ $initialCode }}" readonly required>

                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>

                        <div class="mb-3" style="display: none;">
                            <label for="id_user" class="form-label">Usuario</label>
                            <input type="number" class="form-control" id="id_user" name="id_user" value="{{ auth()->user()->id_user}}" readonly>
                        </div>

                        <button type="button" class="btn btn-secondary" id="addQuestionBtn">Crear Pregunta</button>
                        <button type="submit" class="btn btn-primary">Crear Encuesta</button>
                    </div>

                    <div>
                        <div id="questionsContainer" class="mt-3">
                            <!-- Las preguntas se agregarán aquí dinámicamente -->
                        </div>
                    </div>  

                    <div>
                        <div class="d-flex flex-column align-items-stretch flex-shrink-0 bg-body-tertiary" style="width: 380px;">
                            <div class="list-group list-group-flush border-bottom scrollarea" id="questionList">
                                <!-- Las preguntas guardadas se mostrarán aquí -->
                            </div>
                        </div>
                    </div>
                </section>
                <input type="hidden" name="questions" id="questionsData">
            </form>
        </div>
    </section>

    <script>
        let questionCount = 0;
        let savedQuestions = [];

        // Función para mostrar el formulario de creación de pregunta
        function showCreateQuestionForm() {
            $("#questionsContainer").html(`
                <div class="question-form p-3 border rounded mb-3">
                    <h4>Nueva Pregunta</h4>
                    <div class="mb-2">
                        <label>Pregunta:</label>
                        <input type="text" class="form-control question-text"> <!-- llevaba required -->
                    </div>
                    <div class="mb-2">
                        <label>Tipo de Respuesta:</label>
                        <select class="form-control response-type"> <!-- llevaba required -->
                            <option value="">--Seleccione--</option>
                            <option value="text">Campo de texto</option>
                            <option value="multiple">Opción Múltiple</option>
                            <option value="rate">Rate</option>
                        </select>
                    </div>
                    <div class="attributes-container"></div>
                    <button type="button" class="btn btn-success save-question-btn" disabled>Guardar</button>
                </div>
            `);
        }

        // Mostrar el formulario de creación al cargar la página
        showCreateQuestionForm();

        // Manejar el clic en "Crear Pregunta"
        $("#addQuestionBtn").click(function () {
            showCreateQuestionForm();
        });


        $(document).on("submit", "form", function () {
            if (savedQuestions.length === 0) {
                alert("Debe agregar al menos una pregunta.");
                return false; // Evita el envío
            }

            $("#questionsData").val(JSON.stringify(savedQuestions));
        });


  
        // Manejar el cambio en el tipo de respuesta tawueno
        $(document).on("change", ".response-type", function () {
            let questionForm = $(this).closest(".question-form");
            let attributesContainer = questionForm.find(".attributes-container");
            let saveButton = questionForm.find(".save-question-btn");
            let selectedType = $(this).val();

            attributesContainer.html("");
            saveButton.prop("disabled", selectedType === "");

            if (selectedType === "text") {
                attributesContainer.html(`
                    <div class="mb-2">
                        <label>Límite de caracteres:</label>
                        <input type="number" class="form-control char-limit" min="1">
                    </div>
                    <div class="mb-2">
                        <label>Opciones:</label><br>
                        <input type="radio" name="text-format" class="text-uppercase" id="radio-uppercase" value="uppercase">
                        <label for="radio-uppercase">Solo mayúsculas</label>
                        <input type="radio" name="text-format" class="text-lowercase" id="radio-lowercase" value="lowercase">
                        <label for="radio-lowercase">Solo minúsculas</label>
                    </div>
                `);
            } else if (selectedType === "multiple") {
                attributesContainer.html(`
                    <div class="mb-2">
                        <button type="button" class="btn btn-sm btn-info add-option">Agregar Opción</button>
                        <div class="options-container mt-2"></div>
                    </div>
                    <div class="mb-2" style="display: none;">
                        <label>Opciones seleccionables:</label>
                        <input type="number" class="form-control max-selections" min="1" max="8">
                    </div>
                `);
            } else if (selectedType === "rate") {
                attributesContainer.html(`
                    <div class="mb-2">
                        <label>Número de estrellas:</label>
                        <select class="form-control rate-options">
                            <option value="3">3</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <!--<div class="mb-2">
                    //     <label>Tipo de icono:</label>
                    //     <select class="form-control rate-icons">
                    //         <option value="stars">Estrellas</option>
                    //         <option value="faces">Caras</option>
                    //     </select>
                    // </div>-->
                `);
            }
        });

        // Manejar la adición de opciones en preguntas de opción múltiple
        $(document).on("click", ".add-option", function () {
            let optionsContainer = $(this).siblings(".options-container");
            if (optionsContainer.children().length < 8) {
                let optionId = optionsContainer.children().length + 1;
                optionsContainer.append(`
                    <div class="d-flex align-items-center mb-1">
                        <input type="text" class="form-control option-text" placeholder="Opción ${optionId}">
                        <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                    </div>
                `);
            }
        });

        // Manejar la eliminación de opciones
        $(document).on("click", ".remove-option", function () {
            $(this).parent().remove();
        });

        // Guardar una pregunta
        $(document).on("click", ".save-question-btn", function () {
            let questionForm = $(this).closest(".question-form");
            let questionText = questionForm.find(".question-text").val();
            let responseType = questionForm.find(".response-type").val();
            let questionId = questionForm.data("question-id");
            let attributes = {};

            if (!questionText) {
                alert("La pregunta no puede estar vacía.");
                return;
            }

            if (responseType === "text") {
                attributes.charLimit = questionForm.find(".char-limit").val();
                attributes.uppercase = questionForm.find(".text-uppercase").is(":checked");
                attributes.lowercase = questionForm.find(".text-lowercase").is(":checked");
            } else if (responseType === "multiple") {
                attributes.options = questionForm.find(".option-text").map(function () {
                    return $(this).val();
                }).get();
                attributes.maxSelections = questionForm.find(".max-selections").val();
            } else if (responseType === "rate") {
                attributes.rateCount = questionForm.find(".rate-options").val();
                attributes.iconType = questionForm.find(".rate-icons").val();
            }

            let questionData = { 
                id: questionId || savedQuestions.length + 1, 
                text: questionText, 
                type: responseType, 
                attributes: attributes // Aquí se pasa el objeto 'attributes' que se manda al backend
            };

            if (questionId) {
                // Actualizar pregunta existente
                let questionIndex = savedQuestions.findIndex(q => q.id === questionId);
                savedQuestions[questionIndex] = questionData;
            } else {
                // Guardar nueva pregunta
                savedQuestions.push(questionData);
            }

            updateQuestionList();
            showCreateQuestionForm(); // Mostrar el formulario de creación después de guardar
        });

        function seleccionarUno(checkbox) {
            document.querySelectorAll('input[name="opcion"]').forEach((cb) => {
                if (cb !== checkbox) cb.checked = false;
            });
        }


        // Actualizar la lista de preguntas
        function updateQuestionList() {
            $("#questionList").html("");
            savedQuestions.forEach(q => {
                $("#questionList").append(`
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-id="${q.id}">
                        Pregunta ${q.id}: ${q.text} (${q.type})
                        <button class="btn btn-danger btn-sm delete-question" data-id="${q.id}">Eliminar</button>
                    </a>
                `);
            });
        }

        // Eliminar una pregunta
        $(document).on("click", ".delete-question", function () {
            let questionId = $(this).data("id");
            savedQuestions = savedQuestions.filter(q => q.id !== questionId);
            updateQuestionList();
        });

        // Editar una pregunta
        $(document).on("click", ".list-group-item", function (e) {
            e.preventDefault();
            if (!$(e.target).hasClass("delete-question")) {
                let questionId = $(this).data("id");
                let questionData = savedQuestions.find(q => q.id === questionId);
                if (!questionData) return;

                $("#questionsContainer").html(`
                    <div class="question-form p-3 border rounded mb-3" data-question-id="${questionData.id}">
                        <h4>Editar Pregunta ${questionData.id}</h4>
                        <div class="mb-2">
                            <label>Pregunta:</label>
                            <input type="text" class="form-control question-text" value="${questionData.text}" required>
                        </div>
                        <div class="mb-2">
                            <label>Tipo de Respuesta:</label>
                            <select class="form-control response-type" required>
                                <option value="text" ${questionData.type === "text" ? "selected" : ""}>Campo de texto</option>
                                <option value="multiple" ${questionData.type === "multiple" ? "selected" : ""}>Opción Múltiple</option>
                                <option value="rate" ${questionData.type === "rate" ? "selected" : ""}>Rate</option>
                            </select>
                        </div>
                        <div class="attributes-container"></div>
                        <button type="button" class="btn btn-primary update-question-btn">Actualizar</button>
                        <button type="button" class="btn btn-secondary cancel-edit-btn">Cancelar</button>
                    </div>
                `);

                // Llenar los atributos según el tipo de pregunta
                if (questionData.type === "text") {
                    $(".attributes-container").html(`
                        <div class="mb-2">
                            <label>Límite de caracteres:</label>
                            <input type="number" class="form-control char-limit" min="1" value="${questionData.attributes.charLimit || ""}">
                        </div>
                        <div class="mb-2">
                    <label>Opciones:</label><br>
                    <input type="radio" name="text-format" id="radio-uppercase" class="text-uppercase" value="uppercase" ${questionData.attributes.uppercase ? "checked" : ""}>
                    <label for="radio-uppercase">Solo mayúsculas</label>
                    <input type="radio" name="text-format" id="radio-lowercase" class="text-lowercase" value="lowercase" ${questionData.attributes.lowercase ? "checked" : ""}>
                    <label for="radio-lowercase">Solo minúsculas</label>
                </div>                    `);
                } else if (questionData.type === "multiple") {
                    $(".attributes-container").html(`
                        <div class="mb-2">
                            <button type="button" class="btn btn-sm btn-info add-option">Agregar Opción</button>
                            <div class="options-container mt-2">
                                ${questionData.attributes.options.map((option, index) => `
                                    <div class="d-flex align-items-center mb-1">
                                        <input type="text" class="form-control option-text" value="${option}" placeholder="Opción ${index + 1}">
                                        <button type="button" class="btn btn-danger btn-sm remove-option">X</button>
                                    </div>
                                `).join("")}
                            </div>
                        </div>
                        <div class="mb-2" style="display: none;">
                            <label>Opciones seleccionables:</label>
                            <input type="number" class="form-control max-selections" min="1" max="8" value="${questionData.attributes.maxSelections || ""}">
                        </div>
                    `);
                } else if (questionData.type === "rate") {
                    $(".attributes-container").html(`
                        <div class="mb-2">
                            <label>Número de estrellas:</label>
                            <select class="form-control rate-options">
                                <option value="3" ${questionData.attributes.rateCount === "3" ? "selected" : ""}>3</option>
                                <option value="5" ${questionData.attributes.rateCount === "5" ? "selected" : ""}>5</option>
                            </select>
                      <!--  </div>
                        // <-div class="mb-2">
                        //     <label>Tipo de icono:</label>
                        //     <select class="form-control rate-icons">
                        //         <option value="stars" ${questionData.attributes.iconType === "stars" ? "selected" : ""}>Estrellas</option>
                        //         <option value="faces" ${questionData.attributes.iconType === "faces" ? "selected" : ""}>Caras</option>
                        //     </select>
                        // </div>-->
                    `);
                }

                // Manejar la actualización de la pregunta
                $(document).on("click", ".update-question-btn", function () {
                    let updatedQuestionText = $(".question-text").val().trim();
                    let updatedResponseType = $(".response-type").val();
                    let updatedAttributes = {};

                    //ps ya
//AQUI COMIENZA EL ERROR DE LA ALERTA AL EDITAR 
                    if (updatedQuestionText.length === 0) { // Verificamos si la longitud de la cadena es 0
                        alert("La pregunta no puede estar vacía.");
                        return;
                    }
// PS AQUI TERMINA LO QUE CAUSA EL ERROR
                    if (updatedResponseType === "text") {
                        updatedAttributes.charLimit = $(".char-limit").val();
                        updatedAttributes.uppercase = $(".text-uppercase").is(":checked");
                        updatedAttributes.lowercase = $(".text-lowercase").is(":checked");
                    } else if (updatedResponseType === "multiple") {
                        updatedAttributes.options = $(".option-text").map(function () {
                            return $(this).val();
                        }).get();
                        updatedAttributes.maxSelections = $(".max-selections").val();
                    } else if (updatedResponseType === "rate") {
                        updatedAttributes.rateCount = $(".rate-options").val();
                        updatedAttributes.iconType = $(".rate-icons").val();
                    }

                    let updatedQuestionData = {
                        id: questionData.id,
                        text: updatedQuestionText,
                        type: updatedResponseType,
                        attributes: updatedAttributes
                    };

                    let questionIndex = savedQuestions.findIndex(q => q.id === questionData.id);
                    if (questionIndex !== -1) {
                        savedQuestions[questionIndex] = updatedQuestionData;
                    }

                    updateQuestionList();
                    showCreateQuestionForm(); // Mostrar el formulario de creación después de actualizar
                });

                // Manejar la cancelación de la edición
                $(document).on("click", ".cancel-edit-btn", function () {
                    showCreateQuestionForm();
                });
            }
        });

        // Validar que solo se ingresen números en el campo "Límite de caracteres"
        $(document).on("input", ".char-limit", function () {
            let value = $(this).val();
            $(this).val(value.replace(/\D/g, "")); // Elimina caracteres no numéricos
        });
        

    </script>
</body>
</html>