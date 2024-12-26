<x-app-layout>

    <figure class="mb-20">
        <img class="w-full aspect-[3/1] object-cover object-center" src="{{ asset('img/welcome/portada.jpg') }}"
            alt="">
    </figure>

    <section>
        <h1 class="text-2xl font-semibold text-center mb-8">
            CONTENIDO
        </h1>

        <ul class="grid grid-cols-4 gap-6 mx-6">
            {{-- Cursos online --}}
            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg" src="https://cdn.pixabay.com/photo/2019/05/16/20/15/online-4208112_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Cursos online
                    </a>
                </h1>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem modi quia deserunt neque. Beatae ab et
                    sunt libero quas laudantium non quis doloribus culpa?
                </p>
            </li>

            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg" src="https://cdn.pixabay.com/photo/2015/07/17/22/43/student-849822_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Diseño web
                    </a>
                </h1>

                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Obcaecati quidem expedita modi molestias
                    asperiores vero eveniet et at, rerum ratione ad.
                </p>
            </li>

            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg" src="https://cdn.pixabay.com/photo/2020/07/08/04/12/work-5382501_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Asesorías
                    </a>
                </h1>

                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem modi quia deserunt neque. Beatae ab et
                    sunt libero.
                </p>
            </li>

            <li>
                <a href="">
                    <img class="aspect-video object-cover object-center rounded-lg" src="https://cdn.pixabay.com/photo/2015/03/22/15/26/blog-684748_1280.jpg" alt="">
                </a>

                <h1 class="text-xl text-center font-semibold mb-2 mt-4">
                    <a href="">
                        Blog
                    </a>
                </h1>

                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Similique vel, nam mollitia molestiae
                    dolorem accusamus necessitatibus eligendi cum.
                </p>
            </li>
        </ul>
    </section>

</x-app-layout>
