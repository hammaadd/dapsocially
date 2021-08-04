@extends('visitor.layout.visitorLayout')
@section('title','Help Center')
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        <h3 class="text-xl font-medium text-center uppercase mt-5">Help Center</h3>
        {{-- Social Plateforms Section --}}
        <section class="py-5 px-5 lg:py-10">
            <p class=" text-center uppercase font-medium text-xl">{{$help->heading}}</p>
            <p class=" text-center text-lg mt-5">
                {!!$help->content!!}
            </p>
        </section>

    </main>
    @include('visitor.inc.footer')
</section>
@endsection
