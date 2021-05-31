<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PopularGames extends Component
{
    public $popularGames=[];
    
    public function loadGameAsSoonAsPossible()
    {

        
        $before= Carbon::now()->submonths(2)->timestamp;
        $after= Carbon::now()->addmonths(2)->timestamp;

        $popularGamesUnformatted =Cache::remember('popular-games',1, function() use($before,$after){
            
            return Http::withHeaders([
                'Client-ID' => 'ozvdx5o7wgldpzcfuucvnk4pzjg1u0',
                'Authorization' => 'Bearer ux8ndcb2gg1ar6zsz3268beg2omatn',
                
            ])->withBody(
                "fields name,cover.url,first_release_date,total_rating_count, platforms.abbreviation, rating, slug;
                where platforms = (48,49,130,6)
                & ( first_release_date >= {$before} 
                    & first_release_date < {$after}  
                    & total_rating_count > 5); 
                sort total_rating_count desc;
                limit 12;","text/plain"
                
            )->post('https://api.igdb.com/v4/games')->json();
        })  ;



        /* dump($this->formatForView($popularGamesUnformatted)); */
        
        $this->popularGames = $this->formatForView($popularGamesUnformatted);
        
        collect($this->popularGames)->filter(function($game){
            return ($game['rating']);
        })->each(function($game){
            $this->emit('gameWithRatingAdded',[
                'slug'=>$game['slug'],
                'rating'=>$game['rating']/100

            ]);
        });


    }
    
    
    
    public function render()
    {
        return view('livewire.popular-games');
    }

    private function formatForView($games){
        return collect($games)->map(function($game){
            return collect($game)->merge([
                "coverImageUrl"=>Str::replaceFirst('thumb','cover_big',$game['cover']['url']),
                "rating"=>array_key_exists('rating',$game) ?  round($game['rating']) : '0',
                "platforms" =>array_key_exists('platforms',$game) ? collect($game['platforms'])->pluck('abbreviation')->implode(', ') : 'no platforms for this game',

               
                
            ]);
        })->toArray();
    }
}
