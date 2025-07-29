<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class IAController extends Controller
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('ia/index');
    }

    public function getResponse()
    {
        // api
        $apiKey = 'AIzaSyDvMAqtJGqCvikqZ1S_q0bpsVCwzIxCnc0'; 
        
        $prompt = $this->request->getPost('prompt');

        if (!$prompt) {
            return $this->response->setJSON(['error' => 'No se proporcionó un mensaje.']);
        }

        $model = 'gemini-1.5-flash'; 
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . $apiKey;

        $data = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'maxOutputTokens' => 150,
                'temperature' => 0.7,
            ],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        curl_close($ch);

        if ($response === false) {
            return $this->response->setJSON(['error' => 'Error al conectar con la API: ' . curl_error($ch)]);
        }

        $result = json_decode($response, true);

        if ($httpCode !== 200) {
            return $this->response->setJSON([
                'error' => $result['error']['message'] ?? 'Error desconocido de la API.', 
                'code' => $httpCode
            ]);
        }

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            return $this->response->setJSON(['response' => $result['candidates'][0]['content']['parts'][0]['text']]);
        } else {
            return $this->response->setJSON(['response' => 'No se pudo generar una respuesta de texto. Esto puede deberse a filtros de seguridad o a que no se pudo producir una respuesta adecuada.']);
        }
    }
}