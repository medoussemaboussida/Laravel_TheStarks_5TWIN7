@extends('layouts.app')

@section('title','Créer un Bâtiment')

@section('content')
<div class="container">
    <h2>Créer un Bâtiment</h2>

    <form action="{{ route('batiments.store') }}" method="POST">
        @csrf

        <!-- Type de bâtiment -->
        <div class="mb-3">
            <label for="type_batiment" class="form-label">Type de bâtiment</label>
            <select id="type_batiment" name="type_batiment" class="form-control" required>
                <option value="">-- Choisir --</option>
                <option value="Maison">Maison</option>
                <option value="Usine">Usine</option>
            </select>
        </div>

        <!-- Adresse (Maison & Usine) -->
        <div class="mb-3 common-field">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" id="adresse" name="adresse" class="form-control">
        </div>

        <!-- Emission CO2 (Maison & Usine) -->
        <div class="mb-3 common-field">
            <label for="emissionCO2" class="form-label">Émission CO₂ (t/an)</label>
            <input type="number" id="emissionCO2" name="emissionCO2" class="form-control" step="0.01">
        </div>

        <!-- Pourcentage Renouvelable (Maison & Usine) -->
        <div class="mb-3 common-field">
            <label for="pourcentageRenouvelable" class="form-label">% Énergie Renouvelable</label>
            <input type="number" id="pourcentageRenouvelable" name="pourcentageRenouvelable" class="form-control" step="1" min="0" max="100">
        </div>

        <!-- Maison spécifique -->
        <div class="mb-3 maison-field d-none">
            <label for="nbHabitants" class="form-label">Nombre d'habitants</label>
            <input type="number" id="nbHabitants" name="nbHabitants" class="form-control">
        </div>

        <!-- Usine spécifique -->
        <div class="mb-3 usine-field d-none">
            <label for="nbEmployes" class="form-label">Nombre d'employés</label>
            <input type="number" id="nbEmployes" name="nbEmployes" class="form-control">
        </div>

        <div class="mb-3 usine-field d-none">
            <label for="typeIndustrie" class="form-label">Type d'industrie</label>
            <input type="text" id="typeIndustrie" name="typeIndustrie" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>

<script>
document.getElementById('type_batiment').addEventListener('change', function() {
    const maisonFields = document.querySelectorAll('.maison-field');
    const usineFields = document.querySelectorAll('.usine-field');
    const commonFields = document.querySelectorAll('.common-field');

    // masquer tous les champs
    maisonFields.forEach(el => el.classList.add('d-none'));
    usineFields.forEach(el => el.classList.add('d-none'));
    commonFields.forEach(el => el.classList.add('d-none'));

    // afficher les champs selon le type
    if (this.value === 'Maison') {
        commonFields.forEach(el => el.classList.remove('d-none'));
        maisonFields.forEach(el => el.classList.remove('d-none'));
    } else if (this.value === 'Usine') {
        commonFields.forEach(el => el.classList.remove('d-none'));
        usineFields.forEach(el => el.classList.remove('d-none'));
    }
});
</script>
@endsection
