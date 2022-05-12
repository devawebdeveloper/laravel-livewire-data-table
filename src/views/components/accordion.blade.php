<div>
    <div x-data="manageAccordion()" x-cloak>
        <div class="overflow-hidden bg-white rounded-md shadow-sm">
            {{-- top --}}
            <div class="flex items-center justify-between border-b">
                {{-- top-left ----- --}}
                <div class="flex items-center justify-between w-full gap-2">
                    {{-- title --}}
                    <div class="px-4 capitalize">
                        {{ $title ?? '' }}
                    </div>
                    {{-- options --}}
                    <div class="px-2">
                        {{ $options ?? '' }}
                    </div>
                </div>
                {{-- top-right ------ --}}
                <div class="p-2 bg-gray-50">
                    <template x-if="content">
                        <div x-on:click="content = !content" class="text-gray-400 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                              </svg>
                        </div>
                    </template>
                    <template x-if="!content">
                        <div x-on:click="content = !content" class="text-gray-400 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                              </svg>
                        </div>
                    </template>
                </div>
            </div>
            {{-- content ----------------- --}}
            <div x-show.transition='content' class="p-2">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
<script>
    Alpine.data('manageAccordion', () => ({
        content: "<?php echo $isOpen ?>",
    }));
</script>