<div wire:init="loadGameAsSoonAsPossible" class="recently-reviewed-container space-y-12 mt-8">
    @forelse ($recentlyReviewed as $game) 
    <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
        <div class="relative flex-none ">
            <a href="{{ route('games.show',$game['slug']) }}">
             
             <img src="{{ $game['coverImageUrl']}}" alt="" class="hover:opacity-75 transition ease-in-out duration:150 w-48">
                 
            
            </a>
             
            <div id="{{'reviewed_'.$game['slug']}}" class="absolute bottom-0  right-0 w-16 h-16 bg-gray-900 rounded-full text-sm" style="right: -20px;bottom: -20px">
               <div class="font-semibold text-xs">
                 
               </div>
            </div>
        </div>
        <div class="ml-12">
            <a href="{{ route('games.show',$game['slug']) }}" class="block text-lg font-semibold leading-tight hover:text-gray-400 mt-4">{{ $game['name'] }}</a>
            <div class="text-gray-400 mt-1">
                @foreach ($game['platforms'] as $platform)
               
                    {{$platform['abbreviation']}}
            
                @endforeach
            </div>
            <p class="mt-6 text-gray-400  hidden md:block">
                @if (array_key_exists('summary',$game))
                {{substr($game['summary'], 0, 150)}}...
                @endif
            </p>
        </div>
    </div>
    @empty
        @foreach (range(1,3) as $item)  
        <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
            <div class="relative flex-none ">
                <div class=" h-40 lg:h-60 w-32 lg:w-48 bg-gray-700"></div>
            </div>
            <div class="ml-12">
                <div href="#" class="inline-block text-transparent text-lg bg-gray-700  mt-4 leading-tight">Title Goes here
                </div>
               <div class="mt-8 space-y-4 ">  
                   <span class="bg-gray-700 text-transparent inline-block">  Lorem ipsum, dolor sit amet consectetur adipisicing elit. sanbchsabvcHILVSA
                     </span>
                   <span class="bg-gray-700 text-transparent inline-block">  Lorem ipsum, dolor sit amet consectetur adipisicing elit. sanbchsabvcHILVSA 
                     </span>
                   <span class="bg-gray-700 text-transparent inline-block">  Lorem ipsum, dolor sit amet consectetur adipisicing elit. 
                    sanbchsabvcHILVSA 
                     </span>
            </div>
              
            </div>
        </div>
        @endforeach
    @endforelse


     
 </div>

 @push('scripts')

@include('_rating',[
    'event'=>'recentlyGameWithRatingAdded'
])
   {{--  <script>
        window.livewire.on('gameWithRatingAdded', params => {
            console.log('A post was emitted with the id of: ' + params.slug);
        })
    </script> --}}
@endpush
