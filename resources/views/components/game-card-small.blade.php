<div class="game flex">
    <a href="{{ route('games.show',$game['slug']) }}">
        <img src="{{ $game['coverImageUrl']}}" alt=""
            class="hover:opacity-75 transition ease-in-out duration:150 w-16">
    </a>
    <div class="ml-4">
        <a href="{{ route('games.show',$game['slug']) }}" class="hover:text-gray-600">{{$game['name']}}</a>
        @if (array_key_exists('first_release_date',$game))
        <p class="text-gray-400-text-sm-mt-1">
                
            {{$game['first_release_date']}}
        
        </p>
        @else

        <p>No release date for this game</p>

        @endif
    </div>
</div>