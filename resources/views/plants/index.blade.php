@extends('admin_dashboard.layout')

@section('title', 'Liste des Plantes')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Liste des Plantes</h1>
<p class="mb-4">Voici la liste des plantes enregistrées. Vous pouvez ajouter, modifier ou supprimer des plantes.</p>

<!-- Bouton Ajouter une plante -->
<button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addPlantModal">
    Ajouter une plante
</button>

@if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Plantes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="plantsTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Âge</th>
                        <th>Localisation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($plants as $plant)
                    <tr>
                        <td>{{ $plant->name }}</td>
                        <td>{{ $plant->type->name }}</td>
                        <td>{{ $plant->age ?? 'N/A' }}</td>
                        <td>{{ $plant->location ?? 'Non spécifiée' }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editPlantModal{{ $plant->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                            </button>


                            <form action="{{ route('plants.destroy', $plant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette plante ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">
                            <i class="fas fa-trash"></i>
                            </button>
                            </form>

                        </td>
                    </tr>

                    <!-- Modal Modifier -->
                    <div class="modal fade" id="editPlantModal{{ $plant->id }}" tabindex="-1" role="dialog" aria-labelledby="editPlantModalLabel{{ $plant->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('plants.update', $plant->id) }}" method="POST" class="validate-form needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Modifier la Plante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $plant->name) }}" required pattern="^[A-Za-zÀ-ÿ\s]+$" title="Le nom ne doit contenir que des lettres et des espaces" maxlength="255">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger name-error"></small>
            <div class="invalid-feedback name-feedback"></div>
        </div>

        <div class="form-group">
            <label for="plant_type_id">Type</label>
            <select name="plant_type_id" class="form-control type-field @error('plant_type_id') is-invalid @enderror" required>
                <option value="">Sélectionner un type</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ old('plant_type_id', $plant->plant_type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach
            </select>
            @error('plant_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger type-error"></small>
        </div>

        <div class="form-group">
            <label for="age">Âge</label>
            <input type="number" name="age" class="form-control age-field @error('age') is-invalid @enderror" value="{{ old('age', $plant->age) }}" required min="0" max="200" step="1" title="L’âge doit être un nombre entre 0 et 200">
            @error('age')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger age-error"></small>
        </div>

        <div class="form-group">
            <label for="location">Localisation</label>
            <input type="text" name="location" class="form-control location-field @error('location') is-invalid @enderror" value="{{ old('location', $plant->location) }}" required maxlength="255" pattern="^[A-Za-zÀ-ÿ0-9\s\-']+$" title="La localisation doit contenir des lettres et/ou des chiffres">
            @error('location')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger location-error"></small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
 <div class="text-center">
    <div class="text-center mt-3">
    {{ $plants->onEachSide(0)->links('pagination::simple-bootstrap-4') }}
</div>
</div>


<!-- Modal Ajouter une Plante -->
<div class="modal fade" id="addPlantModal" tabindex="-1" role="dialog" aria-labelledby="addPlantModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('plants.store') }}" method="POST" class="validate-form needs-validation" novalidate>
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Ajouter une Plante</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erreur de saisie :</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required pattern="^[A-Za-zÀ-ÿ\s]+$" title="Le nom ne doit contenir que des lettres et des espaces" maxlength="255">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger name-error"></small>
                <div class="invalid-feedback name-feedback"></div>
            </div>

            <div class="form-group">
                <label for="plant_type_id">Type</label>
                <select name="plant_type_id" class="form-control @error('plant_type_id') is-invalid @enderror" required>
                    <option value="">Sélectionner un type</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('plant_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
                @error('plant_type_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger type-error"></small>
            </div>

            <div class="form-group">
                <label for="age">Âge</label>
                <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" required min="0" max="200" step="1" title="L’âge doit être un nombre entre 0 et 200">
                @error('age')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger age-error"></small>
            </div>

            <div class="form-group">
                <label for="location">Localisation</label>
                <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" required maxlength="255" pattern="^[A-Za-zÀ-ÿ0-9\s\-']+$" title="La localisation doit contenir des lettres et/ou des chiffres">
                @error('location')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-danger location-error"></small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-secondary" disabled>Ajouter</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if ($errors->has('name') || $errors->has('plant_type_id') || $errors->has('age') || $errors->has('location'))
<script>
    $(document).ready(function() {
        $('#addPlantModal').modal('show');
    });
</script>
@endif

<script>
$(document).ready(function() {
    $('#plantsTable').DataTable({
        pagingType: "simple_numbers",
        pageLength: 5,
        lengthChange: false,
        language: {
            paginate: {
                previous: "<",
                next: ">"
            }
        },
        dom: '<"top"f>rt<"bottom"ip><"clear">'
    });

    // Validation + activation boutons dans les modals Ajouter/Modifier
    function wireValidation($form){
        const $submit = $form.find('button[type="submit"]');
        function updateFieldState($field){
            const el = $field[0];
            // Show invalid state either after first validation or when there's a value
            const shouldShow = $form.hasClass('was-validated') || ($field.val() !== '' && $field.val() !== null);
            if (shouldShow){
                if (el.checkValidity()){
                    $field.removeClass('is-invalid').addClass('is-valid');
                } else {
                    $field.removeClass('is-valid').addClass('is-invalid');
                }
            }
            // Custom inline message for Name field (works in both Add and Edit modals)
            const nameAttr = $field.attr('name');
            if (nameAttr === 'name'){
                const $small = $field.parent().find('small.name-error');
                if ($small.length){
                    const val = $field.val() || '';
                    if (!val){
                        $small.text('Ce champ est obligatoire');
                    } else if (/\d/.test(val)){
                        $small.text('Ce champ ne doit pas contenir des chiffres');
                    } else if (!el.checkValidity()){
                        $small.text($field.attr('title') || 'Valeur invalide');
                    } else {
                        $small.text('');
                    }
                }
            }
        }
        function toggle(){
            // update each field state
            $form.find('input,select').each(function(){ updateFieldState($(this)); });
            // toggle submit enablement
            if ($form[0].checkValidity()){
                $submit.prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
            } else {
                $submit.prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
            }
        }
        $form.on('submit', function(e){
            if(!$form[0].checkValidity()){
                e.preventDefault();
                e.stopPropagation();
            }
            $form.addClass('was-validated');
            toggle();
        });
        $form.find('input,select').on('input change keyup blur', toggle);
        toggle();
    }

    // Bind all existing forms once
    $('.validate-form').each(function(){ wireValidation($(this)); });

    // Re-bind when a modal is opened (to be safe with dynamic content/pagination)
    $(document).on('shown.bs.modal', '#addPlantModal, [id^="editPlantModal"]', function(){
        const $form = $(this).find('.validate-form');
        if ($form.length) {
            wireValidation($form);
            if (this.id === 'addPlantModal') {
                // For ADD modal: show required hints immediately
                $form.find('input,select').each(function(){ $(this).addClass('is-invalid'); });
                $form.find('small.name-error').text('Ce champ est obligatoire');
                $form.find('small.type-error').text('Ce champ est obligatoire');
                $form.find('small.age-error').text('Ce champ est obligatoire');
                $form.find('small.location-error').text('Ce champ est obligatoire');
            } else {
                // For EDIT modal: compute validity from current values
                $form.find('input,select').trigger('input');
                // If all valid, enable submit button immediately
                if ($form[0].checkValidity()) {
                    const $submit = $form.find('button[type="submit"]');
                    $submit.prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
                }
            }
        }
    });

    // Reset on modal hide
    $(document).on('hidden.bs.modal', '#addPlantModal, [id^="editPlantModal"]', function(){
        const $form = $(this).find('.validate-form');
        if ($form.length) {
            $form.removeClass('was-validated')[0].reset();
            const $submit = $form.find('button[type="submit"]');
            $submit.prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
            $form.find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
        }
    });

    // Explicit live message for Name in EDIT modals (robust against any wiring issue)
    $(document).on('input change keyup blur', '[id^="editPlantModal"] input[name="name"]', function(){
        const $field = $(this);
        const val = $field.val() || '';
        const $container = $field.parent();
        const $msg = $container.find('small.name-error');
        const $form = $field.closest('form');
        const $submit = $form.find('button[type="submit"]');

        if (!val){
            $msg.text('Ce champ est obligatoire');
            $field.addClass('is-invalid').removeClass('is-valid');
        } else if (/\d/.test(val)){
            $msg.text('Ce champ ne doit pas contenir des chiffres');
            $field.addClass('is-invalid').removeClass('is-valid');
        } else if (!$field[0].checkValidity()){
            const m = $field.attr('title') || 'Valeur invalide';
            $msg.text(m);
            $field.addClass('is-invalid').removeClass('is-valid');
        } else {
            $msg.text('');
            $field.removeClass('is-invalid').addClass('is-valid');
        }

        // Recompute overall form validity to toggle submit button
        if ($form[0].checkValidity()){
            $submit.prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
        } else {
            $submit.prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
        }
    });
});
</script>
<script>
// Vanilla JS fallback: ensure validation/enabling works even without jQuery/Bootstrap
document.addEventListener('DOMContentLoaded', function() {
  function wireForm(form) {
    if (!form || form.__wired) return; // prevent double wiring
    form.__wired = true;
    const submitBtn = form.querySelector('button[type="submit"]');
    const fields = Array.from(form.querySelectorAll('input, select'));

    function setCustomMessage(field) {
      var name = field.name;
      if (name === 'name') {
        var h = field.parentElement.querySelector('small.name-error');
        if (!h) return;
        if (!field.value) h.textContent = 'Ce champ est obligatoire';
        else if (/\d/.test(field.value)) h.textContent = 'Ce champ ne doit pas contenir des chiffres';
        else if (!field.checkValidity()) h.textContent = field.title || 'Valeur invalide';
        else h.textContent = '';
        return;
      }
      if (name === 'plant_type_id') {
        var ht = field.parentElement.querySelector('small.type-error');
        if (!ht) return;
        if (!field.value) ht.textContent = 'Ce champ est obligatoire';
        else ht.textContent = '';
        return;
      }
      if (name === 'age') {
        var ha = field.parentElement.querySelector('small.age-error');
        if (!ha) return;
        if (!field.value) ha.textContent = 'Ce champ est obligatoire';
        else if (!field.checkValidity()) ha.textContent = field.title || 'Valeur invalide';
        else ha.textContent = '';
        return;
      }
      if (name === 'location') {
        var hl = field.parentElement.querySelector('small.location-error');
        if (!hl) return;
        if (!field.value) hl.textContent = 'Ce champ est obligatoire';
        else if (!field.checkValidity()) hl.textContent = field.title || 'Valeur invalide';
        else hl.textContent = '';
        return;
      }
    }

    function toggle() {
      // per-field visual state
      fields.forEach(function(field) {
        const shouldShow = form.classList.contains('was-validated') || (field.value !== '' && field.value !== null);
        if (shouldShow) {
          if (field.checkValidity()) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
          } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
          }
        }
        setCustomMessage(field);
      });

      // submit enablement
      const valid = form.checkValidity();
      if (submitBtn) {
        submitBtn.disabled = !valid;
        if (valid) {
          submitBtn.classList.remove('btn-secondary');
          submitBtn.classList.add('btn-primary');
        } else {
          submitBtn.classList.add('btn-secondary');
          submitBtn.classList.remove('btn-primary');
        }
      }
    }

    form.addEventListener('submit', function(e) {
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add('was-validated');
      toggle();
    });

    fields.forEach(function(field) {
      ['input', 'change', 'keyup', 'blur'].forEach(function(evt) {
        field.addEventListener(evt, toggle);
      });
    });

    // initial
    toggle();
  }

  // Wire all forms present
  document.querySelectorAll('.validate-form').forEach(function(form){
    wireForm(form);
    // Only show required hints by default for ADD modal, not EDIT
    var inAdd = form.closest('#addPlantModal') !== null;
    if (inAdd) {
      form.querySelectorAll('input,select').forEach(function(field){ field.classList.add('is-invalid'); });
      var nameH = form.querySelector('small.name-error'); if (nameH) nameH.textContent = 'Ce champ est obligatoire';
      var typeH = form.querySelector('small.type-error'); if (typeH) typeH.textContent = 'Ce champ est obligatoire';
      var ageH = form.querySelector('small.age-error'); if (ageH) ageH.textContent = 'Ce champ est obligatoire';
      var locH = form.querySelector('small.location-error'); if (locH) locH.textContent = 'Ce champ est obligatoire';
    }
  });

  // If Bootstrap is present, also wire on modal show
  document.addEventListener('shown.bs.modal', function(e) {
    const form = e.target.querySelector('.validate-form');
    if (form) {
      // Re-wire on each open to recompute validity (especially after resets)
      try { delete form.__wired; } catch (err) { form.__wired = false; }
      wireForm(form);
      // Force immediate validation pass
      Array.from(form.querySelectorAll('input,select')).forEach(function(field){
        field.dispatchEvent(new Event('input'));
        field.dispatchEvent(new Event('change'));
      });
    }
  });
});
</script>
@endsection
