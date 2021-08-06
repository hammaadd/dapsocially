@extends('visitor.layout.visitorLayout')
@section('title','Report Abuse')
@section('content')
@include('visitor.inc.homeBanner')
<section>
    <main class="max-w-6xl mx-auto">
        <h3 class="text-xl font-medium text-center uppercase mt-5">Report Abuse</h3>
        {{-- Social Plateforms Section --}}
        <section class="py-5 px-5 lg:py-10">
            <p class=" text-center uppercase font-medium text-xl">{{$abuse->heading}}</p>
            <p class=" text-center text-lg mt-5">
                {!!$abuse->content!!}
            </p>
        </section>

    </main>
    @include('visitor.inc.footer')
</section>
@endsection
