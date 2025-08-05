<?php include(APPPATH . 'Views/header.php'); ?>

<div class="row">
    <div class="card">
        <div class="card-header">
            <h4 class="page-title">Crear Paciente</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('patients/store') ?>" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <center>
                            <h4>Datos Generales</h4>
                        </center>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code">Código</label>
                                <input type="text" class="form-control" id="code" name="code" required placeholder="Ingrese el código (3 dígitos)" pattern="[0-9]{3}" maxlength="3">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="first_name">Nombre</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="Ingrese los nombres" pattern="[A-Za-z\s]+" title="Solo letras y espacios son permitidos">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="last_name">Apellidos</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Ingrese los apellidos" pattern="[A-Za-z\s]+" title="Solo letras y espacios son permitidos">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_of_birth">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">Género</label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">Seleccione un género</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                            <option value="O">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Ingrese la dirección">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <center>
                            <h4>Datos de Contacto y Síntomas</h4>
                        </center>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" required placeholder="Ingrese el teléfono (10 dígitos)" pattern="[0-9]{10}" maxlength="10" title="Debe contener exactamente 10 dígitos numéricos">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="symptoms-select-btn">Síntomas</label>
                                <button type="button" class="btn btn-outline-primary w-100" id="symptoms-select-btn" data-bs-toggle="modal" data-bs-target="#symptomsModal">
                                    Seleccionar síntomas
                                </button>
                                <div class="selected-symptoms mt-3">
                                    <div class="d-flex flex-wrap gap-2" id="selected-symptoms-container"></div>
                                    <input type="hidden" id="symptoms-hidden" name="symptoms" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-switch">
                                <input type="checkbox" class="form-check-input" id="is_active_switch" name="is_active" value="1" checked>
                                <label class="form-check-label" for="is_active_switch">Paciente Activo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <center>
                    <button type="submit" class="btn btn-primary" id="aceptarButton">Guardar</button>
                    <a href="<?= base_url('patients') ?>" class="btn btn-secondary">Cancelar</a>
                </center>
            </form>
        </div>
    </div>
</div>

<!-- Modal de síntomas (sin cambios, se mantiene igual) -->
<div class="modal fade" id="symptomsModal" tabindex="-1" aria-labelledby="symptomsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="symptomsModalLabel">Seleccionar síntomas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" class="form-control" id="symptomsSearchModal" placeholder="Buscar síntomas...">
                </div>
                <div class="row symptoms-options" style="max-height: 400px; overflow-y: auto;">
                    <?php
                    $symptoms = [
                        'dolor_cabeza' => 'Dolor de cabeza general',
                        'migraña' => 'Migraña',
                        'cefalea_tensional' => 'Cefalea tensional',
                        'dolor_facial' => 'Dolor facial',
                        'mareos' => 'Mareos',
                        'vertigo' => 'Vértigo',
                        'vision_borrosa' => 'Visión borrosa',
                        'sensibilidad_luz' => 'Sensibilidad a la luz',
                        'sensibilidad_sonido' => 'Sensibilidad al sonido',
                        'nauseas' => 'Náuseas',
                        'vomitos' => 'Vómitos',
                        'adormecimiento_cara' => 'Adormecimiento en la cara',
                        'debilidad_muscular' => 'Debilidad muscular en la cabeza o cuello',
                        'hormigueo' => 'Hormigueo en la cabeza',
                        'confusion' => 'Confusión mental',
                        'dificultad_habla' => 'Dificultad para hablar',
                        'perdida_equilibrio' => 'Pérdida de equilibrio',
                        'convulsiones' => 'Convulsiones',
                        'presion_cabeza' => 'Sensación de presión en la cabeza',
                        'zumbidos_oidos' => 'Zumbidos en los oídos',
                        'rigidez_cuello' => 'Rigidez en el cuello',
                        'fatiga_mental' => 'Fatiga mental',
                        'perdida_memoria' => 'Pérdida de memoria breve',
                        'dolor_ojos' => 'Dolor alrededor de los ojos',
                        'dolor_intenso_unilateral' => 'Dolor intenso unilateral',
                        'lagrimeo_ojo' => 'Lagrimeo en el ojo',
                        'nariz_taponada' => 'Nariz taponada',
                        'dolor_persistente' => 'Dolor persistente',
                        'fiebre_alta' => 'Fiebre alta',
                        'letargo' => 'Letargo',
                        'dolor_cabeza_severa' => 'Dolor de cabeza severa',
                        'vision_doble' => 'Visión doble',
                        'presion_ocular' => 'Presión ocular',
                        'dolor_cabeza_trauma' => 'Dolor de cabeza por trauma',
                        'perdida_conciencia' => 'Pérdida de conciencia',
                        'nauseas_severas' => 'Náuseas severas',
                        'vomitos_proyectiles' => 'Vómitos proyectiles',
                        'debilidad_facial' => 'Debilidad facial',
                        'dificultad_cerrar_ojo' => 'Dificultad para cerrar el ojo',
                        'ansiedad_extrema' => 'Ansiedad extrema',
                        'temblores' => 'Temblores',
                        'aura_visual' => 'Aura visual'
                    ];

                    foreach ($symptoms as $value => $label): ?>
                        <div class="col-md-6 symptom-option">
                            <div class="form-check">
                                <input class="form-check-input symptom-checkbox" type="checkbox" id="modal-symptom-<?= $value ?>" value="<?= $value ?>">
                                <label class="form-check-label" for="modal-symptom-<?= $value ?>"><?= $label ?></label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="saveSymptoms">Guardar selección</button>
            </div>
        </div>
    </div>
