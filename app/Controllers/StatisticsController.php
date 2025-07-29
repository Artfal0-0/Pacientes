<?php

namespace App\Controllers;

use App\Models\PatientModel;

class StatisticsController extends BaseController
{
    protected $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    public function statistics()
    {
        // Obtener todos los pacientes
        $patients = $this->patientModel->findAll();

        // Calcular estadísticas
        $totalPatients = count($patients);
        $activePatients = count(array_filter($patients, fn($p) => $p['is_active']));
        $inactivePatients = $totalPatients - $activePatients;

        // Contar géneros
        $genderCount = [
            'M' => 0,
            'F' => 0,
            'O' => 0
        ];
        foreach ($patients as $patient) {
            $genderCount[$patient['gender']] = ($genderCount[$patient['gender']] ?? 0) + 1;
        }

        // Contar síntomas (desglose simple)
        $symptomCount = [];
        foreach ($patients as $patient) {
            $symptoms = explode(', ', $patient['symptoms']);
            foreach ($symptoms as $symptom) {
                $symptom = trim(strtolower($symptom));
                $symptomCount[$symptom] = ($symptomCount[$symptom] ?? 0) + 1;
            }
        }
        arsort($symptomCount); // Ordenar por cantidad descendente

        // Pasar datos a la vista
        $data = [
            'totalPatients' => $totalPatients,
            'activePatients' => $activePatients,
            'inactivePatients' => $inactivePatients,
            'genderCount' => $genderCount,
            'symptomCount' => array_slice($symptomCount, 0, 5), // Top 5 síntomas más comunes
            'patients' => $patients // Agregar pacientes al array de datos
        ];

        return view('statistics/index', $data);
    }
}