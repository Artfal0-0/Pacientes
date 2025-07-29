<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'email',
        'phone',
        'address',
        'symptoms',
        'is_active'
    ];
    protected $useTimestamps = false;

    public function validateCode($code, $id = null)
{
    if ($id !== null) {
        $currentPatient = $this->find($id);
        if ($currentPatient && $currentPatient['code'] === $code) {
            return true; // El código es el mismo que el del paciente actual, se permite
        }
    }
    $builder = $this->where('code', $code);
    if ($id !== null) {
        $builder->where('id !=', $id);
    }
    $existingPatient = $builder->first();
    return !$existingPatient; // Retorna true si no hay otro paciente con ese código
}
}