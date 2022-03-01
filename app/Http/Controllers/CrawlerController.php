<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datama;

class CrawlerController extends Controller
{
    //
    public function index()
    {
        return view('crawler', [
            "title" => "Crawler",
            "active" => "crawler"
        ]);
    }
    public function result()
    {
        return view('results', [
            "title" => "All News",
            "active" => "result",
            "posts" => Datama::orderBy("id", "ASC")->paginate(10),
        ]);
    }
}
