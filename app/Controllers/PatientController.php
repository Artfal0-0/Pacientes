<?php

namespace App\Controllers;

use App\Models\PatientModel;

class PatientController extends BaseController
{
    protected $patientModel;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
    }

    public function index()
    {
        $data['patients'] = $this->patientModel->findAll();
        return view('patients/index', $data);
    }

    public function create()
    {
        return view('patients/create');
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['is_active'] = $this->request->getPost('is_active') ? 1 : 0;

        if ($this->patientModel->validateCode($data['code'])) {
            if ($this->patientModel->save($data)) {
                $patientId = $this->patientModel->insertID();
                return redirect()->to(base_url('patients/chatbot/' . $patientId))
                    ->with('success', 'Paciente registrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al guardar el paciente.');
            }
        } else {
            return redirect()->back()->with('error', 'El código ya está registrado.');
        }
    }

    public function validateCode($code)
    {
        $isValid = $this->patientModel->validateCode($code);
        return $this->response->setJSON(['data' => $isValid ? [] : ['exists' => true]]);
    }

    public function delete($id)
    {
        if ($this->patientModel->delete($id)) {
            return redirect()->to(base_url('patients'))->with('success', 'Paciente eliminado correctamente.');
        } else {
            return redirect()->to(base_url('patients'))->with('error', 'Error al eliminar el paciente.');
        }
    }

    public function chatbot($id)
    {
        $patient = $this->patientModel->find($id);
        if (!$patient) {
            return redirect()->to(base_url('patients'))->with('error', 'Paciente no encontrado.');
        }
        $data['patient'] = $patient;
        return view('patients/chatbot', $data);
    }

}