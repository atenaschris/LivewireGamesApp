<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class RecentlyReviewed extends Component
{

    public $recentlyReviewed = [];  

    public function loadGameAsSoonAsPossible()
    {
        $before= Carbon::now()->submonths(2)->timestamp;
        $current=Carbon::now()->timestamp;
        $recentlyReviewedGameUnformatted =Cache::remember('recently-reviewed',10,function() use($before,$current){
           
            return Http::withHeaders([
                'Client-ID' => 'ozvdx5o7wgldpzcfuucvnk4pzjg1u0',
                'Authorization' => 'Bearer zw41m0f7c98ugj72hd3hr6nqybiinu',
                
            ])->withBody(
                "fields name,cover.url,first_release_date,total_rating_count, platforms.abbreviation, rating, slug, summary;
                where platforms = (48,49,130,6)
                & ( first_release_date >= {$before} 
                    & first_release_date < {$current}  
                    & total_rating_count > 5); 
                sort total_rating_count desc;
                limit 3;","text/plain"
                
            )->post('https://api.igdb.com/v4/games')->json();
        }) ; 

        
        $this->recentlyReviewed = $this->formatForView($recentlyReviewedGameUnformatted);
        
        collect($this->recentlyReviewed)->filter(function($game){
            return $game['rating'];
        })->each(function($game){
            $this->emit('recentlyGameWithRatingAdded',[
                'slug'=>'reviewed_'.$game['slug'],
                'rating'=>$game['rating']/100
            ]);
        });
        /* dump($this->recentlyReviewed); */
        
    }
    
    private function formatforView($games){
        return collect($games)->map(function($game){
            return collect($game)->merge([
                "coverImageUrl"=> array_key_exists('cover',$game) ? Str::replaceFirst('thumb','cover_big',$game['cover']['url']) : 'https://picsum.photos/192/256',
                "rating"=>array_key_exists('rating',$game) ? round($game['rating']) : '0',
                "abbreviation"=> array_key_exists('platforms',$game) ? collect($game['platforms'])->implode('abbreviation', ', ') : 'no platforms for this game',
            ]); 
        })->toArray();
    }
    
    public function render()
    {
        return view('livewire.recently-reviewed');
    }

    
}
