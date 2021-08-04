@extends('visitor.layout.visitorLayout')
@section('title','Features')
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        <h3 class="text-xl font-medium text-center uppercase mt-5">Features</h3>
        {{-- Social Plateforms Section --}}
        <section class="py-5 px-5 lg:py-10">
            <p class=" text-center uppercase font-medium text-xl">{{$features->heading}}</p>
            <p class=" text-center text-lg mt-5">
                {!!$features->content!!}
            </p>
        </section>

    </main>
    @include('visitor.inc.footer')
</section>
@endsection
