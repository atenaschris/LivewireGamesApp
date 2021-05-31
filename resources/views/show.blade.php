@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">

    {{--  start game details --}}
    <div class="game-details border-b border-gray-800 pb-12 flex flex-col md:flex-row">
        <div class="flex-none">

            <img src="{{$game['coverImageUrl']}}" alt="" class="w-64 ml-10">

        </div>

        <div class=" ml-12">
            <h2 class="font-semibold text-4xl leading-tight mt-1">{{$game['name']}}</h2>
            <div class="text-gray-400 mt-2 ">
                <span>
                    {{ $game['genres'] }}
                </span>
                <span>

                    {{--  @foreach ($game['involved_companies']['company'] as $company)
                             @if (array_key_exists('name',$company))
                            {{$company['name']}}
                    @endif
                    @endforeach --}}
                    {{$game['involved_companies']}},
                </span>
                <span>

                    {{$game['platforms']}}
                </span>

            </div>
            <div class="flex flex-wrap items-center mt-8 ">
                <div class="flex items-center">
                    <div id="memberRating" class="w-16 h-16 bg-gray-800 rounded-full relative text-sm">
                        @push('scripts')
                        @include('_rating', [
                        'id' =>'memberRating',
                        'rating'=>$game['rating'],
                        'event'=>null,
                        ])
                        @endpush
                        {{-- <div class="font-semibold-text-xs flex justify-center items-center h-full">

                            {{$game['rating']}}


                    </div> --}}

                </div>
                <div class="ml-4 text-xs">Member <br> Score</div>
            </div>
            <div class="flex items-center ml-3  md:ml-12">
                <div id="aggregatedRating" class="w-16 h-16 bg-gray-800 rounded-full relative text-sm">
                    @push('scripts')
                    @include('_rating', [
                    'id' =>'aggregatedRating',
                    'rating'=>$game['aggregated_rating'],
                    'event'=>null,
                    ])
                    @endpush

                </div>
                <div class="ml-4 text-xs">Critic <br> Score</div>
            </div>
            <div class="flex items-center space-x-4 mt-5 md:mt-0 md:ml-12">
                @if ($game['social']['official'])

                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center"><a
                        href="{{$game['social']['official']['url']}}" class="hover:text-gray-400"><i
                            class="fas fa-globe"></i></a> </div>
                @endif
                @if ($game['social']['facebook'])

                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center"><a
                        href="{{$game['social']['facebook']['url']}}" class="hover:text-gray-400"><i
                            class="fab fa-facebook"></i></a></div>
                @endif

                @if ($game['social']['instagram'])

                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center"><a
                        href="{{$game['social']['instagram']['url']}}" class="hover:text-gray-400"><i
                            class="fab fa-instagram"></i></a></div>

                @endif

                @if ($game['social']['twitter'])

                <div class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center"><a
                        href="{{$game['social']['twitter']['url']}}" class="hover:text-gray-400"><i
                            class="fab fa-twitter"></i></a></div>
                @endif


                {{--  @else
                    <div>no social links for this game</div> --}}




            </div>
        </div>

        <p class="mt-5 md:mt-10 mr-20">{{$game['summary']}}</p>

        <div 
        x-data="{isTrailerModalVisible: false}" 
        class="mt-10">

        <button
        @click="isTrailerModalVisible= true"
            class="flex items-center bg-blue-500 text-white font-semibold px-4 py-4 hover:bg-blue-600 rounded transition ease-in-out duration-150">
            <i class="fas fa-play-circle mr-2"></i>
            <span>Play Trailer</span>
        </button>

            {{-- <a href="{{ $game['videos'] }}"
                class="inline-flex flex items-center bg-blue-500 text-white font-semibold px-4 py-4 hover:bg-blue-600 rounded transition ease-in-out duration-150">
                <i class="fas fa-play-circle mr-2"></i>
                <span>Play Trailer</span>
            </a> --}}
        <template x-if="isTrailerModalVisible">

            <div x-show="isTrailerModalVisible" class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto "
                style="background-color: rgba(0,0,0,.5); z-index: 9999;">

                <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                    <div class="bg-gray-900 rounded">
                        <div class="flex justify-end pr-4 pt-2">
                            <button
                            @click="isTrailerModalVisible= false"
                            @keydown.escape.window="isTrailerModalVisible= false"
                             class="text-3xl leading-none hover:ext-gray-300">&times;</button>
                        </div>
                        <div class="modal-body px-8 py-8">
                            <div class="responsive-container overflow-hidden relative" style="padding-top: 56.25%">
                                <iframe 
                                width="560" height="315" src="{{ $game['videos'] }}" class="responsive-iframe absolute top-0 left-0 w-full h-full"
                                    allow="autoplay;encrypted-media" allowfullscreen></iframe>
                            </div>

                        </div>
                    </div>
                </div>


            </div>

        </template>


            @if (!isset($game['videos']))

            <a href="#"
                class="inline-flex flex items-center bg-blue-500 text-white font-semibold px-4 py-4 hover:bg-blue-600 rounded transition ease-in-out duration-150">
                <i class="fas fa-play-circle mr-2"></i>
                <span>No trailers found for {{ $game['name'] }}</span>
            </a>

            @endif

        </div>

    </div>
</div>
{{-- end game details --}}
{{-- start game screenshots --}}
<div 
x-data="{isImageModalVisible: false, image:''}"
class="screenshots-container border-b border-gray-800 pb-12 mt-8">
    <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-10">IMAGES</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mt-8">


        @if(isset($game['screenshots']))
        @foreach($game['screenshots'] as $screenshot)
        <a 
        @click.prevent="
        isImageModalVisible = true
        image='{{ $screenshot['huge'] }}'
        "
        class="hover:opacity-75" 
        href="#"
        >
            <img src="{{$screenshot['big']}}" alt="">
        </a>
        @endforeach
        @elseif($game['screenshots'] == null)

        <div>No screenshots availables for this game</div>

        @endif


    </div>

    <template x-if="isImageModalVisible">

        <div  class="fixed top-0 left-0 w-full h-full flex items-center shadow-lg overflow-y-auto "
        style="background-color: rgba(0,0,0,.5); z-index: 9999;">

            <div class="container mx-auto lg:px-32 rounded-lg overflow-y-auto">
                <div class="bg-gray-900 rounded">
                    <div class="flex justify-end pr-4 pt-2">
                        <button
                        @click="isImageModalVisible= false"
                        @keydown.escape.window="isImageModalVisible= false"
                        class="text-3xl leading-none hover:ext-gray-300">&times;</button>
                    </div>
                    <div class="modal-body px-8 py-8">

                       <img :src="image" alt="">

                    </div>
                </div>
            </div>


        </div>
    </template>
    {{-- end game screenshots --}}
    {{-- start simmilar games section --}}
    <div class="similar-games-container  mt-8">
        <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Similar Games</h2>
        {{--  start popular games --}}
        <div class="similar-games text-sm grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-12">
            @if ($game['similar_games'])
            @foreach ($game['similar_games'] as $game)

            <x-game-card :game="$game" />

            @endforeach
            @else

            <div>
                No silmiar games found for {{$game ['name']}}
            </div>
            @endif










        </div> {{-- end popular games --}}
    </div>
    {{-- end similar games section --}}
</div>
@endsection
