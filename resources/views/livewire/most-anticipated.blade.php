<div wire:init="loadGameAsSoonAsPossible" class="most-anticipated-container space-y-10 mt-8">
    @forelse ($mostAnticipated as $game)
    <x-game-card-small :game="$game" />

    @empty
    <x-skeleton-game-card-small />
    @endforelse

</div>
