<?php include(APPPATH . 'Views/header.php'); ?>

<style>
    .patient-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: none;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .patient-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 20px;
        border-radius: 20px 20px 0 0;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .card-header-custom::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .card-header-custom h4 {
        margin: 0;
        font-weight: 600;
        font-size: 1.4rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-custom .icon {
        width: 30px;
        height: 30px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .card-body-custom {
        padding: 25px;
    }

    .patient-table {
        margin: 0;
        border: none;
    }

    .patient-table tbody tr {
        border: none;
        transition: all 0.3s ease;
    }

    .patient-table tbody tr:hover {
        background: linear-gradient(90deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
        transform: translateX(5px);
    }

    .patient-table th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #495057;
        font-weight: 600;
        padding: 15px 20px;
        border: none;
        border-radius: 10px 0 0 10px;
        width: 35%;
        position: relative;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .patient-table td {
        padding: 15px 20px;
        border: none;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 0 10px 10px 0;
        font-weight: 500;
        color: #333;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .patient-table tbody tr td:first-child {
        border-left: 4px solid #4facfe;
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
    }

    .status-active {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(86, 171, 47, 0.3);
    }

    .status-inactive {
        background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
    }

    .symptoms-container {
        background: rgba(79, 172, 254, 0.1);
        border-radius: 12px;
        padding: 15px;
        border-left: 4px solid #4facfe;
        line-height: 1.6;
        word-break: break-word;
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .symptom-item {
        background: rgba(0, 242, 254, 0.2);
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    @keyframes borderGlow {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .diagnosis-content {
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        padding: 20px;
        border-radius: 15px;
        font-size: 1.1rem;
        line-height: 1.7;
        box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .floating-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    .floating-circle {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        animation: float 6s ease-in-out infinite;
    }

    .floating-circle:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 10%;
        left: 10%;
        animation-delay: -2s;
    }

    .floating-circle:nth-child(2) {
        width: 60px;
        height: 60px;
        top: 70%;
        left: 80%;
        animation-delay: -4s;
    }

    .floating-circle:nth-child(3) {
        width: 100px;
        height: 100px;
        top: 40%;
        left: 90%;
        animation-delay: -1s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }

    .gender-icon {
        margin-left: 10px;
        font-size: 1.2em;
    }

    .patient-code {
        font-family: 'Courier New', monospace;
        background: rgba(79, 172, 254, 0.1);
        padding: 5px 10px;
        border-radius: 8px;
        font-weight: bold;
        color: #4facfe;
    }

    @media (max-width: 768px) {
        .patient-container {
            padding: 10px;
        }

        .card-body-custom {
            padding: 15px;
        }

        .patient-table th,
        .patient-table td {
            padding: 10px 15px;
            font-size: 0.9rem;
        }

        .diagnosis-card {
            margin-top: 20px;
            padding: 20px;
        }
    }

    .emergency-alert {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.7;
        }

        100% {
            opacity: 1;
        }
    }

    .diagnosis-card {
        border-radius: 10px;
        overflow: hidden;
    }

    .diagnosis-result {
        font-size: 1.1rem;
    }

    .emergency-alert {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 1;
        }

        50% {
            opacity: 0.8;
        }

        100% {
            opacity: 1;
        }
    }

    .symptoms-evaluated ul {
        margin-top: 10px;
        padding-left: 20px;
    }

    .symptoms-evaluated li {
        padding: 3px 0;
        display: flex;
        align-items: center;
    }

    /* Estilos para los botones de acción */
    .action-buttons {
        margin-top: 20px;
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-custom {
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        color: white;
    }

    .btn-chat {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }

    .btn-chat:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(17, 153, 142, 0.6);
        color: white;
    }

    .btn-custom::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transition: all 0.3s ease;
        transform: translate(-50%, -50%);
    }

    .btn-custom:hover::before {
        width: 300px;
        height: 300px;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-custom {
            width: 100%;
            max-width: 250px;
        }
    }
</style>

<div class="patient-container">
    <div class="floating-elements">
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Columna izquierda: Datos del paciente -->
            <div class="col-md-7">
                <div class="card patient-card">
                    <div class="card-header-custom">
                        <h4>
                            Datos del Paciente
                        </h4>
                    </div>
                    <div class="card-body-custom">
                        <table class="table patient-table">
                            <tbody>
                                <tr>
                                    <th>Código</th>
                                    <td>
                                        <span class="patient-code"><?php echo $patient['code']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nombre</th>
                                    <td>
                                        <strong><?php echo $patient['first_name'] . ' ' . $patient['last_name']; ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Fecha de Nacimiento</th>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($patient['date_of_birth'])); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Género</th>
                                    <td>
                                        <?php
                                        $genderText = $patient['gender'] === 'M' ? 'Masculino' : ($patient['gender'] === 'F' ? 'Femenino' : 'Otro');
                                        $genderIcon = $patient['gender'] === 'M' ? '♂️' : ($patient['gender'] === 'F' ? '♀️' : '⚧️');
                                        echo $genderText . ' <span class="gender-icon">' . $genderIcon . '</span>';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dirección</th>
                                    <td>
                                        <?php echo $patient['address'] ?: 'No especificada'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Correo Electrónico</th>
                                    <td>
                                        <?php echo $patient['email'] ?: 'No especificado'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Teléfono</th>
                                    <td>
                                        <?php echo $patient['phone'] ?: 'No especificado'; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Síntomas</th>
                                    <td>
                                        <div class="symptoms-container">
                                            <?php
                                            $symptoms = explode(',', $patient['symptoms']); // Separar solo por comas
                                            $symptoms = array_map('trim', $symptoms); // Limpiar espacios
                                            $symptoms = array_filter($symptoms); // Eliminar elementos vacíos
                                            $symptomLabels = [
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
                                                'dolor_ojos' => 'Dolor alrededor de los ojos'
                                            ];
                                            echo '<span style="display: block;">🩺</span>';
                                            foreach ($symptoms as $symptom) {
                                                echo '<span class="symptom-item">' . ($symptomLabels[$symptom] ?? $symptom) . '</span>';
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado</th>
                                    <td>
                                        <span class="status-badge <?php echo $patient['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                            <?php echo $patient['is_active'] ? 'Activo' : 'Inactivo'; ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Botones de acción -->
                <div class="action-buttons">
                    <a href="<?php echo base_url('patients'); ?>" class="btn btn-custom btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Regresar
                    </a>
                    <a href="<?php echo base_url('ia'); ?>" class="btn btn-custom btn-chat">
                        <i class="fas fa-robot"></i>
                        Chat con IA
                    </a>
                </div>
            </div>

            <!-- Columna derecha: Posible diagnóstico y Recomendaciones -->
            <div class="col-md-5">
                <div class="card patient-card">
                    <div class="card-header-custom">
                        <h4>
                            <i class="fas fa-diagnosis me-2"></i> Posible Diagnóstico
                        </h4>
                    </div>
                    <div class="card-body-custom">
                        <div class="diagnosis-card">
                            <?php
                            // Procesar síntomas correctamente
                            $symptoms = array_map('trim', explode(',', $patient['symptoms']));
                            $symptoms = array_filter($symptoms);

                            // Mapeo de etiquetas para síntomas
                            $symptomLabels = [
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
                                'debilidad_muscular' => 'Debilidad muscular',
                                'hormigueo' => 'Hormigueo',
                                'confusion' => 'Confusión mental',
                                'dificultad_habla' => 'Dificultad para hablar',
                                'perdida_equilibrio' => 'Pérdida de equilibrio',
                                'convulsiones' => 'Convulsiones',
                                'presion_cabeza' => 'Presión en la cabeza',
                                'zumbidos_oidos' => 'Zumbidos en los oídos',
                                'rigidez_cuello' => 'Rigidez en el cuello',
                                'fatiga_mental' => 'Fatiga mental',
                                'perdida_memoria' => 'Pérdida de memoria',
                                'dolor_ojos' => 'Dolor alrededor de los ojos',
                                'dolor_intenso_unilateral' => 'Dolor intenso unilateral',
                                'lagrimeo_ojo' => 'Lagrimeo en el ojo',
                                'nariz_taponada' => 'Nariz taponada',
                                'dolor_persistente' => 'Dolor persistente',
                                'fiebre_alta' => 'Fiebre alta',
                                'letargo' => 'Letargo',
                                'dolor_cabeza_severa' => 'Dolor de cabeza severo',
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

                            // Determinar clase de alerta según diagnóstico
                            $alertClass = 'info';
                            if (strpos($diagnosis, 'Emergencia') !== false) {
                                $alertClass = 'danger';
                            } elseif (strpos($diagnosis, 'Prioritario') !== false) {
                                $alertClass = 'warning';
                            }
                            ?>

                            <div class="alert alert-<?= $alertClass ?>">
                                <h5 class="d-flex align-items-center">
                                    <i class="fas fa-stethoscope me-2"></i> Diagnóstico Preliminar
                                </h5>
                                <hr>
                                <div class="diagnosis-result">
                                    <p class="mb-1"><strong><?= $diagnosis ?></strong></p>

                                    <?php if ($alertClass == 'danger'): ?>
                                        <div class="emergency-alert mt-2 p-2 bg-danger text-white rounded">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>ATENCIÓN:</strong> Esta condición requiere atención médica inmediata.
                                        </div>
                                    <?php elseif ($alertClass == 'warning'): ?>
                                        <div class="priority-alert mt-2 p-2 bg-warning text-dark rounded">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            <strong>Importante:</strong> Consulte con un especialista lo antes posible.
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="mt-3 symptoms-evaluated">
                                    <small class="text-muted">Síntomas evaluados:</small>
                                    <ul class="list-unstyled">
                                        <?php foreach ($symptoms as $symptom): ?>
                                            <li>
                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                <?= $symptomLabels[$symptom] ?? str_replace('_', ' ', $symptom) ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="card patient-card">
                        <div class="card-header-custom" style="background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);">
                            <h4>
                                Recomendaciones Generales
                            </h4>
                        </div>
                        <div class="card-body-custom">
                            <div class="diagnosis-content">
                                <p>Basado en tu caso, considera lo siguiente:</p>
                                <ul class="list-unstyled">
                                    <li>🩺 Consulta a un especialista si los síntomas persisten o empeoran.</li>
                                    <?php
                                    // Lista de recomendaciones aumentada con 5 más
                                    $recommendations = [
                                        '🌞 Evita luces brillantes o ruidos fuertes y considera tomar analgésicos bajo supervisión médica.',
                                        '💆 Relaja los músculos del cuello y los hombros con estiramientos suaves.',
                                        '⏰ Evita el consumo de alcohol y mantén un horario de sueño regular.',
                                        '💨 Usa un humidificador o inhala vapor para aliviar la congestión nasal.',
                                        '🍲 Consume alimentos ligeros y evita comidas pesadas.',
                                        '🌿 Considera técnicas de relajación como meditación o respiración profunda.',
                                        '🏃 Realiza ejercicio ligero para mejorar la circulación y reducir el estrés.',
                                        '☀️ Expónte a la luz solar moderada para regular tus niveles de vitamina D.',
                                        '💧 Aplica compresas frías o calientes según el tipo de dolor.',
                                        '📱 Limita el uso de dispositivos electrónicos para reducir la fatiga visual.'
                                    ];
                                    // Seleccionar una recomendación aleatoria
                                    $randomRecommendation = $recommendations[array_rand($recommendations)];
                                    echo '<li>' . $randomRecommendation . '</li>';
                                    ?>
                                </ul>
                                <p class="text-muted mt-2">Nota: Estas son recomendaciones generales. Busca atención médica profesional para un diagnóstico preciso.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/footer.php'); ?>