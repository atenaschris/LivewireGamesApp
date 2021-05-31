<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ComingSoon extends Component
{   
    public $comingSoon = [];

    public function loadGameAsSoonAsPossible()
    {
        $current=Carbon::now()->timestamp;
               
        $comingSoonGameUnformatted =Cache::remember('coming-soon',10,function() use($current){
            
            return  Http::withHeaders([
                'Client-ID' => 'ozvdx5o7wgldpzcfuucvnk4pzjg1u0',
                'Authorization' => 'Bearer zw41m0f7c98ugj72hd3hr6nqybiinu',
                
            ])->withBody(
                "fields name,cover.url,first_release_date,total_rating_count, platforms.abbreviation, rating, slug, summary;
                where platforms = (48,49,130,6)
                & ( first_release_date >= {$current}); 
                sort first_release_date asc;
                limit 4;","text/plain"
                
            )->post('https://api.igdb.com/v4/games')->json();
        }) ;

        

        $this->comingSoon = $this->formatforView($comingSoonGameUnformatted);

        /*  dd($this->comingSoon);  */
    }

    private function formatForView($games){
       
        return collect($games)->map(function($game){
            return collect($game)->merge([
                'coverImageUrl'=>array_key_exists('cover',$game)?Str::replaceFirst('thumb','cover_small',$game['cover']['url']) : 'https://picsum.photos/64/85',
                'first_release_date'=>Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
    public function render()
    {
        return view('livewire.coming-soon');
    }
}
