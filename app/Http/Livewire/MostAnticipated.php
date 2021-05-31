<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];

    public function loadGameAsSoonAsPossible()
    {

        $current=Carbon::now()->timestamp;
        $afterFourMonths=Carbon::now()->addmonths(4)->timestamp;
       $mostAnticipatedGames = Cache::remember('most-anticipated',10,function() use($afterFourMonths,$current){
           
            return  Http::withHeaders([
                'Client-ID' => 'ozvdx5o7wgldpzcfuucvnk4pzjg1u0',
                'Authorization' => 'Bearer zw41m0f7c98ugj72hd3hr6nqybiinu',
                
            ])->withBody(
                "fields name,cover.url,first_release_date,total_rating_count, platforms.abbreviation, rating, slug, summary;
                where platforms = (48,49,130,6)
                & ( first_release_date >= {$current} 
                    & first_release_date < {$afterFourMonths}); 
                sort total_rating_count desc;
                limit 3;","text/plain"
                
            )->post('https://api.igdb.com/v4/games')->json();
        }) ;

        
        $this->mostAnticipated= $this->formatForview($mostAnticipatedGames);
        /* dd($this->mostAnticipated); */
    }

    private function formatForView($games){
        return collect($games)->map(function($game){
            return collect($game)->merge([
                'coverImageUrl' =>array_key_exists('cover',$game)? Str::replaceFirst('thumb','cover_small',$game['cover']['url'] ) : 'https://picsum.photos/64/85',
                'first_release_date'=>Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
    public function render()
    {
        return view('livewire.most-anticipated');
    }
}
