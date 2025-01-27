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
                    <nav class="flex space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-white">Дашборд</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">Вхід</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-gray-300 hover:text-white">Реєстрація</a>
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
                    <p class="mt-4 text-gray-600 dark:text-gray-300">
                        Сервіс дозволяє стежити за змінами цін на оголошеннях OLX. Ви можете підписатися на цікаве оголошення та отримувати сповіщення на електронну пошту, якщо ціна зміниться.
                    </p>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Як працює сервіс</h2>
                    <ul class="mt-4 list-disc list-inside text-gray-600 dark:text-gray-300">
                        <li>Введіть посилання на оголошення OLX та ваш email.</li>
                        <li>Сервіс перевіряє ціну оголошення та надсилає повідомлення, якщо ціна зміниться.</li>
                        <li>Кілька користувачів можуть стежити за одним оголошенням, і сервіс уникатиме зайвих перевірок.</li>
                    </ul>
                </section>

                <section class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Особливості</h2>
                    <ul class="mt-4 list-disc list-inside text-gray-600 dark:text-gray-300">
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
                        <a href="{{ url('/dashboard') }}" class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded shadow hover:bg-indigo-700">Перейти в Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="mt-4 inline-block bg-indigo-600 text-black px-6 py-2 rounded shadow hover:bg-indigo-700">Зареєструватися</a>
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
