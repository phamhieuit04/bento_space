<div
    class="fixed top-0 right-0 left-0 z-50 flex h-20 items-center justify-between bg-white px-6"
>
    <div class="flex items-center gap-5">
        <a href="{{ url('/drive/dashboard') }}" class="flex items-center">
            <h1 class="text-4xl font-bold">Bento Space</h1>
        </a>
        <a
            href="{{ url('/google/refresh_token') }}"
            class="inline-block rounded-sm border border-black px-5 py-1.5 text-lg leading-normal text-black transition-all duration-200 hover:border-green-500 hover:bg-green-500 hover:text-white"
        >
            Refresh token
        </a>
    </div>
    <div class="flex items-center gap-2">
        @if (request()->is('drive/*'))
            <form
                method="post"
                action="{{ url('/drive/search') }}"
                class="rounded-sm border border-black px-4 py-1.5 text-lg leading-normal text-black hover:border-green-500"
            >
                @csrf
                <input
                    name="search_key"
                    type="text"
                    placeholder="search..."
                    class="text-base outline-0 placeholder:italic"
                />
            </form>
            <a
                href="{{ url('/drive/dashboard/sync') }}"
                class="inline-block rounded-sm border border-black px-5 py-1.5 text-lg leading-normal text-black transition-all duration-200 hover:border-green-500 hover:bg-green-500 hover:text-white"
            >
                Sync
            </a>
        @endif

        <a
            href="{{ url('/logout') }}"
            class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-lg leading-normal text-black transition-all duration-200 hover:border-green-500 hover:bg-green-500 hover:text-white"
        >
            Logout
        </a>
    </div>
</div>
