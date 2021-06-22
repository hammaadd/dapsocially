@extends('visitor.layout.visitorLayout')
@section('title','Pricing')
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        {{-- Social Plateforms Section --}}
        <section class="py-10">
            <div class="w-full overflow-hidden md:my-2 md:px-2 lg:my-3 lg:px-3 xl:my-3 xl:px-3">
                <h3 class="text-xl font-medium text-center uppercase mt-5">Pricing</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 py-5">
                    @foreach ($P_plans as $plans)


                    <div class="flex flex-wrap overflow-hidden flex-col items-center p-4 shadow-md rounded-xl bg-white">
                        <p class="uppercase text-lg text-center font-medium">{{$plans->name}}</p>
                        <img src="{{asset('assets/Group 392.png')}}" class="mt-3" alt="">
                        <hr class="w-3/5 mx-auto border-gray-900 my-3">
                        <p class="text-center">
                            {{$plans->description}}
                        </p>
                        @if ($plans->price==0)
                        <p class="text-2xl text-center uppercase my-3 font-medium">Free</p>
                        @else
                        <p class="text-2xl text-center uppercase my-3 font-medium">${{$plans->price}}</p>
                        @endif


                    </div>
                    @endforeach


                </div>
            </div>
        </section>




    </main>
    @include('visitor.inc.footer')
</section>
@endsection
