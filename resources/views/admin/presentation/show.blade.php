<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Apresentação - {{ $award->name }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Fullscreen API support */
        .fullscreen-container:fullscreen {
            background: #0a0a0a;
        }

        /* Custom animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out;
        }

        .animate-pulse-custom {
            animation: pulse 1s ease-in-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }
    </style>
</head>

<body class="bg-[#0a0a0a] text-[#EDEDEC] overflow-hidden relative">

    <!-- Background Image with Gradient Overlay -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-15"
             style="background-image: url('{{ asset('img/bg-caju.png') }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a]/50 via-[#0a0a0a]/70 to-[#0a0a0a]"></div>
    </div>

    <div id="presentation-container"
        class="fullscreen-container w-screen h-screen flex items-center justify-center relative z-10" x-data="presentationSlider()"
        @keydown.arrow-right.window="next()" @keydown.arrow-left.window="previous()"
        @keydown.escape.window="exitFullscreen()" @keydown.f.window="toggleFullscreen()">
        <!-- Slide Container -->
        <div class="w-full h-full flex items-center justify-center p-8 lg:p-16">

            <!-- Slide 0: COVER -->
            <template x-if="currentSlide === 0 && slides[0]?.type === 'cover'">
                <div class="text-center max-w-5xl animate-slide-in">
                    <template x-if="slides[0].data.cover_image">
                        <img :src="slides[0].data.cover_image" :alt="slides[0].data.name"
                            class="w-full max-h-96 object-cover rounded-sm mb-8 shadow-2xl">
                    </template>
                    <h1 class="text-6xl lg:text-8xl font-bold mb-4" x-text="slides[0].data.name"></h1>
                    <p class="text-3xl lg:text-4xl text-[#A1A09A] mb-2" x-text="slides[0].data.year"></p>
                    <template x-if="slides[0].data.description">
                        <p class="text-xl lg:text-2xl text-[#A1A09A] mt-8" x-text="slides[0].data.description"></p>
                    </template>
                </div>
            </template>

            <!-- CATEGORY LIST -->
            <template x-if="slides[currentSlide]?.type === 'category_list'">
                <div class="text-center max-w-5xl animate-slide-in">
                    <h1 class="text-5xl lg:text-7xl font-bold mb-12">Categorias</h1>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <template x-for="category in slides[currentSlide].data.categories" :key="category.name">
                            <div
                                class="bg-[#161615] border border-[#3E3E3A] rounded-sm p-6 hover:border-[#62605b] transition-all">
                                <h2 class="text-2xl font-medium" x-text="category.name"></h2>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- ADMIN CHOICE INTRO -->
            <template x-if="slides[currentSlide]?.type === 'admin_choice_intro'">
                <div class="text-center max-w-5xl animate-slide-in">
                    <h1 class="text-4xl lg:text-6xl font-bold mb-8"
                        x-text="slides[currentSlide].data.category_name"></h1>
                    <template x-if="slides[currentSlide].data.category_description">
                        <p class="text-xl lg:text-2xl text-[#A1A09A] mb-12"
                            x-text="slides[currentSlide].data.category_description"></p>
                    </template>
                    <p class="text-3xl lg:text-5xl text-[#A1A09A] font-medium">Escolha da diretoria</p>
                </div>
            </template>

            <!-- NOMINEES -->
            <template x-if="slides[currentSlide]?.type === 'nominees'">
                <div class="w-full max-w-7xl animate-slide-in">
                    <h1 class="text-4xl lg:text-6xl font-bold text-center mb-4"
                        x-text="slides[currentSlide].data.category_name"></h1>
                    <template x-if="slides[currentSlide].data.category_description">
                        <p class="text-xl lg:text-2xl text-[#A1A09A] text-center mb-12"
                            x-text="slides[currentSlide].data.category_description"></p>
                    </template>

                    <div class="flex flex-wrap gap-6 justify-center">
                        <template x-for="nominee in slides[currentSlide].data.nominees" :key="nominee.id">
                            <div
                                class="bg-[#161615] border-2 border-[#3E3E3A] rounded-sm overflow-hidden hover:border-[#EDEDEC] transition-all w-[150px]">

                                <template x-if="nominee.photo">
                                    <img :src="nominee.photo" :alt="nominee.name"
                                        class="w-full aspect-[3/4] object-cover">
                                </template>

                                <template x-if="!nominee.photo">
                                    <div class="w-full aspect-[3/4] bg-[#3E3E3A] flex items-center justify-center">
                                        <span class="text-[#A1A09A] text-sm">Sem Foto</span>
                                    </div>
                                </template>

                                <div class="p-3">
                                    <h3 class="text-sm font-medium mb-1" x-text="nominee.name"></h3>
                                    <template x-if="nominee.description">
                                        <p class="text-xs text-[#A1A09A]" x-text="nominee.description"></p>
                                    </template>
                                </div>

                            </div>
                        </template>
                    </div>


                </div>
            </template>

            <!-- SUSPENSE -->
            <template x-if="slides[currentSlide]?.type === 'suspense'">
                <div class="text-center animate-fade-in">
                    <h2 class="text-3xl lg:text-5xl font-medium mb-12 text-[#A1A09A]"
                        x-text="slides[currentSlide].data.category_name"></h2>
                    <div class="text-9xl lg:text-[200px] font-bold animate-pulse-custom" x-text="countdown"></div>
                    <p class="text-2xl lg:text-4xl text-[#A1A09A] mt-12">E o vencedor é...</p>
                </div>
            </template>

            <!-- WINNER -->
            <template x-if="slides[currentSlide]?.type === 'winner'">
                <div class="text-center max-w-4xl animate-slide-in">
                    <h2 class="text-3xl lg:text-5xl font-medium mb-8 text-[#A1A09A]"
                        x-text="slides[currentSlide].data.category_name"></h2>

                    <template x-if="slides[currentSlide].data.winner">
                        <div
                            class="bg-gradient-to-br from-[#1b1b18] to-[#161615] border-4 border-[#EDEDEC] rounded-sm overflow-hidden shadow-2xl">
                            <template x-if="slides[currentSlide].data.winner.photo">
                                <img :src="slides[currentSlide].data.winner.photo"
                                    :alt="slides[currentSlide].data.winner.name"
                                    class="w-full aspect-[16/9] object-cover">
                            </template>
                            <div class="p-12">
                                <h1 class="text-5xl lg:text-7xl font-bold mb-4"
                                    x-text="slides[currentSlide].data.winner.name"></h1>
                                <template x-if="slides[currentSlide].data.winner.description">
                                    <p class="text-2xl text-[#A1A09A] mb-4"
                                        x-text="slides[currentSlide].data.winner.description"></p>
                                </template>
                                <template
                                    x-if="slides[currentSlide].data.category_type === 'public_vote' && slides[currentSlide].data.winner.votes_count > 0">
                                    <p class="text-xl text-[#A1A09A]">
                                        <span x-text="slides[currentSlide].data.winner.votes_count"></span> votos
                                    </p>
                                </template>
                            </div>
                        </div>
                    </template>

                    <template x-if="!slides[currentSlide].data.winner">
                        <div class="text-4xl text-[#A1A09A]">Nenhum vencedor definido</div>
                    </template>
                </div>
            </template>

            <!-- THANK YOU -->
            <template x-if="slides[currentSlide]?.type === 'thank_you'">
                <div class="text-center animate-fade-in">
                    <h1 class="text-6xl lg:text-8xl font-bold mb-8">Obrigado!</h1>
                    <p class="text-3xl lg:text-5xl text-[#A1A09A] mb-4" x-text="slides[currentSlide].data.award_name">
                    </p>
                    <p class="text-2xl lg:text-4xl text-[#A1A09A]" x-text="slides[currentSlide].data.year"></p>
                </div>
            </template>

        </div>

        <!-- Controls -->
        <div class="absolute bottom-8 left-0 right-0 flex items-center justify-center gap-6 z-50">
            <!-- Previous -->
            <button @click="previous()" :disabled="currentSlide === 0"
                :class="currentSlide === 0 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-[#3E3E3A]'"
                class="bg-[#161615] border border-[#3E3E3A] text-[#EDEDEC] rounded-full p-4 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Counter -->
            <div class="bg-[#161615] border border-[#3E3E3A] px-6 py-3 rounded-full">
                <span x-text="currentSlide + 1"></span> / <span x-text="slides.length"></span>
            </div>

            <!-- Next -->
            <button @click="next()" :disabled="currentSlide === slides.length - 1"
                :class="currentSlide === slides.length - 1 ? 'opacity-30 cursor-not-allowed' : 'hover:bg-[#3E3E3A]'"
                class="bg-[#161615] border border-[#3E3E3A] text-[#EDEDEC] rounded-full p-4 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Fullscreen -->
            <button @click="toggleFullscreen()"
                class="bg-[#161615] border border-[#3E3E3A] text-[#EDEDEC] hover:bg-[#3E3E3A] rounded-full p-4 transition-all ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                </svg>
            </button>

            <!-- Exit -->
            {{-- <a
                href="{{ route('filament.admin.resources.awards.awards.index') }}"
                class="bg-[#F53003] hover:bg-[#d32803] text-white rounded-full px-6 py-3 font-medium transition-all ml-4"
            >
                Sair
            </a> --}}
        </div>

        <!-- Keyboard Shortcuts Info -->
        <div
            class="absolute top-8 right-8 bg-[#161615] border border-[#3E3E3A] rounded-sm px-4 py-3 text-sm text-[#A1A09A]">
            <div>← → : Navegar</div>
            <div>F : Fullscreen</div>
            <div>ESC : Sair Fullscreen</div>
        </div>
    </div>

    <script>
        function presentationSlider() {
            return {
                slides: @json($slides),
                currentSlide: 0,
                countdown: 3,
                countdownInterval: null,

                init() {
                    // Watch for suspense slides
                    this.$watch('currentSlide', (value) => {
                        if (this.slides[value]?.type === 'suspense') {
                            this.startCountdown();
                        } else {
                            this.stopCountdown();
                        }
                    });
                },

                next() {
                    if (this.currentSlide < this.slides.length - 1) {
                        this.currentSlide++;
                    }
                },

                previous() {
                    if (this.currentSlide > 0) {
                        this.currentSlide--;
                    }
                },

                startCountdown() {
                    this.countdown = 3;
                    this.countdownInterval = setInterval(() => {
                        this.countdown--;
                        if (this.countdown <= 0) {
                            this.stopCountdown();
                            // Auto-advance to winner slide
                            setTimeout(() => this.next(), 500);
                        }
                    }, 1000);
                },

                stopCountdown() {
                    if (this.countdownInterval) {
                        clearInterval(this.countdownInterval);
                        this.countdownInterval = null;
                    }
                },

                toggleFullscreen() {
                    const container = document.getElementById('presentation-container');

                    if (!document.fullscreenElement) {
                        container.requestFullscreen().catch(err => {
                            console.error('Erro ao entrar em fullscreen:', err);
                        });
                    } else {
                        document.exitFullscreen();
                    }
                },

                exitFullscreen() {
                    if (document.fullscreenElement) {
                        document.exitFullscreen();
                    }
                }
            }
        }
    </script>
</body>

</html>
