<div>
    <div x-data="manageInlineEdit()" x-on:inlineedit.window='editbox = false'>
        <div class="relative flex items-center justify-between">
            <div>
                {{ $slot }}
            </div>
            <div x-on:click="open($refs)">
                {{ $trigger ?? '' }}
            </div>
            <div style="width: 100%;"
                x-ref="editbox" x-show.transition.opacity='editbox'
                class="absolute z-50 flex items-center justify-between gap-1 p-2 min-w-min {{ $formStyle == '' ? 'bg-white rounded-md shadow-lg' : $formStyle }}">
                <div style="width:90%;min-width:200px" class="min-w-min">{{ $form ?? '' }}</div>
                <div x-on:click="editbox = false"
                    class="px-2 text-xl bg-gray-100 rounded-lg hover:bg-gray-200">
                    &times;
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function manageInlineEdit() {
        return {
            editbox: false,
            open($refs) {
                this.editbox = true;
                var scr = screen.width;
                var offs = $refs.editbox.parentNode.offsetLeft;

                if ((scr / 2) > (scr - offs)) {
                    $refs.editbox.style.right= 0;
                    $refs.editbox.style.width = "100%";
                }
            },
        }
    }
</script>