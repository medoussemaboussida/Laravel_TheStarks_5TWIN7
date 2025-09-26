@extends('layouts.app')

@section('title','Modifier un Bâtiment')

@section('content')
<div class="container">
    <h2>Modifier le Bâtiment</h2>

    <form action="{{ route('batiments.update', $batiment->getId()) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Type de bâtiment -->
        <div class="mb-3">
            <label for="type_batiment" class="form-label">Type de bâtiment</label>
            <select id="type_batiment" name="type_batiment" class="form-control" required>
                <option value="">-- Choisir --</option>
                <option value="Maison" {{ $batiment->getTypeBatiment() === 'Maison' ? 'selected' : '' }}>Maison</option>
                <option value="Usine" {{ $batiment->getTypeBatiment() === 'Usine' ? 'selected' : '' }}>Usine</option>
            </select>
        </div>

        <!-- Zone Urbaine -->
        <div class="mb-3">
            <label for="zone_id" class="form-label">État (Zone Urbaine)</label>
            <select id="zone_id" name="zone_id" class="form-control" required>
                <option value="">-- Choisir une zone --</option>
                @foreach($zones as $z)
                    <option value="{{ $z->getId() }}" {{ $batiment->getZone() && $batiment->getZone()->getId() == $z->getId() ? 'selected' : '' }}>
                        {{ $z->getNom() }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Adresse -->
        <div class="mb-3 common-field">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" id="adresse" name="adresse" class="form-control"
                   value="{{ $batiment->getAdresse() }}">
        </div>

        <!-- Maison spécifique -->
        <div class="mb-3 maison-field {{ $batiment->getTypeBatiment() === 'Maison' ? '' : 'd-none' }}">
            <label for="nbHabitants" class="form-label">Nombre d'habitants</label>
            <input type="number" id="nbHabitants" name="nbHabitants" class="form-control"
                   value="{{ $batiment->getNbHabitants() }}">
        </div>

        <!-- Usine spécifique -->
        <div class="mb-3 usine-field {{ $batiment->getTypeBatiment() === 'Usine' ? '' : 'd-none' }}">
            <label for="nbEmployes" class="form-label">Nombre d'employés</label>
            <input type="number" id="nbEmployes" name="nbEmployes" class="form-control"
                   value="{{ $batiment->getNbEmployes() }}">
        </div>

        <div class="mb-3 usine-field {{ $batiment->getTypeBatiment() === 'Usine' ? '' : 'd-none' }}">
            <label for="typeIndustrie" class="form-label">Type d'industrie</label>
            <input type="text" id="typeIndustrie" name="typeIndustrie" class="form-control"
                   value="{{ $batiment->getTypeIndustrie() }}">
        </div>

        <!-- Énergies Renouvelables -->
        <h4>Énergies Renouvelables utilisées</h4>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" id="energie_solaire" name="solaire_active" value="1">
            <label class="form-check-label" for="energie_solaire">☀️ Panneaux solaires</label>
            <input type="number" class="form-control mt-1" name="solaire_kw" placeholder="kW produits/an">
        </div>

        <!-- Tu peux continuer à adapter les cases comme dans create... -->

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>

<script>
document.getElementById('type_batiment').addEventListener('change', function() {
    const maisonFields = document.querySelectorAll('.maison-field');
    const usineFields = document.querySelectorAll('.usine-field');
    const commonFields = document.querySelectorAll('.common-field');

    maisonFields.forEach(el => el.classList.add('d-none'));
    usineFields.forEach(el => el.classList.add('d-none'));
    commonFields.forEach(el => el.classList.add('d-none'));

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
