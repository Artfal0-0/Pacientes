<?php include(APPPATH . 'Views/header.php'); ?>

<div class="container-fluid px-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">
                <i class="fas fa-users me-2"></i>Gestión de Pacientes
            </h2>
            <p class="text-muted mb-0">Administra la información de todos los pacientes registrados</p>
        </div>
        <a href="<?= base_url('patients/create') ?>" class="btn btn-primary btn-lg shadow-sm">
            <i class="fas fa-plus me-2"></i>Nuevo Paciente
        </a>
    </div>

    <!-- Main Content Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="fas fa-list-alt me-2 text-primary"></i>Listado de Pacientes
                    </h5>
                </div>

            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="data_table" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="fw-semibold">Código</th>
                            <th class="fw-semibold">
                                <i class="fas fa-user me-1 text-muted"></i>Nombre
                            </th>
                            <th class="fw-semibold">
                                <i class="fas fa-notes-medical me-1 text-muted"></i>Síntomas
                            </th>
                            <th class="text-center fw-semibold no-print" style="width: 200px;">
                                <i class="fas fa-cogs me-1 text-muted"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patients as $index => $patient): ?>
                            <tr class="border-bottom">
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info fw-normal px-3 py-2">
                                        <?= $patient['code'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="patient-avatar me-3">
                                            <i class="fas fa-user-circle patient-icon"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark patient-name">
                                                <?= $patient['first_name'] . ' ' . $patient['last_name'] ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-warning bg-opacity-10 text-warning fw-normal px-3 py-2">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        <?= strlen($patient['symptoms']) > 50 ? substr($patient['symptoms'], 0, 50) . '...' : $patient['symptoms'] ?>
                                    </span>
                                </td>
                                <td class="text-center no-print">
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('patients/chatbot/' . $patient['id']) ?>"
                                            class="btn btn-success btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Realizar Diagnóstico">
                                            <i class="fas fa-robot"></i>
                                        </a>
                                        <a href="<?= base_url('patients/edit/' . $patient['id']) ?>"
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="tooltip"
                                            title="Editar Paciente">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar"
                                            data-id="<?= $patient['id'] ?>"
                                            data-name="<?= $patient['first_name'] . ' ' . $patient['last_name'] ?>"
                                            title="Eliminar Paciente">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Mejorado para Confirmar Eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="modalEliminarLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <i class="fas fa-user-times text-danger" style="font-size: 4rem; opacity: 0.7;"></i>
                </div>
                <h6 class="fw-semibold mb-3">¿Estás seguro de que deseas eliminar este paciente?</h6>
                <p class="text-muted mb-4">
                    Se eliminará permanentemente el paciente: <strong id="patientName"></strong>
                    <br><small>Esta acción no se puede deshacer.</small>
                </p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger px-4" id="confirmarEliminar">
                    <i class="fas fa-trash me-2"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Inicializar DataTable con configuración mejorada
        var table = $('#data_table').DataTable({
            "pageLength": 10,
            "responsive": true,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"i>>p',
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "zeroRecords": "No se encontraron registros que coincidan",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "emptyTable": "No hay datos disponibles en la tabla",
                "loadingRecords": "Cargando...",
                "processing": "Procesando..."
            },
            "columnDefs": [{
                    "orderable": false,
                    "targets": 3
                }, // Desactivar ordenamiento en columna de acciones
                {
                    "searchable": false,
                    "targets": [0, 3]
                } // Desactivar búsqueda en # y acciones
            ],
            "order": [
                [1, 'asc']
            ], // Ordenar por nombre por defecto
        });

        // Asociar botones al DOM (ya se manejan con "dom" y "buttons")
        table.buttons().container().appendTo('#data_table_wrapper .col-md-6:eq(1)');

        // Manejo mejorado del modal de eliminación
        let patientId;
        let patientName;

        $('#modalEliminar').on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            patientId = button.data('id');
            patientName = button.data('name');
            $('#patientName').text(patientName);
        });

        $('#confirmarEliminar').on('click', function() {
            if (patientId) {
                $(this).html('<i class="fas fa-spinner fa-spin me-2"></i>Eliminando...')
                    .prop('disabled', true);
                setTimeout(function() {
                    window.location.href = '<?= base_url('patients/delete/') ?>' + patientId;
                }, 500);
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error('Error: No se pudo obtener el ID del paciente.');
                } else {
                    alert('Error: No se pudo obtener el ID del paciente.');
                }
                $('#modalEliminar').modal('hide');
            }
        });

        // Animación al cargar la página
        $('.card').hide().fadeIn(600);

        // Efecto hover mejorado en las filas
        $('#data_table tbody tr').hover(
            function() {
                $(this).addClass('table-active');
            },
            function() {
                $(this).removeClass('table-active');
            }
        );
    });
</script>

<style>
    /* Estilos mejorados para la visibilidad del texto */
    .stats-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .stats-label {
        color: rgba(255, 255, 255, 0.9) !important;
        font-weight: 500;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .stats-number {
        color: #ffffff !important;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        font-size: 2rem;
    }

    .stats-icon {
        color: rgba(255, 255, 255, 0.8) !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        color: #495057 !important;
        background-color: #f8f9fa !important;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem 0.75rem;
        color: #212529;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .badge {
        border-radius: 8px;
        font-weight: 500;
    }

    .modal-content {
        border-radius: 15px;
    }

    .bg-gradient {
        position: relative;
        overflow: hidden;
    }

    .bg-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .bg-gradient:hover::before {
        opacity: 1;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }

    /* Animación para los iconos */
    .fa-robot:hover,
    .fa-edit:hover,
    .fa-trash:hover {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }

    /* Mejoras de contraste para texto */
    .text-dark {
        color: #212529 !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .fw-semibold {
        font-weight: 600 !important;
        color: #495057 !important;
    }

    /* Estilos para impresión */
    @media print {
        .no-print {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #dee2e6 !important;
        }

        .stats-card {
            background: #f8f9fa !important;
            color: #212529 !important;
        }

        .stats-label,
        .stats-number,
        .stats-icon {
            color: #212529 !important;
            text-shadow: none !important;
        }
    }

    /* Asegurar que los badges tengan buen contraste */
    .badge.bg-info {
        background-color: #0dcaf0 !important;
        color: #000 !important;
    }

    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    .badge.bg-light {
        background-color: #f8f9fa !important;
        color: #212529 !important;
        border: 1px solid #dee2e6;
    }
</style>

<?php include(APPPATH . 'Views/footer.php'); ?>