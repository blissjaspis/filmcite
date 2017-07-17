<?php

namespace App\Http\Controllers;

use App;
use App\Models\Film;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = App::make('sitemap');

        $sitemap->addSitemap(route('sitemap.movie'));
        $sitemap->addSitemap(route('sitemap.series'));

        return $sitemap->render('sitemapindex');
    }

    public function movie()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('sitemap.movie', 3600);

        $movies = Film::whereType('movie')
            ->orderBy('title', 'ASC')
            ->get();

        foreach ($movies as $movie) {
            $sitemap->add(
                route('film.view', $movie->slug),
                $movie->updated_at,
                0.8,
                'monthly'
            );
        }

        return $sitemap->render('xml');
    }

    public function series()
    {
        $sitemap = App::make('sitemap');

        $sitemap->setCache('sitemap.series', 3600);

        $series = Film::whereType('series')
            ->orderBy('title', 'ASC')
            ->get();

        foreach ($series as $tv) {
            $sitemap->add(
                route('film.view', $tv->slug),
                $tv->updated_at,
                0.8,
                'monthly'
            );
        }

        $sitemap->render('xml');
    }
}
