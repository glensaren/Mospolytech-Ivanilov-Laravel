<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $jsonPath = public_path('articles.json');
        
        if (!file_exists($jsonPath)) {
            $articles = [];
        } else {
            $jsonContent = file_get_contents($jsonPath);
            $articles = json_decode($jsonContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                $articles = [];
            }
            
            foreach ($articles as $index => &$article) {
                $article['id'] = $index + 1;
                if (!isset($article['shortDesc']) || empty($article['shortDesc'])) {
                    $article['shortDesc'] = substr($article['desc'], 0, 100) . '...';
                }
            }
        }
        
        return view('home', compact('articles'));
    }
    
    public function gallery($id = null)
    {
        $jsonPath = public_path('articles.json');
        
        if (!file_exists($jsonPath)) {
            return redirect('/')->with('error', 'Данные не найдены');
        }
        
        $jsonContent = file_get_contents($jsonPath);
        $articles = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return redirect('/')->with('error', 'Ошибка чтения JSON файла');
        }
        
        foreach ($articles as $index => &$article) {
            $article['id'] = $index + 1;
        }
        
        if ($id) {
            $article = null;
            foreach ($articles as $item) {
                if ($item['id'] == $id) {
                    $article = $item;
                    break;
                }
            }
            
            if (!$article) {
                return redirect('/')->with('error', 'Статья не найдена');
            }
            
            return view('gallery', compact('article'));
        }
        
        return view('gallery', compact('articles'));
    }
}