<!DOCTYPE html>
<html lang="pt-br" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 min-h-screen flex items-center justify-center p-4">
    <div class="bg-gray-900 rounded-xl shadow-xl ring-1 ring-white/10 w-full max-w-md p-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white tracking-tight">Criar conta</h2>
            <p class="text-sm text-gray-400 mt-2">Preencha os dados para começar</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-lg mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="/register" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-white mb-2">
                    Nome
                    <span class="text-red-400">*</span>
                </label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    required
                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-75 outline-none hover:bg-white/10"
                    placeholder="Seu nome completo"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-2">
                    CPF
                    <span class="text-red-400">*</span>
                </label>
                <input 
                    type="text" 
                    name="cpf" 
                    id="cpf"
                    value="{{ old('cpf') }}"
                    required
                    maxlength="14"
                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-75 outline-none hover:bg-white/10"
                    placeholder="000.000.000-00"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-2">
                    Email
                    <span class="text-red-400">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-75 outline-none hover:bg-white/10"
                    placeholder="seu@email.com"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-white mb-2">
                    Senha
                    <span class="text-red-400">*</span>
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-white text-sm placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-75 outline-none hover:bg-white/10"
                    placeholder="••••••••"
                >
            </div>

            <button 
                type="submit"
                class="w-full bg-amber-500 text-gray-950 font-semibold py-2.5 px-4 rounded-lg hover:bg-amber-400 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-75 shadow-lg text-sm"
            >
                Registrar
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">
                Já tenho conta? 
                <a href="/login" class="text-amber-500 hover:text-amber-400 font-medium hover:underline transition duration-75">
                    Fazer login
                </a>
            </p>
        </div>
    </div>

    <script>
        // Máscara de CPF
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            
            if (cpfInput) {
                cpfInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    
                    if (value.length <= 11) {
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                        e.target.value = value;
                    }
                });
            }
        });
    </script>
</body>
</html>