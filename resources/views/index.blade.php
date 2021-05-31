@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-blue-500 uppercase tracking-wide font-semibold">Popular Games</h2>
    
    {{-- <livewire:popular-games> --}}


        <div wire:init="loadGameAsSoonAsPossible" class="flex flex-col md:flex-row  my-10">
            <div class="recently-reviewed w-full md:w-3/4  mr-0 md:mr-32" >
             <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-10">Recently Reviewed</h2>

             <livewire:recently-reviewed>
             
        
        
            </div>
            <div class="most-anticipated md:w-1/4">
                <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-10">Most Anticipated</h2>
               <livewire:most-anticipated>

                <h2 class="text-blue-500 uppercase tracking-wide font-semibold mt-10">Coming Soon</h2>
               <livewire:coming-soon>   
            </div>
</div>
@endsection
