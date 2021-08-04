<footer>
    <div class="bg-gradient-to-tr from-blue-250 to-blue-550 pt-8">
        <div class="flex flex-wrap overflow-hidden max-w-7xl mx-auto pb-6 px-5">
            <div class="w-full lg:w-4/12 text-center lg:text-left">
                <a href="{{route('homepage')}}">
                    <img src="{{asset('assets/logo.png')}}" class="mx-auto" alt="">
                </a>
                <p class="text-gray-300 pt-2 lg:pt-5">
                    {{ (App\Models\Shortcode::where('key','dapfooter')->first())->content}}
                </p>
            </div>
            <div class="w-full md:w-1/3 lg:w-2/12 text-white lg:px-8 pt-5 lg:pt-0">
                <h3 class="font-bold text-lg text-center md:text-left">Company</h3>
                <ul class="pt-4 text-gray-300 text-center md:text-left">
                    <li class="py-1"><a href="{{route('features')}}" class="hover:text-white">Features</a></li>
                    <li class="py-1"><a href="{{route('pricing')}}" class="hover:text-white">Pricing</a></li>
                    <li class="py-1"><a href="{{route('our.work')}}" class="hover:text-white">Our Work</a></li>
                    <li class="py-1"><a href="{{route('about.us')}}" class="hover:text-white">About Us</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/3 lg:w-2/12 text-white lg:px-8 pt-5 lg:pt-0">
                <h3 class="font-bold text-lg text-center md:text-left">Support</h3>
                <ul class="pt-4 text-gray-300 text-center md:text-left">
                    <li class="py-1"><a href="{{route('help.center')}}" class="hover:text-white">Help Center</a></li>
                    <li class="py-1"><a href="{{route('contact.support')}}" class="hover:text-white">Contact Support</a></li>
                    <li class="py-1"><a href="{{route('reportabuse')}}" class="hover:text-white">Report Abuse</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/3 lg:w-4/12 text-white pt-5 lg:pt-0">
                <h3 class="font-bold text-lg text-center md:text-left">Contact Us</h3>
                <ul class="pt-4 text-gray-300 text-center md:text-left">
                    <li class="py-1"><a href="tel:3145015100" class="hover:text-white"><i class="fas fa-phone-alt pr-1"></i> {{ (App\Models\Shortcode::where('key','phone')->first())->content}}</a></li>
                    <li class="py-1"><a href="mailto:admin@dapsocially.com" class="hover:text-white"><i class="fas fa-envelope pr-1"></i> {{ (App\Models\Shortcode::where('key','email')->first())->content}}</a></li>
                    <li class="py-1"><a href="#" class="hover:text-white"><i class="fas fa-map-marked-alt pr-1"></i> {{ (App\Models\Shortcode::where('key','phone')->first())->content}}</a></li>
                </ul>
                <div class="pt-4 text-center md:text-left">
                    <a href="{{ (App\Models\Shortcode::where('key','dapfb')->first())->content}}" class="mx-1"><i class="fab fa-facebook-f social-link"></i></a>
                    <a href="{{ (App\Models\Shortcode::where('key','daptw')->first())->content}}" class="mx-1"><i class="fab fa-twitter social-link"></i></a>
                    <a href="{{ (App\Models\Shortcode::where('key','dapin')->first())->content}}" class="mx-1"><i class="fab fa-instagram social-link"></i></a>
                </div>
            </div>
        </div>
        <hr class="w-4/5 mx-auto border-gray-400">
        <div class="max-w-6xl mx-auto py-2 px-5 text-gray-300 flex flex-col items-center md:flex-row justify-between">
            <p>Copyright © 2021. All rights reserved.</p>
            <div>
                <a href="{{route('privacypolicy')}}" class="mx-2 hover:text-white">Privacy Policy</a>
                <a href="{{route('termsofservices')}}" class="mx-2 hover:text-white">Terms of Services</a>
            </div>
        </div>
    </div>
</footer>