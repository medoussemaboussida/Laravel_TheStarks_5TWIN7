@extends('layouts.public')

@section('title', 'Contact - UrbanGreen')
@section('description', 'Contactez l\'équipe UrbanGreen pour vos questions, suggestions ou pour proposer un projet de végétalisation urbaine.')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background" data-aos="fade">
    <div class="container position-relative">
      <h1>Contactez-nous</h1>
      <p>Une question ? Un projet ? Nous sommes là pour vous accompagner</p>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ route('public.home') }}">Accueil</a></li>
          <li class="current">Contact</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Contact Section -->
  <section id="contact" class="contact section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      
      <div class="row gy-4">
        
        <div class="col-lg-6">
          <div class="info-wrap">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Adresse</h3>
                <p>123 Rue de la Végétalisation<br>75001 Paris, France</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Téléphone</h3>
                <p>+33 1 23 45 67 89</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email</h3>
                <p>contact@urbangreen.fr</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-clock flex-shrink-0"></i>
              <div>
                <h3>Horaires d'ouverture</h3>
                <p>Lundi - Vendredi: 9h00 - 18h00<br>Samedi: 9h00 - 16h00</p>
              </div>
            </div><!-- End Info Item -->
          </div>
        </div>

        <div class="col-lg-6">
          <form action="#" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">

              <div class="col-md-6">
                <label for="name-field" class="pb-2">Nom</label>
                <input type="text" name="name" id="name-field" class="form-control" required="">
              </div>

              <div class="col-md-6">
                <label for="email-field" class="pb-2">Email</label>
                <input type="email" class="form-control" name="email" id="email-field" required="">
              </div>

              <div class="col-md-12">
                <label for="subject-field" class="pb-2">Sujet</label>
                <select class="form-control" name="subject" id="subject-field" required="">
                  <option value="">Choisissez un sujet</option>
                  <option value="projet">Proposer un projet</option>
                  <option value="participation">Participer à un projet</option>
                  <option value="partenariat">Partenariat</option>
                  <option value="information">Demande d'information</option>
                  <option value="autre">Autre</option>
                </select>
              </div>

              <div class="col-md-12">
                <label for="message-field" class="pb-2">Message</label>
                <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
              </div>

              <div class="col-md-12 text-center">
                <div class="loading">Envoi en cours</div>
                <div class="error-message"></div>
                <div class="sent-message">Votre message a été envoyé. Merci !</div>

                <button type="submit">Envoyer le message</button>
              </div>

            </div>
          </form>
        </div><!-- End Contact Form -->

      </div>

    </div>
  </section><!-- /Contact Section -->

  <!-- FAQ Section -->
  <section id="faq" class="faq section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Questions fréquentes</h2>
      <p>Trouvez rapidement les réponses à vos questions</p>
    </div>

    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
          <div class="faq-container">

            <div class="faq-item faq-active">
              <h3>Comment puis-je participer à un projet UrbanGreen ?</h3>
              <div class="faq-content">
                <p>Il vous suffit de créer un compte sur notre plateforme, puis de parcourir nos projets et événements. Vous pouvez vous inscrire directement aux événements qui vous intéressent. Aucune expérience préalable n'est requise !</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Les événements sont-ils gratuits ?</h3>
              <div class="faq-content">
                <p>Oui, tous nos événements de végétalisation sont entièrement gratuits. Nous fournissons également le matériel nécessaire (outils, plants, etc.). Vous n'avez qu'à venir avec votre motivation !</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Puis-je proposer mon propre projet ?</h3>
              <div class="faq-content">
                <p>Absolument ! Nous encourageons les initiatives citoyennes. Contactez-nous avec votre idée de projet, et notre équipe vous accompagnera dans sa réalisation. Nous pouvons vous aider avec la planification, les autorisations et la mobilisation de la communauté.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Quels types de projets organisez-vous ?</h3>
              <div class="faq-content">
                <p>Nous organisons une grande variété de projets : jardins communautaires, toitures végétalisées, murs végétaux, plantations d'arbres, ateliers de sensibilisation, formations au jardinage urbain, et bien plus encore. Chaque projet est adapté aux besoins spécifiques du quartier.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Comment puis-je devenir bénévole régulier ?</h3>
              <div class="faq-content">
                <p>Nous sommes toujours à la recherche de bénévoles motivés ! Après avoir participé à quelques événements, vous pouvez nous contacter pour devenir bénévole régulier. Nous proposons également des formations pour devenir chef de projet ou animateur d'ateliers.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

            <div class="faq-item">
              <h3>Travaillez-vous avec les collectivités locales ?</h3>
              <div class="faq-content">
                <p>Oui, nous collaborons étroitement avec les mairies, les conseils départementaux et régionaux, ainsi qu'avec d'autres associations. Ces partenariats nous permettent de mener des projets d'envergure et d'obtenir les autorisations nécessaires pour végétaliser l'espace public.</p>
              </div>
              <i class="faq-toggle bi bi-chevron-right"></i>
            </div><!-- End Faq item-->

          </div>
        </div>
      </div>
    </div>
  </section><!-- /FAQ Section -->

  <!-- Call To Action Section -->
  <section id="call-to-action" class="call-to-action section dark-background">
    <img src="{{ asset('frontend/assets/img/features/features-2.webp') }}" alt="">

    <div class="container">
      <div class="row justify-content-center" data-aos="zoom-in" data-aos-delay="100">
        <div class="col-xl-10">
          <div class="text-center">
            <h3>Prêt à verdir votre ville ?</h3>
            <p>Rejoignez notre communauté et participez dès maintenant à la transformation écologique de votre environnement urbain.</p>
            @guest
              <a class="cta-btn" href="{{ route('register') }}">Rejoindre UrbanGreen</a>
            @else
              <a class="cta-btn" href="{{ route('public.projets.index') }}">Découvrir les projets</a>
            @endguest
          </div>
        </div>
      </div>
    </div>
  </section><!-- /Call To Action Section -->

