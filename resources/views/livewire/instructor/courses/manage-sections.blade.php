<div>

    <!-- Elemento Alpine.js que contiene el método destroySection para eliminar una sección -->
    <div x-data="{
        {{-- Método para confirmar la eliminación de una sección --}}
        destroySection(sectionId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    {{-- Llama al método destroy en el backend usando Livewire --}}
                    @this.call('destroy', sectionId);
                }
            });
        }
    }" x-init="new Sortable($refs.sections, {
        animation: 150,
        handle: '.handle',
        ghostClass: 'blue-background-class',
        store: {
            set: (sortable) => {
                @this.call('sortSections', sortable.toArray());
            }
        }
    });">

        <!-- Verifica si hay secciones para mostrar -->
        @if ($sections->count())

            <!-- Lista de secciones con un espacio entre cada una -->
            <ul class="mb-6 space-y-6" x-ref="sections">

                @foreach ($sections as $section)
                    <!-- Cada sección tiene un atributo data-id y una clave Livewire para optimizar el renderizado -->
                    <li data-id="{{ $section->id }}" wire:key="section-{{ $section->id }}"> {{-- IMPORTANTE para que livewire pueda seguir un correcto seguimiento --}}

                        <!-- Componente para la creación de la posición de la sección -->
                        @include('instructor.sections.create-position')

                        <!-- Contenedor de cada sección -->
                        <div class="bg-gray-100 rounded-lg shadow-lg px-6 py-4 mt-6">

                            @if ($sectionEdit['id'] == $section->id)
                                <!-- Si la sección está en modo de edición, muestra el formulario de edición -->
                                @include('instructor.sections.edit')
                            @else
                                <!-- Si no está en edición, muestra la vista normal de la sección -->
                                @include('instructor.sections.show')
                            @endif

                        </div>

                    </li>
                @endforeach

            </ul>

        @endif

        <!-- Formulario para crear una nueva sección -->
        @include('instructor.sections.create')
    </div>

    <!-- Inserta el script de Sortable.js para habilitar la funcionalidad de arrastrar y soltar -->
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
    @endpush

</div>
