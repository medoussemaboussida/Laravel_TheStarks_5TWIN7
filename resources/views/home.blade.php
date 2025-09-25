@extends('layouts.app')

@section('title','Accueil - UrbanGreen')

@section('content')
  <!-- Copie ici le contenu <main> du template (sections hero, about, features...) -->
  <!-- Exemple : Hero (adapté) -->
  <section id="hero" class="hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
          <h1 class="hero-title">Creating Digital Experiences That Matter</h1>
          <p class="hero-description">We craft beautiful, functional, and meaningful digital solutions...</p>
          <a href="#about" class="btn-primary">Start Your Journey</a>
        </div>
        <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
          <img src="{{ asset('assets/img/illustration/illustration-15.webp') }}" class="img-fluid hero-image" alt="Hero">
        </div>
      </div>
    </div>
  </section>

  <!-- Copie les autres sections (About, Features...) depuis ton fichier html.txt -->
@endsection
