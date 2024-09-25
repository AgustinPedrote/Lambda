<footer class="bg-white shadow dark:bg-gray-900 mt-16">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="mb-6 md:mb-0">
                <a href="/" class="flex items-center">
                    <x-application-mark class="h-24 w-auto" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">
                        Lambda
                    </span>
                </a>
            </div>

            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ now()->format('Y') }} <a
                href="/" class="hover:underline">Lambda</a>. Todos los derechos reservados.</span>
    </div>
</footer>
