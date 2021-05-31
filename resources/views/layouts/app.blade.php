<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Video Games App</title>
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://kit.fontawesome.com/4a6cef6c86.js" crossorigin="anonymous"></script>
    <livewire:styles />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="bg-gray-900 text-white">
    <header class="border-b border-gray-800">
        <nav class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 py-6">
            <div class="flex flex-col md:flex-row  items-center">
                <a href="/">
                <img class="w-16 flex-none" src="img/playstationlogo.png" alt=""></a>
                <ul class="flex mt-4 md:mt-0  ml-0 md:ml-16 space-x-8">
                    <li><a href="#" class="hover:text-gray-400" >Games</a></li>
                    <li><a href="#" class="hover:text-gray-400" >Rewiews</a></li>
                    <li><a href="#" class="hover:text-gray-400" >Coming Soon</a></li>
                </ul>
            </div>
            <div class="flex items-center mt-4 md:mt-0">
                <livewire:search-dropdown />
                <div class="ml-6 flex-none">
                    <a href="#"><img src="img/playstationlogo.png" alt="" class="rouned-full w-8"></a>
                </div>
            </div>
        </nav>
    </header>
  <main class="py-8">
        @yield('content')   
  </main>
  <footer class="border-t border-gray-800">
    <div class="container mx-auto px-4 py-6">
        Powered by <a href="#" class="underline hover:text-gray-400">IGDB API</a>
    </div>
  </footer>
  <livewire:scripts />
  <script src="/js/app.js"></script>

  @stack('scripts')
</body>
</html>