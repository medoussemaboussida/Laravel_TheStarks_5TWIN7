@extends('admin_dashboard.layout')

@section('title', 'Liste des Types de Plantes')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Liste des Types de Plantes</h1>
<p class="mb-4">Voici la liste des types de plantes enregistrés. Vous pouvez ajouter, modifier ou supprimer des types.</p>

<!-- Boutons d'action -->
<div class="mb-3">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTypeModal">
        Ajouter un type
    </button>
    <button type="button" class="btn btn-info ml-2" onclick="regenerateQRCodes()">
        <i class="fas fa-qrcode"></i> Régénérer QR Codes
    </button>
</div>

@if(session('success'))
    <p class="text-success">{{ session('success') }}</p>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Types de Plantes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="typesTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>QR Code</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $type)
                    <tr>
                        <td class="text-center">
                            @php
                                $searchQuery = $type->name . ' plante type';
                                $googleUrl = 'https://www.google.com/search?q=' . urlencode($searchQuery) . '&tbm=isch';
                                $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($googleUrl);
                            @endphp
                            <div class="qr-code-simple">
                                <img src="{{ $qrCodeUrl }}" 
                                     alt="QR Code pour {{ $type->name }}" 
                                     class="qr-image"
                                     onclick="window.open('{{ $googleUrl }}', '_blank')"
                                     title="Scanner pour voir des images de {{ $type->name }}">
                                <div class="qr-label">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">
                                        <i class="fas fa-qrcode"></i> Scanner
                                    </small>
                                    <small class="text-primary d-block" style="font-size: 0.6rem; font-weight: bold;">
                                        {{ $type->name }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $type->name }}</td>
                        <td>{{ $type->description }}</td>
                        <td>
                            <!-- Bouton Modifier -->
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editTypeModal{{ $type->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                            </button>


                            <!-- Bouton Supprimer -->
                           <form action="{{ route('plant-types.destroy', $type->id) }}" method="POST" style="display:inline;" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm btn-delete" title="Supprimer">
        <i class="fas fa-trash"></i>
    </button>
</form>

                        </td>
                    </tr>

                    <!-- Modal Modifier -->
                    <div class="modal fade" id="editTypeModal{{ $type->id }}" tabindex="-1" role="dialog" aria-labelledby="editTypeModalLabel{{ $type->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                               <form action="{{ route('plant-types.update', $type->id) }}" method="POST" class="validate-form needs-validation" novalidate>
    @csrf
    @method('PUT')
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editTypeModalLabel{{ $type->id }}">Modifier le Type de Plante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nom du type</label>
            <input type="text" name="name" required pattern="^[A-Za-zÀ-ÿ\s]{3,50}$" title="Uniquement des lettres (3 à 50)" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $type->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger name-error"></small>
            <div class="invalid-feedback name-feedback"></div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" required pattern="^[A-Za-zÀ-ÿ\s\.,'-]{5,200}$" title="5 à 200 caractères, lettres uniquement (sans chiffres)" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $type->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger desc-error"></small>
            <div class="invalid-feedback desc-feedback"></div>
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
<div class="text-center mt-3">
    {{ $types->onEachSide(0)->links('pagination::simple-bootstrap-4') }}
</div>


<!-- Modal Ajouter un Type -->
<div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{ route('plant-types.store') }}" method="POST" class="validate-form needs-validation" novalidate>
    @csrf
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="addTypeModalLabel">Ajouter un Type de Plante</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-white">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="name">Nom du type</label>
            <input type="text" name="name" required pattern="^[A-Za-zÀ-ÿ\s]{3,50}$" title="Uniquement des lettres (3 à 50)" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger name-error"></small>
            <div class="invalid-feedback name-feedback"></div>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" required pattern="^[A-Za-zÀ-ÿ\s\.,'-]{5,200}$" title="5 à 200 caractères, lettres uniquement (sans chiffres)" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-danger desc-error"></small>
            <div class="invalid-feedback desc-feedback"></div>
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

@endsection

<style>
/* Styles pour les codes QR simplifiés */
.qr-code-simple {
    text-align: center;
    padding: 5px;
}

.qr-image {
    border: 2px solid #007bff;
    border-radius: 8px;
    padding: 5px;
    background: white;
    width: 100px;
    height: 100px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: block;
    margin: 0 auto;
}

.qr-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.qr-label {
    margin-top: 5px;
    text-align: center;
}

/* Style pour le tableau */
#typesTable th:first-child {
    width: 140px;
    text-align: center;
}

#typesTable td:first-child {
    vertical-align: middle;
    text-align: center;
    padding: 10px;
}
</style>

<script>
$(document).ready(function() {
    // DataTable
    $('#typesTable').DataTable({
        "pagingType": "simple_numbers",
        "pageLength": 5,
        "lengthChange": false,
        "language": {"paginate": {"previous": "<", "next": ">" }},
        "dom": '<"top"f>rt<"bottom"ip><"clear">'
    });

    // Confirmation avant suppression
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        let form = $(this).closest('form');
        if(confirm("Êtes-vous sûr de supprimer ce type ?")) {
            form.submit();
        }
    });

    // Validation + activation boutons (types)
    function wireTypeForm($form){
        const $submit = $form.find('button[type="submit"]');
        function toggle(){
            const $name = $form.find('input[name="name"]');
            const $desc = $form.find('textarea[name="description"]');
            const nameVal = $name.val() || '';
            const descVal = $desc.val() || '';
            const nameOk = /^[A-Za-zÀ-ÿ\s]{3,50}$/.test(nameVal);
            const descOk = /^[A-Za-zÀ-ÿ\s\.,'-]{5,200}$/.test(descVal);

            // inline messages
            const $nameMsg = $name.parent().find('small.name-error');
            if (!nameVal) $nameMsg.text('Ce champ est obligatoire');
            else if (/\d/.test(nameVal)) $nameMsg.text('Ce champ ne doit pas contenir des chiffres');
            else if (!nameOk) $nameMsg.text('Uniquement des lettres (3 à 50)');
            else $nameMsg.text('');

            const $descMsg = $desc.parent().find('small.desc-error');
            if (!descVal) $descMsg.text('Ce champ est obligatoire');
            else if (/\d/.test(descVal)) $descMsg.text('Ce champ ne doit pas contenir des chiffres');
            else if (!descOk) $descMsg.text('5 à 200 caractères, lettres uniquement');
            else $descMsg.text('');

            // classes
            $name.toggleClass('is-invalid', !nameOk).toggleClass('is-valid', nameOk);
            $desc.toggleClass('is-invalid', !descOk).toggleClass('is-valid', descOk);

            if (nameOk && descOk){
                $submit.prop('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
            } else {
                $submit.prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
            }
        }
        $form.on('submit', function(e){
            if ($submit.prop('disabled')){ e.preventDefault(); e.stopPropagation(); }
            $form.addClass('was-validated');
            toggle();
        });
        $form.find('input,textarea').on('input change keyup blur', toggle);
        toggle();
    }
    $('.validate-form').each(function(){ wireTypeForm($(this)); });

    // On modal open
    $(document).on('shown.bs.modal', '#addTypeModal, [id^="editTypeModal"]', function(){
        const $form = $(this).find('.validate-form');
        if ($form.length){
            wireTypeForm($form);
            // Trigger initial validation for EDIT so button reflects current validity
            $form.find('input,textarea').trigger('input');
        }
        if (this.id === 'addTypeModal'){
            $form.find('input,textarea').addClass('is-invalid');
            $form.find('small.name-error').text('Ce champ est obligatoire');
            $form.find('small.desc-error').text('Ce champ est obligatoire');
        }
    });
    // On modal close
    $(document).on('hidden.bs.modal', '#addTypeModal, [id^="editTypeModal"]', function(){
        const $form = $(this).find('.validate-form');
        if ($form.length){
            $form.removeClass('was-validated')[0].reset();
            const $submit = $form.find('button[type="submit"]');
            $submit.prop('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
            $form.find('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
            $form.find('small.name-error, small.desc-error').text('');
        }
    });
});
</script>
<script>
// Vanilla JS fallback for Type modals
document.addEventListener('DOMContentLoaded', function(){
  function wire(form){
    if (!form || form.__wired) return; form.__wired = true;
    const submit = form.querySelector('button[type="submit"]');
    const name = form.querySelector('input[name="name"]');
    const desc = form.querySelector('textarea[name="description"]');
    const nameMsg = form.querySelector('small.name-error');
    const descMsg = form.querySelector('small.desc-error');
    function validName(v){ return /^[A-Za-zÀ-ÿ\s]{3,50}$/.test(v || ''); }
    function validDesc(v){ return /^[A-Za-zÀ-ÿ0-9\s\.,'-]{5,200}$/.test(v || ''); }
    function toggle(){
      const nv = name ? name.value : '';
      const dv = desc ? desc.value : '';
      if (name){
        if (!nv) { nameMsg && (nameMsg.textContent='Ce champ est obligatoire'); name.classList.add('is-invalid'); name.classList.remove('is-valid'); }
        else if (/\d/.test(nv)) { nameMsg && (nameMsg.textContent='Ce champ ne doit pas contenir des chiffres'); name.classList.add('is-invalid'); name.classList.remove('is-valid'); }
        else if (!validName(nv)) { nameMsg && (nameMsg.textContent='Uniquement des lettres (3 à 50)'); name.classList.add('is-invalid'); name.classList.remove('is-valid'); }
        else { nameMsg && (nameMsg.textContent=''); name.classList.remove('is-invalid'); name.classList.add('is-valid'); }
      }
      if (desc){
        if (!dv) { descMsg && (descMsg.textContent='Ce champ est obligatoire'); desc.classList.add('is-invalid'); desc.classList.remove('is-valid'); }
        else if (/\d/.test(dv)) { descMsg && (descMsg.textContent='Ce champ ne doit pas contenir des chiffres'); desc.classList.add('is-invalid'); desc.classList.remove('is-valid'); }
        else if (!validDesc(dv)) { descMsg && (descMsg.textContent='5 à 200 caractères, lettres uniquement'); desc.classList.add('is-invalid'); desc.classList.remove('is-valid'); }
        else { descMsg && (descMsg.textContent=''); desc.classList.remove('is-invalid'); desc.classList.add('is-valid'); }
      }
      const ok = (!name || validName(nv)) && (!desc || validDesc(dv));
      if (submit){
        submit.disabled = !ok;
        if (ok){ submit.classList.remove('btn-secondary'); submit.classList.add('btn-primary'); }
        else { submit.classList.add('btn-secondary'); submit.classList.remove('btn-primary'); }
      }
    }
    if (name){ ['input','change','keyup','blur'].forEach(e=>name.addEventListener(e,toggle)); }
    if (desc){ ['input','change','keyup','blur'].forEach(e=>desc.addEventListener(e,toggle)); }
    form.addEventListener('submit', function(e){ if (submit && submit.disabled){ e.preventDefault(); e.stopPropagation(); } toggle(); });
    toggle();
  }
  document.querySelectorAll('#addTypeModal .validate-form, [id^="editTypeModal"] .validate-form').forEach(wire);
  document.addEventListener('shown.bs.modal', function(e){ const f=e.target.querySelector('.validate-form'); if (f){ try{ delete f.__wired; }catch{} wire(f); if (e.target.id==='addTypeModal'){ f.querySelectorAll('input,textarea').forEach(el=>el.classList.add('is-invalid')); const ne=f.querySelector('small.name-error'); if(ne) ne.textContent='Ce champ est obligatoire'; const de=f.querySelector('small.desc-error'); if(de) de.textContent='Ce champ est obligatoire'; } }});
  document.addEventListener('hidden.bs.modal', function(e){ const f=e.target.querySelector('.validate-form'); if (f){ f.reset(); f.classList.remove('was-validated'); const submit=f.querySelector('button[type="submit"]'); if(submit){ submit.disabled=true; submit.classList.add('btn-secondary'); submit.classList.remove('btn-primary'); } f.querySelectorAll('.is-valid,.is-invalid').forEach(el=>{el.classList.remove('is-valid'); el.classList.remove('is-invalid');}); const ne=f.querySelector('small.name-error'); if(ne) ne.textContent=''; const de=f.querySelector('small.desc-error'); if(de) de.textContent=''; }});
});

// Fonction simple pour régénérer les QR codes (rechargement de page)
function regenerateQRCodes() {
    console.log('Régénération des QR codes...');
    location.reload();
}

// Exposer la fonction globalement
window.regenerateQRCodes = regenerateQRCodes;
</script>
