
 <div wire:init="loadGameAsSoonAsPossible" class="popular-games text-sm grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 xl:grid-cols-6 gap-12 border-b border-gray-800 pb-16">
    @forelse ($popularGames as $game)

     <x-game-card :game="$game" />
        
        @empty

     <x-skeleton-games-card/>
  
    @endforelse

   
</div> 

@push('scripts')

@include('_rating',[
    'event'=>'gameWithRatingAdded'
])
   {{--  <script>
        window.livewire.on('gameWithRatingAdded', params => {
            console.log('A post was emitted with the id of: ' + params.slug);
        })
    </script> --}}
@endpush