</div>

<style>
    .selected-symptoms {
        min-height: 50px;
        border: 1px dashed #ddd;
        border-radius: 5px;
        padding: 10px;
    }

    .symptom-tag {
        display: inline-flex;
        align-items: center;
        background-color: #e9ecef;
        border-radius: 20px;
        padding: 5px 12px;
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .symptom-tag-remove {
        margin-left: 8px;
        cursor: pointer;
        color: #6c757d;
    }

    .symptom-tag-remove:hover {
        color: #dc3545;
    }

    .symptoms-options {
        padding: 10px;
    }

    .symptom-option {
        margin-bottom: 8px;
    }
</style>

<?php include(APPPATH . 'Views/footer.php'); ?>

<script>
    let lastValidatedCode = '';
    let isCurrentCodeValid = false;

    // Validación del código
    $('#code').on('input', function(e) {
        let value = $(this).val();
        let originalValue = value;
        value = value.replace(/[^0-9]/g, '');
        if (value.length > 3) {
            value = value.substring(0, 3);
        }
        if (value !== originalValue) {
            $(this).val(value);
        }
        if (value.length === 3) {
            if (value === lastValidatedCode) {
                document.getElementById('aceptarButton').disabled = !isCurrentCodeValid;
            } else {
                lastValidatedCode = value;
                $.ajax({
                    url: '<?= base_url('patients/validate/') ?>' + value,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.data && response.data.length > 0) {
                            isCurrentCodeValid = false;
                            document.getElementById('aceptarButton').disabled = true;
                            toastr.error('Ya existe este código registrado');
                        } else {
                            isCurrentCodeValid = true;
                            document.getElementById('aceptarButton').disabled = false;
                            toastr.success('Código válido');
                        }
                    },
                    error: function(xhr, status, error) {
                        isCurrentCodeValid = false;
                        document.getElementById('aceptarButton').disabled = true;
                        toastr.error('Error al validar el código: ' + error);
                    }
                });
            }
        } else {
            isCurrentCodeValid = false;
            document.getElementById('aceptarButton').disabled = true;
        }
    });

    $('#code').on('keydown', function(e) {
        if ($(this).val().length >= 3 &&
            !e.ctrlKey && !e.altKey && !e.metaKey &&
            e.key.length === 1 && /^\d$/.test(e.key)) {
            document.getElementById('aceptarButton').disabled = !isCurrentCodeValid;
            e.preventDefault();
        }
    });

    // Validación del teléfono (10 dígitos)
    $('#phone').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9]/g, ''); // Solo números
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        $(this).val(value);
        if (value.length !== 10) {
            document.getElementById('aceptarButton').disabled = true;
        } else {
            document.getElementById('aceptarButton').disabled = !isCurrentCodeValid;
        }
    });

    // Validación de nombres y apellidos (solo letras y espacios)
    $('#first_name, #last_name').on('input', function() {
        let value = $(this).val();
        let fieldName = $(this).attr('name') === 'first_name' ? 'Nombre' : 'Apellidos';
        value = value.replace(/[^A-Za-z\s]/g, ''); // Solo letras y espacios
        $(this).val(value);
        if (!/^[A-Za-z\s]+$/.test(value) && value !== '') {
            document.getElementById('aceptarButton').disabled = true;
        } else if (value === '') {
            document.getElementById('aceptarButton').disabled = true;
        } else {
            document.getElementById('aceptarButton').disabled = !isCurrentCodeValid;
        }
    });

    // Manejo del switch de activo
    document.getElementById('is_active_switch').addEventListener('change', function() {
        const isActiveInput = document.getElementById('is_active');
        isActiveInput.value = this.checked ? '1' : '0';
    });

    if (!document.getElementById('is_active')) {
        const isActiveInput = document.createElement('input');
        isActiveInput.type = 'hidden';
        isActiveInput.id = 'is_active';
        isActiveInput.name = 'is_active';
        isActiveInput.value = document.getElementById('is_active_switch').checked ? '1' : '0';
        document.querySelector('form').appendChild(isActiveInput);
    }

    // Manejo del modal de síntomas
    $(document).ready(function() {
        // Actualizar síntomas seleccionados
        function updateSelectedSymptoms() {
            const selectedSymptoms = [];
            const selectedContainer = $('#selected-symptoms-container');
            selectedContainer.empty();

            $('.symptom-checkbox:checked').each(function() {
                const value = $(this).val();
                const label = $(this).next('label').text();
                selectedSymptoms.push(value);

                selectedContainer.append(`
                    <span class="symptom-tag">
                        ${label}
                        <span class="symptom-tag-remove" data-value="${value}">×</span>
                    </span>
                `);
            });

            $('#symptoms-hidden').val(selectedSymptoms.length > 0 ? selectedSymptoms.join(',') : '');
            return selectedSymptoms.length > 0;
        }

        // Búsqueda en modal
        $('#symptomsSearchModal').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.symptom-option').each(function() {
                const label = $(this).find('label').text().toLowerCase();
                $(this).toggle(label.includes(searchTerm));
            });
        });

        // Guardar selección
        $('#saveSymptoms').click(function() {
            if (updateSelectedSymptoms()) {
                $('#symptomsModal').modal('hide');
                $('#aceptarButton').focus();
            } else {
                toastr.error('Por favor, seleccione al menos un síntoma.');
            }
        });

        // Eliminar síntoma desde el tag
        $('#selected-symptoms-container').on('click', '.symptom-tag-remove', function() {
            const value = $(this).data('value');
            $(`#modal-symptom-${value}`).prop('checked', false);
            updateSelectedSymptoms();
        });

        // Asegurar que el modal se cierre completamente
        $('#symptomsModal').on('hidden.bs.modal', function() {
            updateSelectedSymptoms();
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open');
            $('body').css('overflow', 'auto');
            $('#aceptarButton').prop('disabled', !isCurrentCodeValid || !updateSelectedSymptoms());
        });

        // Validación antes de enviar el formulario
        $('#aceptarButton').on('click', function(e) {
            const phone = $('#phone').val();
            const firstName = $('#first_name').val();
            const lastName = $('#last_name').val();

            if (!updateSelectedSymptoms()) {
                e.preventDefault();
                toastr.error('Por favor, seleccione al menos un síntoma.');
                return;
            }

            if (!isCurrentCodeValid) {
                e.preventDefault();
                toastr.error('El código no es válido o ya está registrado.');
                return;
            }

            if (!/^[0-9]{10}$/.test(phone)) {
                e.preventDefault();
                return;
            }

            if (!/^[A-Za-z\s]+$/.test(firstName)) {
                e.preventDefault();
                return;
            }

            if (!/^[A-Za-z\s]+$/.test(lastName)) {
                e.preventDefault();
                return;
            }
        });
    });
</script>