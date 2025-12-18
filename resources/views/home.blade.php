<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen relative">

    <!-- Background Image with Gradient Overlay -->
    <div class="hidden dark:block fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-15"
            style="background-image: url('{{ asset('img/bg-caju.png') }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a]/50 via-[#0a0a0a]/70 to-[#0a0a0a]"></div>
    </div>

    <!-- Content Wrapper -->
    <div class="relative z-10">

        <!-- Header -->
        <header
            class="sticky top-0 z-50 bg-[#FDFDFC]/80 dark:bg-[#0a0a0a]/80 backdrop-blur-md border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                @if (Route::has('login'))
                    <nav class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo CajuAwards" class="h-8 w-auto">
                            <span class="font-semibold text-lg">CajuAwards</span>
                        </div>

                        <div class="flex items-center gap-3">
                            @auth
                                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    Olá, {{ Auth::user()->name }}
                                </span>
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-block px-4 py-2 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-lg text-sm transition-all">
                                    Log in
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="inline-block px-4 py-2 dark:text-[#EDEDEC] border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-lg text-sm transition-all">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </nav>
                @endif
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="text-center mb-12 lg:mb-16">
                <h1 class="text-4xl lg:text-6xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                    Premiações Abertas
                </h1>
                <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] max-w-2xl mx-auto">
                    Vote nas suas categorias favoritas e ajude a escolher os vencedores
                </p>
            </div>

            @if(count($dados) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($dados as $award)
                        <article
                            class="group bg-white dark:bg-[#161615] rounded-xl overflow-hidden border border-[#e3e3e0] dark:border-[#3E3E3A] hover:border-[#1b1b18] dark:hover:border-[#EDEDEC] transition-all duration-300 hover:shadow-xl">

                            <div class="relative aspect-[16/9] overflow-hidden bg-[#e3e3e0] dark:bg-[#3E3E3A]">
                                <img class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                    src="{{ $award->cover_image ? asset('uploads/' . $award->cover_image) : 'https://placehold.co/800x450/e3e3e0/706f6c?text=' . urlencode($award->name) }}"
                                    alt="{{ $award->name }}">

                                <div
                                    class="absolute top-4 right-4 bg-[#1b1b18]/90 dark:bg-[#EDEDEC]/90 backdrop-blur-sm text-white dark:text-[#1b1b18] px-3 py-1.5 rounded-full text-sm font-medium">
                                    {{ $award->year ?? 'Atual' }}
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                <div>
                                    <h2
                                        class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2 group-hover:text-[#706f6c] dark:group-hover:text-[#A1A09A] transition-colors">
                                        {{ $award->name }}
                                    </h2>

                                    @if($award->description)
                                        <p class="text-[#706f6c] dark:text-[#A1A09A] line-clamp-3">
                                            {{ $award->description }}
                                        </p>
                                    @endif
                                </div>

                                @if(isset($award->categories_count))
                                    <div class="flex items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span>{{ $award->categories_count }} categorias</span>
                                    </div>
                                @endif

                                <a href="{{ route('votingSession', ['award_id' => $award->id]) }}"
                                    class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-orange-600 hover:to-yellow-600 text-white rounded-lg font-medium transition-all duration-300 group/button">

                                    <span>Votar Agora</span>
                                    <svg class="w-4 h-4 transition-transform group-hover/button:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#e3e3e0] dark:bg-[#3E3E3A] mb-4">
                        <svg class="w-8 h-8 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Nenhuma premiação disponível
                    </h3>
                    <p class="text-[#706f6c] dark:text-[#A1A09A]">
                        No momento não há premiações abertas para votação.
                    </p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <footer class="mt-auto border-t border-[#e3e3e0] dark:border-[#3E3E3A] py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    © {{ date('Y') }} Sistema de Votação. Todos os direitos reservados | Made by <span
                        class="text-[#fbb232]">Team CajuDev</span>
                </p>
            </div>
        </footer>

    </div>
    <!-- End Content Wrapper -->

</body>

</html