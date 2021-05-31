<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SearchDropdown extends Component
{
    public $search ='';
    public $searchResults = [];

    public function render()
    {
        if (strlen($this->search)>=2) {
           
            $this->searchResults =  Http::withHeaders([
                'Client-ID' => 'ozvdx5o7wgldpzcfuucvnk4pzjg1u0',
                'Authorization' => 'Bearer zw41m0f7c98ugj72hd3hr6nqybiinu',
                
            ])->withBody(
                "search \"{$this->search}\";
                fields name, cover.url,slug;
                limit 8;","text/plain"
    
            )->post('https://api.igdb.com/v4/games')->json();
        }



        

        return view('livewire.search-dropdown');
    }
}
