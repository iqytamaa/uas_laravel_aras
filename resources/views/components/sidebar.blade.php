<aside id="default-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">

            <li>
                <div class="flex items-center font-bold bg-gray-900 text-gray-200 p-2 rounded-lg group">
                    <span class="ms-3"> Metode ARAS</span>
                </div>
            </li>

            <li>
                <a href="/home"
                    class="flex items-center font-bold {{ request()->is('home') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Home</span>
                </a>
            </li>

            <li>
                <a href="{{ url('/criteria') }}"
                class="flex items-center font-bold {{ request()->is('/') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Kriteria</span>
                </a>
            </li>

            <li>
                <a href="/alternative"
                    class="flex items-center font-bold {{ request()->is('alternative') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Alternatif</span>
                </a>
            </li>

            <li>
                <a href="/evaluation"
                    class="flex items-center font-bold {{ request()->is('evaluation') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Evaluasi</span>
                </a>
            </li>

            <li>
                <a href="/calculate"
                    class="flex items-center font-bold {{ request()->is('calculate') ? 'bg-gray-400 text-gray-900' : 'text-gray-200 bg-gray-800 hover:bg-gray-400 hover:text-gray-900' }} p-2 rounded-lg group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path
                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                        <path
                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                    </svg>
                    <span class="ms-3">Hasil Perhitungan</span>
                </a>
            </li>

        </ul>
    </div>
</aside>

<div class="p-4 sm:ml-64">
    @if (session('success'))
        <div class="bg-green-600 text-white font-bold p-4 mb-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{ $slot }}
</div>
