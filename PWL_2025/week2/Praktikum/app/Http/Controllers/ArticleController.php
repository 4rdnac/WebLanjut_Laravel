<?php

namespace App\Http\Controllers;

class ArticleController extends Controller
{
    public function __invoke($id)
    {
        return "Halaman Artikel dengan ID $id";
    }
}