@endsection

@section('styles')
<style>
.page-title {
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("frontend/assets/img/services/services-2.webp") }}') center center;
    background-size: cover;
    padding: 120px 0 60px 0;
    color: white;
}

.info-wrap {
    background: white;
    border-radius: 10px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.info-item {
    margin-bottom: 30px;
}

.info-item i {
    font-size: 24px;
    color: #28a745;
    margin-right: 20px;
    margin-top: 5px;
}

.info-item h3 {
    color: #333;
    font-size: 18px;
    margin-bottom: 5px;
}

.php-email-form {
    background: white;
    border-radius: 10px;
    padding: 40px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.php-email-form .form-control {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px;
    margin-bottom: 20px;
}

.php-email-form button[type="submit"] {
    background: #28a745;
    border: none;
    padding: 12px 30px;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.php-email-form button[type="submit"]:hover {
    background: #218838;
}

.faq-container .faq-item {
    background: white;
    border-radius: 10px;
    margin-bottom: 20px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: all 0.3s ease;
}

.faq-container .faq-item:hover {
    box-shadow: 0 5px 20px rgba(0,0,0,0.15);
}

.faq-container .faq-item h3 {
    color: #333;
    font-size: 16px;
    margin: 0;
    padding-right: 30px;
}

.faq-container .faq-item .faq-content {
    display: none;
    padding-top: 15px;
    color: #666;
}

.faq-container .faq-item.faq-active .faq-content {
    display: block;
}

.faq-container .faq-item .faq-toggle {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #28a745;
    transition: transform 0.3s ease;
}

.faq-container .faq-item.faq-active .faq-toggle {
    transform: translateY(-50%) rotate(90deg);
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Toggle
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        item.addEventListener('click', function() {
            // Fermer tous les autres items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('faq-active');
                }
            });
            
            // Toggle l'item actuel
            item.classList.toggle('faq-active');
        });
    });
});
</script>
@endsection
