<div>
    <div wire:ignore {{-- No quiero que se renderize --}} x-data="{
        content: @entangle($attributes->wire('model')),  {{-- Recupera el wire:model de la vista --}}
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
</div>
