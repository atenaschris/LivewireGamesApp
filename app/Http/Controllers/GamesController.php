<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GamesController extends Controller
{
    
    
    public function index()
    {
   
            
        /* Se vogliamo usare Guzzle per velocizzare le 4 query all'api.... usiamo le multiquery */
          /* $client = new Client(['base_uri'=>'https://api-v4.igdb.com/']);
        $response = $client->request('POST','multiquery',[
            'headers'=>[
                'Client-ID' => 'thk8g4b8gr6tf0n9a5f8f5heoj79e9',
                'Authorization' => 'Bearer p7y6qv84td6lk5ayuoxado4tcl4t7x',
            ],
            'body'=>'
            query games "Playstation" {
                fiels name-popularity,platforms.name, first_release_date;
                where platforms = {6,48,130,49};
                sort total_rating_count desc;
                limit 2;
            };

            query games "Switch" {
                fields name, popularity, platforms.name, first_release_date;
                where platforms = {6,48,130,49};
                sort total_rating_count desc;
                limit 6;
            
            '
        ]);
                $body = $response->getBody();
                  */

            return view('index'); 

    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $game = Http::withHeaders(config('services.igdb'))->withBody(
            "fields name, cover.url, first_release_date, total_rating_count, platforms.abbreviation, rating, slug, involved_companies.company.name, genres.name, aggregated_rating, summary, websites.*, videos.*, screenshots.*, similar_games.cover.url, similar_games.name, similar_games.rating, similar_games.platforms.abbreviation, similar_games.slug;
            where slug=\"{$slug}\";
            ","text/plain"
            
        )->post('https://api.igdb.com/v4/games')->json();

       

        abort_if(!$game,404);

        
        return view('show', ['game'=>$this->formatGameForView($game[0] )]);
        
    }
    
private function formatGameforView($game){
    $temp = collect($game)->merge([
        'coverImageUrl'=>isset($game['cover']) ? Str::replaceFirst('thumb','cover_big',$game['cover']['url']) : 'https://picsum.photos/266/341',
        'genres'=>isset($game['genres'])? collect($game['genres'])->pluck('name')->implode(', ') : 'no genres for this game',
        'involved_companies'=>array_key_exists('involved_companies',$game)? $game['involved_companies'][0]['company']['name'] : 'no companies for this game involved',


        'platforms'=>isset($game['platforms'])? collect($game['platforms'])->pluck('abbreviation')->implode(', ') : 'no platforms for this game',
        'rating'=>isset($game['rating'])? round($game['rating']) : '0',
        'aggregated_rating'=>isset($game['aggregated_rating'])? round($game['aggregated_rating']) : '0',
        'videos'=>array_key_exists('videos',$game) ? 'https://youtube.com/embed/'.$game['videos'][0]['video_id'] : '#',
        'screenshots' =>array_key_exists('screenshots',$game) ?  collect($game['screenshots'])->map(function($screenshot) {
            return [ 

                'big'=>Str::replaceFirst('thumb', 'screenshot_big', $screenshot['url']),
                'huge'=>Str::replaceFirst('thumb', 'screenshot_huge', $screenshot['url']),

            ];
        })->take(9) : null ,
        'similar_games'=>isset($game['similar_games'])? collect($game['similar_games'])->map(function($similarGame){
            return collect($similarGame)->merge([
                'coverImageUrl'=>isset($similarGame['cover']) ? Str::replacefirst('thumb','cover_big',$similarGame['cover']['url']) : 'https://picsum.photos/266/341',
                'rating' =>isset($similarGame['rating']) ? round($similarGame['rating']) : '0',
                'platforms'=>isset($similarGame['platforms']) ? collect($similarGame['platforms'])->pluck('abbreviation')->implode(', ') : 'no platforms for this game',
            ]);
        })->take(6) : null,
        'social'=>
        [
            'official'=>array_key_exists('websites',$game) ? collect($game['websites'])->first() : null,
            'facebook'=>array_key_exists('websites',$game) ? collect($game['websites'])->filter(function($website){
                return Str::contains($website['url'],'facebook');
            })->first() : null,
            'twitter'=>array_key_exists('websites',$game) ? collect($game['websites'])->filter(function($website){
                return Str::contains($website['url'],'twitter');

            })->first() : null,
            'instagram'=>array_key_exists('websites',$game) ? collect($game['websites'])->filter(function($website){
                return Str::contains($website['url'],'instagram');
            })->first() : null,
        ] ,


    ])->toArray();
    /* dd($temp); */
    return $temp;   
}
    
           
            
    



  
}
