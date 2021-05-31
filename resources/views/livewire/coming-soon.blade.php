<div wire:init="loadGameAsSoonAsPossible" class="coming-soon-container space-y-10 mt-8">
    @forelse ($comingSoon as $game)

    <x-game-card-small :game="$game" />

    @empty
    <x-skeleton-game-card-small />

    @endforelse

</div>
