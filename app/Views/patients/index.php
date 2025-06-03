<?php include(APPPATH . 'Views/header.php'); ?>

<div class="row">
    <div class="card">
        <div class="card-header">
            <h4 class="page-title">Listado de Pacientes</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="<?= base_url('patients/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Agregar Paciente</a>
            </div>
            <div class="table-responsive">
                <table id="data_table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><b>N.</b></th>
                            <th><b>Código</b></th>
                            <th><b>Nombre</b></th>
                            <th><b>Apellidos</b></th>
                            <th><b>Síntomas</b></th>
                            <th><b>Acciones</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $index => $patient): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $patient['code'] ?></td>
                                <td><?= $patient['first_name'] ?></td>
                                <td><?= $patient['last_name'] ?></td>
                                <td><?= $patient['symptoms'] ?></td>
                                <td>

                                        <a href="<?= base_url('patients/chatbot/' . $patient['id']) ?>" class="btn btn-info btn-sm"><i class="fas fa-stethoscope"></i> Diagnóstico</a>
                                        <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-id="<?= $patient['id'] ?>"><i class="fas fa-trash-alt"></i> Eliminar</a>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Confirmar Eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel">Eliminar Paciente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este paciente?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#data_table').DataTable({
        "pageLength": 10,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });

    $(document).ready(function() {
        let patientId;
        $('#modalEliminar').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            patientId = button.data('id');
        });

        $('#confirmarEliminar').on('click', function() {
            if (patientId) {
                window.location.href = "<?= base_url('patients/delete/') ?>" + patientId;
            } else {
                console.log("Error: ID del paciente no encontrado");
            }
        });
    });
</script>

<?php include(APPPATH . 'Views/footer.php'); ?>