<div class="relative" x-data="{isVisible: true}" @click.away="isVisible= false">
    <input
     x-ref="search"
    {{--  @keydown.window ="
     if(event.keyCode === 191 {
         event.preventDefault();
         $refs.search.focus();
        }
    " --}}
    @focus="isVisible = true"
    @keydown.escape.window="isVisible = false"
    @keydown="isVisible = true"
    @keydown.shift.tab="isVisible= false"
    
     wire:model.debounce.500ms="search" 
     type="text" class="bg-gray-800 text-sm rounded-full px-3 w-64 focus:outline-none
    focus:shadow-outline  py-1 pl-8" placeholder="Search(Press / to focus)">
    <div class="absolute top-0 flex items-center h-full ml-2">
        <i class="fas fa-search "></i>
    </div>

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3 " style="position:absolute;"></div>

    @if (strlen($search)>=2)
        
    <div x-show.transition.opacity.duration.1000="isVisible" class="absolute z-50 w-64 bg-gray-800 text-xs mt-2">

        @if (count($searchResults) > 2)
            
        <ul>
            @foreach ($searchResults as $game)
                
                <li class="border-b border-gray-700">
                    <a 
                    href="{{route('games.show',$game['slug'])}}" 
                    class="block hover:bg-gray-700 flex items-center transition ease-in-out duration-150 px-3 py-3"
                     @if($loop->last)  @keydown.tab="isVisible = false" @endif>
                        @if (isset($game['cover']))
                            
                        <img src="{{Str::replaceFirst('thumb','cover_small',$game['cover']['url'])}}" alt="" class="w-12">
                        
                        @else
                        <img src="https://picsum.photos/48/64" alt="" class="w-12">
                        @endif
                        <span class="ml-4">{{$game['name']}}</span>
                    </a>
                </li>

            @endforeach
           
            
           
        </ul>
        @else
        <div class="px-2 py-2">No results found for "{{$search}}"</div>
        @endif
    </div>

    @endif
</div>
