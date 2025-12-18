<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col relative">

    <!-- Background Image with Gradient Overlay -->
    <div class="hidden dark:block fixed inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-15"
             style="background-image: url('{{ asset('img/bg-caju.png') }}');">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#0a0a0a]/50 via-[#0a0a0a]/70 to-[#0a0a0a]"></div>
    </div>

    <!-- Content Wrapper -->
    <div class="relative z-10 flex flex-col items-center w-full">

    <header class="w-full lg:max-w-6xl max-w-[335px] text-sm mb-6">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Olá, {{ Auth::user()->name }}
                    </span>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    <main class="w-full max-w-6xl">
        {{-- Título da Premiação --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                {{ $award->name }} - {{ $award->year }}
            </h1>
            @if ($award->description)
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    {{ $award->description }}
                </p>
            @endif
        </div>

        {{-- Container de Mensagens --}}
        <div id="message-container" class="hidden mb-6 max-w-2xl mx-auto"></div>

        {{-- Loop por Categorias --}}
        @foreach ($award->categories as $category)
            <div class="mb-12 bg-white dark:bg-[#161615] rounded-sm p-6 border border-[#e3e3e0] dark:border-[#3E3E3A]">
                {{-- Header da Categoria --}}
                <div class="mb-6">
                    <h2 class="text-2xl font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        {{ $category->name }}

                        @if (isset($userVotes[$category->id]))
                            <span
                                class="ml-3 inline-block px-3 py-1 rounded-full text-sm bg-[#dbdbd7] dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]">
                                ✓ Você já votou
                            </span>
                        @endif
                    </h2>
                    @if ($category->description)
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">{{ $category->description }}</p>
                    @endif
                </div>

                {{-- Grid de Indicados --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    @foreach ($category->nominees as $nominee)
                            <div
                                class="nominee-card border-2 rounded-sm overflow-hidden transition-all
                                        {{ isset($userVotes[$category->id]) && $userVotes[$category->id]->nominee_id == $nominee->id
                        ? 'border-[#1b1b18] dark:border-[#EDEDEC] bg-[#dbdbd7] dark:bg-[#3E3E3A]'
                        : 'border-[#e3e3e0] dark:border-[#3E3E3A] hover:border-[#1b1b18] dark:hover:border-[#EDEDEC]' }}">

                                {{-- Foto do Indicado --}}
                                @if ($nominee->photo)
                                    <img src="{{ asset('uploads/' . $nominee->photo) }}" alt="{{ $nominee->name }}"
                                        class="w-full aspect-[335/376] object-cover">
                                @else
                                    <img src="https://placehold.co/600x400" alt="Sem Foto" class="w-full aspect-[335/376] object-cover">
                                @endif

                                {{-- Informações do Indicado --}}
                                <div class="p-6">
                                    <h3 class="text-[13px] leading-[20px] font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                                        {{ $nominee->name }}
                                    </h3>

                                    @if ($nominee->description)
                                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-3">
                                            {{ Str::limit($nominee->description, 80) }}
                                        </p>
                                    @endif

                                    {{-- Botão de Votação --}}
                                    @auth
                                        @if (isset($userVotes[$category->id]))
                                            @if ($userVotes[$category->id]->nominee_id == $nominee->id)
                                                <button onclick="removeVote({{ $award->id }}, {{ $category->id }})"
                                                    class="remove-vote-button w-full px-5 py-2 bg-[#F53003] dark:bg-[#FF4433] text-white rounded-full font-medium hover:bg-[#d32803] dark:hover:bg-[#e63d2e] transition-all">
                                                    Remover Voto
                                                </button>
                                            @else
                                                <button disabled
                                                    class="w-full px-5 py-2 bg-[#dbdbd7] dark:bg-[#3E3E3A] text-[#706f6c] dark:text-[#A1A09A] rounded-full font-medium">
                                                   Apenas um voto por categoria
                                                </button>
                                            @endif
                                        @else
                                            <button onclick="vote({{ $award->id }}, {{ $category->id }}, {{ $nominee->id }})"
                                                class="vote-button w-full px-5 py-2 bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1C1C1A] rounded-full font-medium hover:bg-black dark:hover:bg-white transition-all">
                                                Votar
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block w-full px-5 py-2 text-center bg-[#dbdbd7] dark:bg-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] rounded-full font-medium hover:bg-[#1b1b18] hover:text-white dark:hover:bg-[#EDEDEC] dark:hover:text-[#1C1C1A] transition-all">
                                            Faça login para votar
                                        </a>
                                    @endauth
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Botão Voltar --}}
        <div class="text-center mt-8">
            <a href="{{ url('/') }}"
                class="inline-block px-5 py-2 border border-[#19140035] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] rounded-sm font-medium hover:border-[#1915014a] dark:hover:border-[#62605b] transition-all">
                ← Voltar para Home
            </a>
        </div>
    </main>

    {{-- JavaScript para Votação AJAX --}}
    @auth
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                '{{ csrf_token() }}';

            function vote(awardId, categoryId, nomineeId) {
                const categoryButtons = document.querySelectorAll(`button[onclick*="vote(${awardId}, ${categoryId}"]`);
                categoryButtons.forEach(btn => {
                    btn.disabled = true;
                    btn.textContent = 'Votando...';
                });

                fetch(`/voting/${awardId}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        category_id: categoryId,
                        nominee_id: nomineeId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMessage(data.message, 'success');
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showMessage(data.message, 'error');
                            categoryButtons.forEach(btn => {
                                btn.disabled = false;
                                btn.textContent = 'Votar';
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        showMessage('Erro ao processar voto. Tente novamente.', 'error');
                        categoryButtons.forEach(btn => {
                            btn.disabled = false;
                            btn.textContent = 'Votar';
                        });
                    });
            }

            function removeVote(awardId, categoryId) {
                const categoryButtons = document.querySelectorAll('.remove-vote-button');
                categoryButtons.forEach(btn => {
                    if (btn.onclick && btn.onclick.toString().includes(`removeVote(${awardId}, ${categoryId}`)) {
                        btn.disabled = true;
                        btn.textContent = 'Removendo...';
                    }
                });

                fetch(`/voting/${awardId}/vote`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        category_id: categoryId
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showMessage(data.message, 'success');
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showMessage(data.message, 'error');
                            categoryButtons.forEach(btn => {
                                if (btn.onclick && btn.onclick.toString().includes(
                                    `removeVote(${awardId}, ${categoryId}`)) {
                                    btn.disabled = false;
                                    btn.textContent = 'Remover Voto';
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        showMessage('Erro ao remover voto. Tente novamente.', 'error');
                        categoryButtons.forEach(btn => {
                            if (btn.onclick && btn.onclick.toString().includes(
                                `removeVote(${awardId}, ${categoryId}`)) {
                                btn.disabled = false;
                                btn.textContent = 'Remover Voto';
                            }
                        });
                    });
            }

            function showMessage(message, type) {
                const container = document.getElementById('message-container');
                container.className = `mb-6 max-w-2xl mx-auto p-4 rounded-sm border ${type === 'success'
                        ? 'bg-[#dbdbd7] dark:bg-[#3E3E3A] border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC]'
                        : 'bg-[#fff2f2] dark:bg-[#1D0002] border-[#e3e3e0] dark:border-[#3E3E3A] text-[#F53003] dark:text-[#FF4433]'
                    }`;
                container.textContent = message;
                container.classList.remove('hidden');
                setTimeout(() => container.classList.add('hidden'), 5000);
            }
        </script>
    @endauth

    </div>
    <!-- End Content Wrapper -->

</body>

</html>
