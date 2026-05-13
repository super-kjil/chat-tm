<div class="flex items-center gap-2 border-b border-gray-200 dark:border-gray-700 px-3 py-2 sm:px-4 sm:py-3">
    {{-- Mobile: hamburger to re-open sidebar --}}
    <button
        @click="$dispatch('open-sidebar')"
        class="md:hidden shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        title="Menu"
    >
        <x-heroicon-o-bars-3 class="h-5 w-5" />
    </button>

    {{-- Inner content: takes remaining width --}}
    <div class="flex flex-1 items-center justify-between min-w-0 gap-2">

        @if($headerName && ! $isEditing)
            {{-- ── Normal view ── --}}
            <div class="min-w-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white truncate leading-tight">
                    @if($headerType === 'channel')
                        <span class="text-gray-400 mr-1">#</span>
                    @else
                        <x-heroicon-o-chat-bubble-oval-left class="inline-block h-5 w-5 text-gray-400 mr-1" />
                    @endif
                    {{ $headerName }}
                </h2>
                @if($headerDescription)
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate">{{ $headerDescription }}</p>
                @endif
            </div>

            {{-- Action buttons — shrink-0 prevents clipping --}}
            <div class="flex shrink-0 items-center gap-1 sm:gap-2">
                <button
                    wire:click="showMembers"
                    class="flex items-center gap-1 text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                    title="{{ __('team-chat::messages.members') }}"
                >
                    <x-heroicon-o-users class="h-4 w-4" />
                    <span class="text-xs sm:text-sm">{{ $memberCount }}</span>
                </button>
                @if($headerType === 'channel' && $isOwner)
                    <button
                        wire:click="startEditing"
                        class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                        title="{{ __('team-chat::messages.channel_settings') }}"
                    >
                        <x-heroicon-o-cog-6-tooth class="h-4 w-4" />
                    </button>
                    <button
                        wire:click="archiveChannel"
                        wire:confirm="{{ __('team-chat::messages.archive_confirm') }}"
                        class="text-gray-400 hover:text-yellow-500 transition-colors"
                        title="{{ __('team-chat::messages.archive_channel') }}"
                    >
                        <x-heroicon-o-archive-box class="h-4 w-4" />
                    </button>
                @endif
            </div>

        @elseif($isEditing)
            {{-- ── Edit / Settings mode ── --}}
            {{--
                Mobile  : vertical stack — inputs on top, buttons below
                Desktop : horizontal row — inputs left, buttons right
            --}}
            <form wire:submit="saveChannel" class="flex flex-1 flex-col gap-2 md:flex-row md:items-center md:gap-3">

                {{-- Inputs --}}
                <div class="flex-1 space-y-1.5">
                    {{-- Name + Type row --}}
                    <div class="flex items-center gap-2">
                        <span class="shrink-0 text-gray-400">#</span>
                        <input
                            type="text"
                            wire:model="editName"
                            placeholder="{{ __('team-chat::messages.channel_name') }}"
                            class="min-w-0 flex-1 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        />
                        <select
                            wire:model="editType"
                            class="shrink-0 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                        >
                            <option value="public">{{ __('team-chat::messages.public') }}</option>
                            <option value="private">{{ __('team-chat::messages.private') }}</option>
                        </select>
                    </div>
                    {{-- Topic --}}
                    <input
                        type="text"
                        wire:model="editTopic"
                        placeholder="{{ __('team-chat::messages.topic_placeholder') }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-xs text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-primary-500"
                    />
                </div>

                {{-- Save / Cancel buttons --}}
                <div class="flex shrink-0 items-center gap-1.5">
                    <button
                        type="submit"
                        class="flex-1 md:flex-none rounded-md bg-primary-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-primary-700 transition-colors"
                    >
                        {{ __('team-chat::messages.save') }}
                    </button>
                    <button
                        type="button"
                        wire:click="cancelEditing"
                        class="flex-1 md:flex-none rounded-md border border-gray-300 dark:border-gray-600 px-3 py-1.5 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors"
                    >
                        {{ __('team-chat::messages.cancel') }}
                    </button>
                </div>

            </form>
        @endif

    </div>{{-- end flex-1 inner wrapper --}}
</div>
