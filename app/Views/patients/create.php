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
                        <center><h4>Datos Generales</h4></center>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="code">Código</label>
                                <input type="text" class="form-control" id="code" name="code" required placeholder="Ingrese el código (3 dígitos)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">Nombre</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="Ingrese el nombre">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Apellidos</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Ingrese los apellidos">
                            </div>
                        </div>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Ingrese la dirección">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <center><h4>Datos de Contacto y Síntomas</h4></center>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Ingrese el teléfono">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="symptoms">Síntomas</label>
                                <textarea class="form-control" id="symptoms" name="symptoms" required placeholder="Describa los síntomas del paciente"></textarea>
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

<script>
    let lastValidatedCode = '';
    let isCurrentCodeValid = false;

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
                    error: function() {
                        isCurrentCodeValid = false;
                        document.getElementById('aceptarButton').disabled = true;
                        toastr.error('Error al validar el código');
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

    $('#phone').on('input', function() {
        let value = $(this).val();
        value = value.replace(/[^0-9]/g, '');
        $(this).val(value);
    });

    document.getElementById('is_active_switch').addEventListener('change', function() {
        document.getElementById('is_active').value = this.checked ? '1' : '0';
    });

    if (!document.getElementById('is_active')) {
        const isActiveInput = document.createElement('input');
        isActiveInput.type = 'hidden';
        isActiveInput.id = 'is_active';
        isActiveInput.name = 'is_active';
        isActiveInput.value = document.getElementById('is_active_switch').checked ? '1' : '0';
        document.querySelector('form').appendChild(isActiveInput);
    }
</script>

<?php include(APPPATH . 'Views/footer.php'); ?>