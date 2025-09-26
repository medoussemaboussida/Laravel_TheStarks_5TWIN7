<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatimentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autoriser pour tous
    }

    public function rules(): array
    {
        return [
            'type_batiment'          => 'required|in:Maison,Usine',
            'adresse'                => 'required|string|max:255',
            'emissionCO2'            => 'required|numeric|min:0',
            'pourcentageRenouvelable'=> 'required|numeric|min:0|max:100',

            // Optionnels selon le type
            'nbHabitants'    => 'nullable|integer|min:0',
            'nbEmployes'     => 'nullable|integer|min:0',
            'typeIndustrie'  => 'nullable|string|max:100',
        ];
    }
}
