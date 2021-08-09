@extends('visitor.layout.visitorLayout')
@section('title', 'Events Payments')
@section('headerExtra')
    <link rel="stylesheet" href="{{ asset('css/masonry.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(e) {

            $('#c').on('change', function() {
                var query = $(this).children("option:selected").val();

                $.ajax({
                    url: "{{ route('filter.location') }}",
                    method: 'GET',
                    data: {
                        'q': query
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#location')
                            .find('option')
                            .remove()
                            .end()

                        ;
                        // for (var i in data) {
                        //         $('#location').append('<option value=' + data[i] + '>' + data[i] + '</option>');
                        //     }
                        $('#location').append(data);

                    }

                })
            });
        });
    </script>
@endsection
@section('content')
    @include('users.inc.nav')
    <main>
        <section class="page-title bg-white py-5 shadow-md">
            <h2 class="uppercase text-center text-xl font-medium">All Pyaments</h2>
        </section>

        {{-- <section class="page-title bg-blue-550 h-80 bg-center bg-cover" style="background-image: url(assets/BG.png)">
            <div class="w-full md:w-4/5 lg:w-1/2 mx-auto flex flex-wrap overflow-hidden h-full">
                <div class="w-full  md:w-1/2 overflow-hidden flex flex-wrap justify-center items-center">
                    <img src="{{ asset('assets/Event Illustration.png') }}" alt="">
                </div>
                <div class="w-full  md:w-1/2 overflow-hidden flex flex-wrap justify-center items-center">
                    <p class="text-white">
                        <span
                            class="px-16 py-4 border-2 border-white text-2xl uppercase block text-center">Payments</span><br>
                        ...
                    </p>
                </div>
            </div>
        </section>

        <div class="bg-white py-4 shadow-md">
            <div class=" max-w-7xl mx-auto">
                <div class="flex flex-wrap overflow-hidden justify-between items-center">
                    <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                        <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                            <img src="{{ asset('assets/fb.png') }}" class="w-6 h-6 mx-auto" alt="">
                        </div>
                        <span class="px-3">#event</span>
                    </label>
                    <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                        <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                            <img src="{{ asset('assets/twitter.png') }}" class="w-6 h-6 mx-auto" alt="">
                        </div>
                        <span class="px-3">#event2021</span>
                    </label>
                    <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                        <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                            <img src="{{ asset('assets/fb.png') }}" class="w-6 h-6 mx-auto" alt="">
                        </div>
                        <span class="px-3">#partynight</span>
                    </label>
                    <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                        <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                            <img src="{{ asset('assets/Insta.png') }}" class="w-6 h-6 mx-auto" alt="">
                        </div>
                        <span class="px-3">#dapsocially</span>
                    </label>
                    <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                        <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                            <img src="{{ asset('assets/twitter.png') }}" class="w-6 h-6 mx-auto" alt="">
                        </div>
                        <span class="px-3">#peterrabit2</span>
                    </label>
                    <label class="shadow-md rounded-xl bg-white flex items-center my-1">
                        <div class=" inline-block w-10 h-10 pt-1.5 shadow-md rounded-xl">
                            <img src="{{ asset('assets/Insta.png') }}" class="w-6 h-6 mx-auto" alt="">
                        </div>
                        <span class="px-3">#partytonight</span>
                    </label>
                </div>
            </div>
        </div> --}}

        <section class="p-4 max-w-full mx-auto">
            <h3>All Orders Invoices</h3>
            <div class=" mx-auto py-5">
                {{-- <div class="masonry md:cols--3 lg:cols--4"> --}}
                <div class="clearfix">
                    @if (count($events) == 0)
                        <h3 class=" mt-6 text-red-600 text-center text-xl font-medium">NO EVENTS FOUND <i
                                class="fas fa-exclamation"></i></h3>
                    @else
                        <table class=" border-separate border border-blue-800 w-full rounded">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Starts</th>
                                    <th>Ends</th>
                                    <th>Pricing</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($events as $event)
                                    <tr class="text-center">
                                        <td class="border-separate border border-blue-800">{{ $event->event_name }}</td>
                                        <td class="border-separate border border-blue-800">{{ $event->start_date }}</td>
                                        <td class="border-separate border border-blue-800">{{ $event->end_date }}</td>
                                        <td class="border-separate border border-blue-800">{{ $event->charges }}$</td>
                                        <td class="border-separate border border-blue-800">
                                            @if ($event->payment_status == 0)
                                                <span class='text-red-300'>Pending</span>
                                            @elseif($event->payment_status==1)
                                                <span class='text-green-300'>Done</span>
                                            @endif
                                        </td>
                                        <td class="border-separate border border-blue-800">
                                            @if ($event->payment_status == 0)
                                                <a href='{{ $event->checkout_page_url }}'><i
                                                        class="fas fa-receipt"></i></span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
            {{-- @if ($load_more)
                <div class="w-full text-center py-10">
                    <a href="{{ route('load.events') }}"
                        class="bg-transparent text-blue-550 uppercase px-5 py-2 border-2 border-blue-550 rounded-3xl hover:bg-blue-550 hover:text-white mx-3">Load
                        More</a>
                </div>
            @endif --}}
        </section>
    </main>
    @include('users.inc.footer')
@endsection
@section('bodyExtra')
    <script src="{{ asset('js/salvattore.min.js') }}"></script>
@endsection
