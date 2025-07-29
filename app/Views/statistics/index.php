<?php include(APPPATH . 'Views/header.php'); ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5 display-4 text-primary">
                <i class="fas fa-chart-bar me-3"></i>Dashboard Estadístico de Pacientes
            </h1>
        </div>
    </div>

    <!-- Resumen General con Iconos -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1">Total de Pacientes</h6>
                            <h2 class="mb-0 display-5"><?php echo $totalPatients; ?></h2>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-users fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1">Pacientes Activos</h6>
                            <h2 class="mb-0 display-5"><?php echo $activePatients; ?></h2>
                            <small class="text-white-50"><?php echo round(($activePatients / $totalPatients) * 100, 1); ?>%</small>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-heartbeat fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1">Pacientes Inactivos</h6>
                            <h2 class="mb-0 display-5"><?php echo $inactivePatients; ?></h2>
                            <small class="text-white-50"><?php echo round(($inactivePatients / $totalPatients) * 100, 1); ?>%</small>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-user-slash fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title text-white-50 mb-1">Edad Promedio</h6>
                            <?php
                            $totalAge = 0;
                            $validPatients = 0;
                            foreach ($patients as $patient) {
                                $dateOfBirth = new DateTime($patient['date_of_birth']);
                                $today = new DateTime();
                                $age = $today->diff($dateOfBirth)->y;
                                if ($age > 0) {
                                    $totalAge += $age;
                                    $validPatients++;
                                }
                            }
                            $averageAge = $validPatients > 0 ? round($totalAge / $validPatients) : 0;
                            ?>
                            <h2 class="mb-0 display-5"><?php echo $averageAge; ?></h2>
                            <small class="text-white-50">años</small>
                        </div>
                        <div class="ms-3">
                            <i class="fas fa-birthday-cake fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Primera fila de gráficos - Distribución General -->
    <div class="row mb-5">
        <!-- Gráfico de Distribución por Género -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-venus-mars me-2 text-primary"></i>
                        Distribución por Género
                    </h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Estado de Pacientes -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-success"></i>
                        Estado de Pacientes
                    </h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Distribución por Rango de Edad -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-layer-group me-2 text-info"></i>
                        Rango de Edades
                    </h5>
                </div>
                <div class="card-body">
                    <?php
                    $ageRanges = [
                        '0-18' => 0,
                        '19-35' => 0,
                        '36-50' => 0,
                        '51-65' => 0,
                        '66+' => 0
                    ];

                    foreach ($patients as $patient) {
                        $dateOfBirth = new DateTime($patient['date_of_birth']);
                        $today = new DateTime();
                        $age = $today->diff($dateOfBirth)->y;

                        if ($age <= 18) $ageRanges['0-18']++;
                        elseif ($age <= 35) $ageRanges['19-35']++;
                        elseif ($age <= 50) $ageRanges['36-50']++;
                        elseif ($age <= 65) $ageRanges['51-65']++;
                        else $ageRanges['66+']++;
                    }
                    ?>
                    <div class="card-body" style="height: 300px; position: relative;">
                        <canvas id="ageRangeChart" style="height: 280px; width: 100%"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila - Análisis Detallado -->
    <div class="row mb-5">
        <!-- Tabla de Estadísticas Detallada -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2 text-primary"></i>
                        Resumen Detallado por Género
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th><i class="fas fa-venus-mars me-1"></i>Género</th>
                                    <th><i class="fas fa-hashtag me-1"></i>Cantidad</th>
                                    <th><i class="fas fa-percentage me-1"></i>Porcentaje</th>
                                    <th><i class="fas fa-chart-line me-1"></i>Visual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($genderCount as $gender => $count): ?>
                                    <?php if ($count > 0): ?>
                                        <?php
                                        $percentage = ($count / $totalPatients) * 100;
                                        $genderName = $gender === 'M' ? 'Masculino' : ($gender === 'F' ? 'Femenino' : 'Otro');
                                        $colorClass = $gender === 'M' ? 'primary' : ($gender === 'F' ? 'danger' : 'warning');
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-<?php echo $colorClass; ?> me-2">
                                                    <?php echo $gender; ?>
                                                </span>
                                                <?php echo $genderName; ?>
                                            </td>
                                            <td><strong><?php echo $count; ?></strong></td>
                                            <td><?php echo number_format($percentage, 1); ?>%</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-<?php echo $colorClass; ?>"
                                                        role="progressbar"
                                                        style="width: <?php echo $percentage; ?>%"
                                                        aria-valuenow="<?php echo $percentage; ?>"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Síntomas con Métricas -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-trophy me-2 text-warning"></i>
                        Top 8 Síntomas Más Frecuentes
                    </h5>
                </div>
                <div class="card-body">
                    <?php $symptomColors = ['success', 'info', 'warning', 'danger', 'primary', 'secondary', 'dark', 'light']; ?>
                    <?php $index = 0; ?>
                    <?php foreach (array_slice($symptomCount, 0, 8) as $symptom => $count): ?>
                        <?php
                        $symptomPercentage = ($count / $totalPatients) * 100;
                        $colorClass = $symptomColors[$index % count($symptomColors)];
                        ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background-color: rgba(0,0,0,0.05);">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-<?php echo $colorClass; ?> me-2">#<?php echo $index + 1; ?></span>
                                    <strong><?php echo ucwords(str_replace('_', ' ', $symptom)); ?></strong>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-<?php echo $colorClass; ?>"
                                        style="width: <?php echo $symptomPercentage; ?>%"></div>
                                </div>
                                <small class="text-muted"><?php echo number_format($symptomPercentage, 1); ?>% de pacientes</small>
                            </div>
                            <div class="text-end ms-3">
                                <h5 class="mb-0 text-<?php echo $colorClass; ?>"><?php echo $count; ?></h5>
                                <small class="text-muted">casos</small>
                            </div>
                        </div>
                        <?php $index++; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas Adicionales -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-area me-2 text-success"></i>
                        Métricas Avanzadas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded" style="background: linear-gradient(45deg, #ff6b6b, #ee5a24);">
                                <i class="fas fa-users fa-2x text-white mb-2"></i>
                                <h4 class="text-white mb-1">
                                    <?php
                                    $malePatients = $genderCount['M'] ?? 0;
                                    $femalePatients = $genderCount['F'] ?? 0;
                                    $ratio = $femalePatients > 0 ? round($malePatients / $femalePatients, 2) : 0;
                                    echo $ratio . ':1';
                                    ?>
                                </h4>
                                <small class="text-white-50">Ratio H:M</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded" style="background: linear-gradient(45deg, #5f27cd, #341f97);">
                                <i class="fas fa-calculator fa-2x text-white mb-2"></i>
                                <h4 class="text-white mb-1">
                                    <?php echo round(array_sum($symptomCount) / count($symptomCount), 1); ?>
                                </h4>
                                <small class="text-white-50">Síntomas promedio por tipo</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded" style="background: linear-gradient(45deg, #00d2d3, #54a0ff);">
                                <i class="fas fa-heartbeat fa-2x text-white mb-2"></i>
                                <h4 class="text-white mb-1">
                                    <?php echo round(($activePatients / $totalPatients) * 100, 1); ?>%
                                </h4>
                                <small class="text-white-50">Tasa de actividad</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="p-3 rounded" style="background: linear-gradient(45deg, #ff9ff3, #f368e0);">
                                <i class="fas fa-chart-line fa-2x text-white mb-2"></i>
                                <h4 class="text-white mb-1">
                                    <?php echo count($symptomCount); ?>
                                </h4>
                                <small class="text-white-50">Tipos de síntomas únicos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tercera fila - Gráficos Avanzados -->
    <div class="row mb-5">
        <!-- Gráfico de Línea Temporal -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2 text-primary"></i>
                        Tendencia de Registros por Edad
                    </h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    <canvas id="ageLineChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Gráfico de Densidad -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-spider me-2 text-danger"></i>
                        Análisis de Densidad
                    </h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    <canvas id="densityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Cuarta fila - Análisis Comparativo -->
    <div class="row mb-5">
        <!-- Distribución de Síntomas por Género -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-th me-2 text-warning"></i>
                        Distribución de Síntomas por Género
                    </h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    <canvas id="symptomGenderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Actividad por Rango de Edad -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2 text-success"></i>
                        Actividad por Rango de Edad
                    </h5>
                </div>
                <div class="card-body" style="height: 400px;">
                    <canvas id="ageActivityChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quinta fila - Análisis Especializado -->
    <div class="row mb-5">
        <!-- Concentración de Edades -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-mountain me-2 text-info"></i>
                        Concentración de Edades
                    </h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="ageConcentrationChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Correlación Edad-Síntomas -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-circle me-2 text-secondary"></i>
                        Correlación Edad-Síntomas
                    </h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="bubbleChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Índice de Salud General -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                        Índice de Salud General
                    </h5>
                </div>
                <div class="card-body" style="height: 350px;">
                    <canvas id="gaugeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
    // Configuración global de Chart.js
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.plugins.legend.position = 'bottom';

    // Gráfico de Género
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: [
                <?php foreach ($genderCount as $gender => $count): ?>
                    <?php if ($count > 0): ?> '<?php echo $gender === "M" ? "Masculino" : ($gender === "F" ? "Femenino" : "Otro"); ?>',
                    <?php endif; ?>
                <?php endforeach; ?>
            ],
            datasets: [{
                data: [
                    <?php foreach ($genderCount as $count): ?>
                        <?php if ($count > 0): ?>
                            <?php echo $count; ?>,
                        <?php endif; ?>
                    <?php endforeach; ?>
                ],
                backgroundColor: [
                    '#36a2eb',
                    '#ff6384',
                    '#ffcd56',
                    '#4bc0c0'
                ],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Gráfico de Estado
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: ['Activos', 'Inactivos'],
            datasets: [{
                data: [<?php echo $activePatients; ?>, <?php echo $inactivePatients; ?>],
                backgroundColor: [
                    '#28a745',
                    '#dc3545'
                ],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Gráfico de Rango de Edades
    const ageRangeCtx = document.getElementById('ageRangeChart').getContext('2d');
    new Chart(ageRangeCtx, {
        type: 'polarArea',
        data: {
            labels: [
                <?php foreach ($ageRanges as $range => $count): ?> '<?php echo $range; ?> años',
                <?php endforeach; ?>
            ],
            datasets: [{
                data: [
                    <?php foreach ($ageRanges as $count): ?>
                        <?php echo $count; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: [
                    '#ff6384',
                    '#36a2eb',
                    '#ffcd56',
                    '#4bc0c0',
                    '#9966ff'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Gráfico de Línea de Tendencia de Edades
    const ageLineCtx = document.getElementById('ageLineChart').getContext('2d');
    const ageData = [];
    <?php
    for ($age = 0; $age <= 100; $age += 5) {
        $count = 0;
        foreach ($patients as $patient) {
            $dateOfBirth = new DateTime($patient['date_of_birth']);
            $today = new DateTime();
            $patientAge = $today->diff($dateOfBirth)->y;
            if ($patientAge >= $age && $patientAge < $age + 5) {
                $count++;
            }
        }
        echo "ageData.push({x: $age, y: $count});\n";
    }
    ?>

    new Chart(ageLineCtx, {
        type: 'line',
        data: {
            datasets: [{
                label: 'Pacientes por Edad',
                data: ageData,
                borderColor: '#36a2eb',
                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#36a2eb',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Edad (años)'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Número de Pacientes'
                    }
                }
            }
        }
    });

    // Gráfico de Densidad
    const densityCtx = document.getElementById('densityChart').getContext('2d');
    new Chart(densityCtx, {
        type: 'polarArea',
        data: {
            labels: ['Activos', 'Inactivos', 'Masculino', 'Femenino'],
            datasets: [{
                data: [
                    <?php echo $activePatients; ?>,
                    <?php echo $inactivePatients; ?>,
                    <?php echo $genderCount['M'] ?? 0; ?>,
                    <?php echo $genderCount['F'] ?? 0; ?>
                ],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Gráfico de Síntomas por Género
    const symptomGenderCtx = document.getElementById('symptomGenderChart').getContext('2d');
    <?php
    $topSymptoms = array_slice($symptomCount, 0, 6);
    $symptomsByGender = ['M' => [], 'F' => []];

    foreach ($topSymptoms as $symptom => $count) {
        $symptomsByGender['M'][$symptom] = 0;
        $symptomsByGender['F'][$symptom] = 0;

        foreach ($patients as $patient) {
            if (stripos($patient['symptoms'], $symptom) !== false) {
                if (isset($symptomsByGender[$patient['gender']])) {
                    $symptomsByGender[$patient['gender']][$symptom]++;
                }
            }
        }
    }
    ?>

    new Chart(symptomGenderCtx, {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($topSymptoms as $symptom => $count): ?> '<?php echo ucwords(str_replace("_", " ", $symptom)); ?>',
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Masculino',
                data: [
                    <?php foreach ($topSymptoms as $symptom => $count): ?>
                        <?php echo $symptomsByGender['M'][$symptom] ?? 0; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Femenino',
                data: [
                    <?php foreach ($topSymptoms as $symptom => $count): ?>
                        <?php echo $symptomsByGender['F'][$symptom] ?? 0; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Actividad por Edad (Barras Horizontales)
    const ageActivityCtx = document.getElementById('ageActivityChart').getContext('2d');
    <?php
    $ageActivity = [
        '0-18' => ['active' => 0, 'inactive' => 0],
        '19-35' => ['active' => 0, 'inactive' => 0],
        '36-50' => ['active' => 0, 'inactive' => 0],
        '51-65' => ['active' => 0, 'inactive' => 0],
        '66+' => ['active' => 0, 'inactive' => 0]
    ];

    foreach ($patients as $patient) {
        $dateOfBirth = new DateTime($patient['date_of_birth']);
        $today = new DateTime();
        $age = $today->diff($dateOfBirth)->y;

        $ageGroup = '';
        if ($age <= 18) $ageGroup = '0-18';
        elseif ($age <= 35) $ageGroup = '19-35';
        elseif ($age <= 50) $ageGroup = '36-50';
        elseif ($age <= 65) $ageGroup = '51-65';
        else $ageGroup = '66+';

        if ($patient['is_active']) {
            $ageActivity[$ageGroup]['active']++;
        } else {
            $ageActivity[$ageGroup]['inactive']++;
        }
    }
    ?>

    new Chart(ageActivityCtx, {
        type: 'bar',
        data: {
            labels: ['0-18 años', '19-35 años', '36-50 años', '51-65 años', '66+ años'],
            datasets: [{
                label: 'Activos',
                data: [
                    <?php foreach ($ageActivity as $data): ?>
                        <?php echo $data['active']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }, {
                label: 'Inactivos',
                data: [
                    <?php foreach ($ageActivity as $data): ?>
                        <?php echo $data['inactive']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(220, 53, 69, 0.8)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Área - Concentración de Edades
    const ageConcentrationCtx = document.getElementById('ageConcentrationChart').getContext('2d');
    new Chart(ageConcentrationCtx, {
        type: 'line',
        data: {
            labels: ['0-18', '19-35', '36-50', '51-65', '66+'],
            datasets: [{
                label: 'Concentración',
                data: [
                    <?php foreach ($ageRanges as $count): ?>
                        <?php echo $count; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'rgba(153, 102, 255, 0.6)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Burbujas
    const bubbleCtx = document.getElementById('bubbleChart').getContext('2d');
    const bubbleData = [];
    <?php
    foreach ($patients as $index => $patient) {
        $dateOfBirth = new DateTime($patient['date_of_birth']);
        $today = new DateTime();
        $age = $today->diff($dateOfBirth)->y;
        $symptomCount = count(explode(', ', $patient['symptoms']));
        $radius = $patient['is_active'] ? 10 : 5;
        echo "bubbleData.push({x: $age, y: $symptomCount, r: $radius});\n";
    }
    ?>

    new Chart(bubbleCtx, {
        type: 'bubble',
        data: {
            datasets: [{
                label: 'Edad vs Síntomas',
                data: bubbleData,
                backgroundColor: 'rgba(255, 159, 64, 0.6)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Edad'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Número de Síntomas'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Gráfico de Gauge (Velocímetro simulado)
    const gaugeCtx = document.getElementById('gaugeChart').getContext('2d');
    const healthIndex = Math.round((<?php echo $activePatients; ?> / <?php echo $totalPatients; ?>) * 100);

    new Chart(gaugeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Índice de Salud', 'Restante'],
            datasets: [{
                data: [healthIndex, 100 - healthIndex],
                backgroundColor: [
                    healthIndex >= 80 ? '#28a745' : healthIndex >= 60 ? '#ffc107' : '#dc3545',
                    '#e9ecef'
                ],
                borderWidth: 0,
                circumference: 180,
                rotation: 270
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
            cutout: '75%'
        },
        plugins: [{
            afterDraw: function(chart) {
                const ctx = chart.ctx;
                const width = chart.width;
                const height = chart.height;

                ctx.save();
                ctx.font = 'bold 24px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillStyle = healthIndex >= 80 ? '#28a745' : healthIndex >= 60 ? '#ffc107' : '#dc3545';
                ctx.fillText(healthIndex + '%', width / 2, height / 2 + 20);

                ctx.font = '14px Arial';
                ctx.fillStyle = '#6c757d';
                ctx.fillText('Índice de Salud', width / 2, height / 2 + 45);
                ctx.restore();
            }
        }]
    });

    // Animaciones suaves al cargar
    window.addEventListener('load', function() {
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

<style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border-radius: 15px !important;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    .display-4 {
        font-weight: 300;
    }

    .badge {
        font-size: 0.8em;
        border-radius: 8px;
    }

    /* Estilos para los canvas */
    canvas {
        border-radius: 8px;
    }

    /* Gradientes personalizados para cards */
    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .gradient-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
    }

    .gradient-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    /* Animación de pulso para métricas importantes */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .card-body h2:hover {
        animation: pulse 0.5s ease-in-out;
    }

    /* Efectos de glassmorphism */
    .card-header {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Responsive design mejorado */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2rem;
        }

        .display-5 {
            font-size: 1.5rem;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-body {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }

        .card-body[style*="height"] {
            height: 250px !important;
        }
    }

    /* Estilos para tooltips personalizados */
    .custom-tooltip {
        background: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
    }

    /* Efectos de loading */
    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    /* Estilos para iconos */
    .fas,
    .far {
        transition: all 0.3s ease;
    }

    .card-title .fas:hover,
    .card-title .far:hover {
        transform: rotate(360deg);
        color: #007bff;
    }

    /* Scroll suave */
    html {
        scroll-behavior: smooth;
    }

    /* Sombras personalizadas */
    .shadow-custom {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1), 0 6px 6px rgba(0, 0, 0, 0.1);
    }

    /* Efectos de transición para tablas */
    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transform: translateX(5px);
    }
</style>

<?php include(APPPATH . 'Views/footer.php'); ?>