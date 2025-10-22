@extends('layouts.layout')

@section('content')
    @php
        // Passer les publications à la vue pour les statistiques
        $publicationsForStats = $publications ?? collect([]);
    @endphp
    <div class="container mt-4">
        <h1>Admin Publications</h1>

        <!-- Search and Filter Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="d-flex gap-2 align-items-center">
                    <input type="text" id="search-publication" class="form-control form-control-lg shadow-sm" placeholder="Rechercher une publication..." style="border-radius: 2rem; font-size: 1.1rem; padding: 0.75rem 1.5rem; border: 2px solid #1cc88a; background: #fff; transition: box-shadow 0.2s;" autocomplete="off">
                    <select id="sort-publication" class="form-select form-select-lg shadow-sm" style="border-radius:2rem; font-size:1.1rem; padding:0.75rem 1.5rem; border:2px solid #1cc88a; background:#fff; transition:box-shadow 0.2s; max-width:180px;">
                        <option value="desc" selected>Nouveaux</option>
                        <option value="asc">Anciens</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Publications List -->
        <div id="publications-list">
            @include('client_page.partials.publications_list', ['publications' => $publications])
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-publication');
            const sortSelect = document.getElementById('sort-publication');
            const publicationsList = document.getElementById('publications-list');
            let timer;
            function fetchPublications() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    const query = searchInput.value.trim();
                    const sort = sortSelect.value;
                    fetch(`/publications?search=${encodeURIComponent(query)}&sort=${sort}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            publicationsList.innerHTML = html;
                        });
                }, 350);
            }
            searchInput.addEventListener('input', fetchPublications);
            sortSelect.addEventListener('change', fetchPublications);

            // Existing toggle function for likes/dislikes
            window.toggleLikesDislikes = function(publicationId) {
                const element = document.getElementById('likes-dislikes-' + publicationId);
                if (element.style.display === 'none') {
                    element.style.display = 'block';
                } else {
                    element.style.display = 'none';
                }
            };
        });
    </script>
@endsection
