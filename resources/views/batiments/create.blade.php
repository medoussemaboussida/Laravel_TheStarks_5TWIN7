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
        <!-- Zone Urbaine -->
        <div class="mb-3">
            <label for="zone_id" class="form-label">État (Zone Urbaine)</label>
            <select id="zone_id" name="zone_id" class="form-control" required>
                <option value="">-- Choisir une zone --</option>
                @foreach($zones as $z)
                    <option value="{{ $z->getId() }}">{{ $z->getNom() }}</option>
                @endforeach
            </select>
        </div>


        <!-- Adresse (Maison & Usine) -->
        <div class="mb-3 common-field">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" id="adresse" name="adresse" class="form-control">
        </div>

        <!-- Estimation des émissions -->
        <h4>Estimation des émissions CO₂</h4>
        <p>Sélectionnez les objets/activités et entrez leur nombre :</p>

        <div class="row">
            <!-- Exemple : voiture -->
            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[voiture][check]" value="1" class="form-check-input">
                    🚗 Voitures
                </label>
                <input type="number" name="emissions[voiture][nb]" class="form-control mt-1" placeholder="Nombre">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[moto][check]" value="1" class="form-check-input">
                    🛵 Motos
                </label>
                <input type="number" name="emissions[moto][nb]" class="form-control mt-1" placeholder="Nombre">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[bus][check]" value="1" class="form-check-input">
                    🚍 Bus internes
                </label>
                <input type="number" name="emissions[bus][nb]" class="form-control mt-1" placeholder="Nombre">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[avion][check]" value="1" class="form-check-input">
                    ✈️ Déplacements aériens
                </label>
                <input type="number" name="emissions[avion][nb]" class="form-control mt-1" placeholder="Personnes">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[fumeur][check]" value="1" class="form-check-input">
                    🚬 Fumeurs
                </label>
                <input type="number" name="emissions[fumeur][nb]" class="form-control mt-1" placeholder="Nombre">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[electricite][check]" value="1" class="form-check-input">
                    💡 Consommation électrique
                </label>
                <input type="number" name="emissions[electricite][nb]" class="form-control mt-1" placeholder="Ménages">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[gaz][check]" value="1" class="form-check-input">
                    🔥 Chauffage au gaz
                </label>
                <input type="number" name="emissions[gaz][nb]" class="form-control mt-1" placeholder="Unités">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[clim][check]" value="1" class="form-check-input">
                    ❄️ Climatisations
                </label>
                <input type="number" name="emissions[clim][nb]" class="form-control mt-1" placeholder="Unités">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[machine][check]" value="1" class="form-check-input">
                    🏭 Machines industrielles
                </label>
                <input type="number" name="emissions[machine][nb]" class="form-control mt-1" placeholder="Nombre">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-check-label">
                    <input type="checkbox" name="emissions[camion][check]" value="1" class="form-check-input">
                    📦 Camions utilitaires
                </label>
                <input type="number" name="emissions[camion][nb]" class="form-control mt-1" placeholder="Nombre">
            </div>
        </div>

       <!-- Énergies Renouvelables utilisées -->
        <div class="mb-3">
            <label class="form-label">Énergies Renouvelables utilisées</label>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="energie_solaire" name="solaire_active" value="1">
                <label class="form-check-label" for="energie_solaire">☀️ Panneaux solaires</label>
                <input type="number" class="form-control mt-1" name="solaire_kw" placeholder="kW produits/an">
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="energie_voiture" name="voiture_active" value="1">
                <label class="form-check-label" for="energie_voiture">🚗 Voitures électriques</label>
                <input type="number" class="form-control mt-1" name="voiture_nb" placeholder="Nombre de voitures">
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="energie_biomasse" name="biomasse_active" value="1">
                <label class="form-check-label" for="energie_biomasse">🌱 Biomasse</label>
                <input type="number" class="form-control mt-1" name="biomasse_tonnes" placeholder="Tonnes utilisées/an">
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="energie_eolien" name="eolien_active" value="1">
                <label class="form-check-label" for="energie_eolien">🌬️ Éolien</label>
                <input type="number" class="form-control mt-1" name="eolien_kw" placeholder="kW produits/an">
            </div>
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
