<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code', 'first_name', 'last_name', 'date_of_birth', 'gender',
        'email', 'phone', 'address', 'symptoms', 'is_active'
    ];
    protected $useTimestamps = false;

    public function validateCode($code)
    {
        return $this->where('code', $code)->first() ? false : true;
    }
}