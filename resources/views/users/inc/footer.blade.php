<footer>
    <div class="bg-gradient-to-tr from-blue-250 to-blue-550 pt-8">
        <div class="flex flex-wrap overflow-hidden max-w-7xl mx-auto pb-6">
            <div class="w-full md:w-1/2 lg:w-4/12 px-4">
                <a href="#">
                    <img src="{{asset('assets/logo.png')}}" alt="">
                </a>
                <p class="text-gray-300 pt-5">
                    {{ (App\Models\Shortcode::where('key','dapfooter')->first())->content}}
                </p>
            </div>
            <div class="w-full md:w-1/2 lg:w-2/12 text-white lg:px-8">
                <h3 class="font-bold text-lg">Company</h3>
                <ul class="pt-4 text-gray-300">
                    <li class="py-1"><a href="#" class="hover:text-white">Features</a></li>
                    <li class="py-1"><a href="{{route('pricing')}}" class="hover:text-white">Pricing</a></li>
                    <li class="py-1"><a href="#" class="hover:text-white">Our Work</a></li>
                    <li class="py-1"><a href="#" class="hover:text-white">Developers</a></li>
                    <li class="py-1"><a href="{{route('about.us')}}" class="hover:text-white">About Us</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/2 lg:w-2/12 text-white lg:px-8">
                <h3 class="font-bold text-lg">Support</h3>
                <ul class="pt-4 text-gray-300">
                    <li class="py-1"><a href="#" class="hover:text-white">Help Center</a></li>
                    <li class="py-1"><a href="#" class="hover:text-white">Contact Support</a></li>
                    <li class="py-1"><a href="#" class="hover:text-white">Report Abuse</a></li>
                </ul>
            </div>
            <div class="w-full md:w-1/2 lg:w-4/12 text-white px-4">
                <h3 class="font-bold text-lg">Contact Us</h3>
                <ul class="pt-4 text-gray-300">
                    <li class="py-1"><a href="tel:3045015100" class="hover:text-white"><i class="fas fa-phone-alt pr-1"></i> (304) 501-5100</a></li>
                    <li class="py-1"><a href="mailto:admin@dapsocially.com" class="hover:text-white"><i class="fas fa-envelope pr-1"></i> admin@dapsocially.com</a></li>
                    <li class="py-1"><a href="#" class="hover:text-white"><i class="fas fa-map-marked-alt pr-1"></i> 11 Brady Circle, Ste.300 St.Louis, MO 63114</a></li>
                </ul>
                <div class="pt-4">
                    <a href="#" class="mx-1"><i class="fab fa-facebook-f social-link"></i></a>
                    <a href="#" class="mx-1"><i class="fab fa-twitter social-link"></i></a>
                    <a href="#" class="mx-1"><i class="fab fa-instagram social-link"></i></a>
                </div>
            </div>
        </div>
        <hr class="w-4/5 mx-auto border-gray-400">
        <div class="max-w-6xl mx-auto py-2 text-gray-300 flex justify-between">
            <p>Copyright © 2021. All rights reserved.</p>
            <div>
                <a href="#" class="mx-2 hover:text-white">Privacy Policy</a>
                <a href="#" class="mx-2 hover:text-white">Terms of Services</a>
            </div>
        </div>
    </div>
</footer>
