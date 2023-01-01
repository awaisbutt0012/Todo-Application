@if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <!-- <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline ">Dashboard</a> -->
                        <a href="{{ route('logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline ml-2">Logout</a>

                        @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline ml-2">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline ml-2">Register</a>
                        @endif
                    @endauth
                </div>
@endif