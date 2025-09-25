<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BatimentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autoriser tout le monde pour l’instant
    }

    public function rules(): array
    {
        return [
            'type_batiment' => 'required|string|in:Usine,Maison',
            'nom_adresse' => 'required|string|max:150',
            'emissionCO2' => 'required|numeric|min:0',
            'nbHabitants' => 'nullable|integer|min:0',
            'typeIndustrie' => 'nullable|string|max:50',
            'pourcentageRenouvelable' => 'required|numeric|between:0,100',
        ];
    }
}
