<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = [
            [
                'title' => 'Introduction à Laravel',
                'author' => 'Mariem Chaabani',
                'content' => 'Laravel est un framework PHP puissant et élégant.'
            ],
            [
                'title' => 'Comprendre Blade',
                'author' => 'John Doe',
                'content' => 'Blade est le moteur de template de Laravel.'
            ],
            [
                'title' => 'Middleware dans Laravel',
                'author' => 'Jane Smith',
                'content' => 'Les middlewares permettent de filtrer les requêtes HTTP.'
            ],
        ];

        return view('articles', compact('articles'));
    }
}
