<flux:header
    sticky
    class="border-b border-zinc-200 bg-transparent py-3 backdrop-blur-2xl dark:border-zinc-700 dark:bg-transparent"
>
    <div class="flex items-center gap-5">
        <a href="{{ url('/drive/dashboard') }}" class="flex items-center">
            <h1 class="text-2xl font-bold">Bento Space</h1>
        </a>
        <flux:button
            variant="primary"
            href="{{ url('/google/refresh_token') }}"
        >
            Refresh token
        </flux:button>
    </div>
    <flux:spacer />
    <div class="flex items-center gap-2">
        @if (request()->is('drive/*'))
            <form method="post" action="{{ url('/drive/search') }}">
                @csrf
                <flux:input
                    name="search_key"
                    icon="magnifying-glass"
                    placeholder="Search..."
                />
            </form>
            <flux:button
                href="{{ url('/drive/dashboard/sync') }}"
                variant="filled"
            >
                Sync
            </flux:button>
        @endif

        <flux:button
            x-data
            x-on:click="$flux.dark = ! $flux.dark"
            icon="moon"
            variant="subtle"
            aria-label="Toggle dark mode"
        />
        <flux:separator vertical />
        <flux:button href="{{ url('/logout') }}" variant="ghost">
            Logout
        </flux:button>
    </div>
</flux:header>
