<?php

namespace App\Modules\Tik\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnexoTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'frmAnexoTicket_fileArchivo' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
                'max:5120',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'frmAnexoTicket_fileArchivo.required' => 'Debes seleccionar un archivo.',
            'frmAnexoTicket_fileArchivo.file' => 'El archivo enviado no es válido.',
            'frmAnexoTicket_fileArchivo.mimes' => 'El archivo debe ser tipo pdf, jpg, jpeg, png, doc, docx, xls o xlsx.',
            'frmAnexoTicket_fileArchivo.max' => 'El archivo no debe superar los 5 MB.',
        ];
    }
}