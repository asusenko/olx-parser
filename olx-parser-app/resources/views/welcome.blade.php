<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OLX Price Tracker</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased dark:bg-gray-900 dark:text-gray-200">
    <div class="min-h-screen flex flex-col">
        <header class="bg-gray-800 text-white py-4 shadow-lg">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold">OLX Price Tracker</h1>
                @if (Route::has('login'))
                <nav class="-mx-3 flex flex-1 justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Дашборд
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Логін
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-white/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Зареєструватися
                            </a>
                        @endif
                    @endauth
                </nav>

                @endif
            </div>
        </header>

        <main class="flex-grow bg-gray-100 dark:bg-gray-900">
            <div class="container mx-auto py-12">
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Про сервіс</h2>
                    <p class="mb-4 text-gray-600 dark:text-gray-300">
                        Сервіс дозволяє стежити за змінами цін на оголошеннях OLX. Ви можете підписатися на цікаве оголошення та отримувати сповіщення на електронну пошту, якщо ціна зміниться.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Як працює сервіс</h2>
                    <ul class="mb-4 list-disc list-inside text-gray-600 dark:text-gray-300">
                        <li>Введіть посилання на оголошення OLX та ваш email.</li>
                        <li>Сервіс перевіряє ціну оголошення та надсилає повідомлення, якщо ціна зміниться.</li>
                        <li>Кілька користувачів можуть стежити за одним оголошенням, і сервіс уникатиме зайвих перевірок.</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Особливості</h2>
                    <ul class="mb-4 list-disc list-inside text-gray-600 dark:text-gray-300">
                        <li>Можливість підписки на зміни ціни через HTTP-метод.</li>
                        <li>Перевірка цін та надсилання сповіщень.</li>
                        <li>Docker-контейнер для запуску сервісу.</li>
                        <li>Підтвердження email користувачів.</li>
                        <li>Тести з покриттям понад 70%.</li>
                    </ul>
                </section>

                <section class="text-center">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Приєднуйтесь до сервісу вже зараз!</h3>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="mt-4 inline-block bg-indigo-600 text-green px-6 py-2 rounded shadow hover:bg-indigo-700">Перейти в Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="mt-4 inline-block bg-indigo-600 text-green px-6 py-2 rounded shadow hover:bg-indigo-700">Зареєструватися</a>
                    @endauth
                </section>
            </div>
        </main>

        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto text-center">
                <p>&copy; {{ date('Y') }} OLX Price Tracker. Усі права захищені.</p>
            </div>
        </footer>
    </div>
</body>
</html>
