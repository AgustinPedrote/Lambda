<div class="space-y-3">

    {{-- Video --}}
    <div>
        @if ($editVideo)
            <div x-data="{
                platform: @entangle('platform'),
            }">
                <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                    <div class="md:flex md:items-center md:space-x-4 space-y-4 md:space-y-0">
                        <button type="button"
                            class="inline-flex flex-col justify-center items-center w-full md:w-20 md:h-24 border rounded py-2"
                            :class="platform == 1 ? 'border-indigo-500 text-indigo-500' : 'border-gray-300'"
                            x-on:click="platform = 1">

                            <i class="fas fa-video text-2xl"></i>

                            <span class="text-sm mt-2">
                                Video
                            </span>
                        </button>

                        <button type="button"
                            class="inline-flex flex-col justify-center items-center w-full md:w-20 md:h-24 border rounded py-2"
                            :class="platform == 2 ? 'border-indigo-500 text-indigo-500' : 'border-gray-300'"
                            x-on:click="platform = 2">

                            <i class="fab fa-youtube text-2xl"></i>

                            <span class="text-sm mt-2">
                                Youtube
                            </span>
                        </button>
                    </div>

                    <p>
                        Primero debes elegir una plataforma para subir tu contenido
                    </p>
                </div>

                <div> {{-- Se crea el div para que alpine lo modifique con @entagle y asi evitamos un error --}}
                    <div class="mt-2" x-show="platform == 1" x-cloak> {{-- x-cloak evita parpadeo --}}
                        <x-label>
                            Video
                        </x-label>

                        {{-- Componente livewire para seleccionar archivos --}}
                        <x-progress-indicators wire:model="video" />
                    </div>

                    <div class="mt-2" x-show="platform == 2" x-cloak>
                        <x-label>
                            Video
                        </x-label>

                        <x-input wire:model="url" placeholder="Ingrese la URL de Youtube" class="w-full" />
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <x-danger-button wire:click="$set('editVideo', false)">
                        Cancelar
                    </x-danger-button>

                    <x-button wire:click="saveVideo">
                        Actualizar
                    </x-button>
                </div>
            </div>
        @else
            <div>
                <h2 class="font-semibold text-lg mb-1">
                    Video del curso
                </h2>

                @if ($lesson->is_processed)
                    <div>
                        <div class="md:flex md:items-center mb-2">
                            <img class="w-full md:w-20 aspect-video object-cover object-center"
                                src="{{ $lesson->image }}" alt="{{ $lesson->name }}">

                            <p class="text-sm truncate me:flex-1 md:ml-4">
                                {{ $lesson->video_original_name }}
                            </p>
                        </div>

                        <x-button wire:click="$set('editVideo', true)"> {{-- Con este método decimos que queremos cambiar editVideo --}}
                            Video
                        </x-button>
                    </div>
                @else
                    <div>
                        <table class="table-auto w-full">
                            <thead class="border-b border-gray-200">
                                <tr class="font-bold">
                                    <td class="px-4 py-2">
                                        Nombre del archivo
                                    </td>

                                    <td class="px-4 py-2">
                                        Tipo
                                    </td>

                                    <td class="px-4 py-2">
                                        Estado
                                    </td>

                                    <td class="px-4 py-2">
                                        Fecha
                                    </td>
                                </tr>
                            </thead>
                            <tbody class="border-b border-gray-200">
                                <td class="px-4 py-2">
                                    {{ $lesson->video_original_name }}
                                </td>

                                <td class="px-4 py-2">
                                    Video
                                </td>

                                <td class="px-4 py-2">
                                    Procesando
                                </td>

                                <td class="px-4 py-2">
                                    {{ $lesson->created_at->format('d/m/Y') }}
                                </td>

                            </tbody>
                        </table>

                        <p class="mt-2">
                            El video se esta procesando
                        </p>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <hr>

    <div>
        <h2 class="font-semibold text-lg mb-1">
            Descripción de la lección
        </h2>

        @if ($editDescription)
            <form wire:submit="saveDescription"> {{-- Livewire --}}
                <div x-data="{
                    content: @entangle('description'),
                    initEditor() {
                        ClassicEditor.create($refs.editor)
                            .then(editor => {
                                editor.setData(this.content || '');
                                editor.model.document.on('change:data', () => {
                                    this.content = editor.getData();
                                });
                            })
                            .catch(error => {
                                console.error('Error al inicializar CKEditor:', error);
                            });
                    }
                }" x-init="initEditor">
                    <x-textarea x-ref="editor"></x-textarea>
                </div>

                <div class="flex justify-end mt-4">
                    <x-button>
                        Actualizar
                    </x-button>
                </div>
            </form>
        @else
            <div class="text-gray-600 ckeditor mb-2">
                {!! $lesson->description ?? 'Aún no se ha escrito ninguna descripción' !!} {{-- imprimir contenido HTML sin escapar --}}
            </div>

            <x-button wire:click="$set('editDescription', true)">
                Descripción
            </x-button>
        @endif
    </div>


</div>
