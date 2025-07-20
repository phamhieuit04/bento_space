<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.0/dist/iconify-icon.min.js"></script>
</head>

<body>
    <div class="mx-auto container flex flex-col gap-8 m-5 items-start">
        <div class="fixed top-0 left-0 right-0 container mx-auto bg-white h-20 flex items-center justify-between z-50">
            <div class="flex items-center gap-5">
                <a href="{{ url('/dashboard') }}" class="flex items-center">
                    <iconify-icon icon="material-symbols:home" class="text-3xl text-green-500"></iconify-icon>
                </a>
                <div class="flex gap-2">
                    <a href="{{ url('/dashboard/sync') }}"
                        class="inline-block px-5 py-1.5 border-black hover:border-green-500 border text-black rounded-sm text-lg leading-normal hover:bg-green-500 hover:text-white transition-all duration-200">
                        Sync
                    </a>
                    <form method="post" action="{{ url('/dashboard/search') }}"
                        class="px-4 py-1.5 border-black hover:border-green-500 border text-black rounded-sm text-lg leading-normal">
                        @csrf
                        <input name="search_key" type="text" placeholder="search..."
                            class="text-base outline-0 placeholder:italic">
                    </form>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ url('/google/refresh_token') }}"
                    class="inline-block px-5 py-1.5 border-black hover:border-green-500 border text-black rounded-sm text-lg leading-normal hover:bg-green-500 hover:text-white transition-all duration-200">
                    Refresh token
                </a>
                <a href="{{ url('/logout') }}"
                    class="inline-block px-5 py-1.5 border-transparent hover:border-green-500 border text-black rounded-sm text-lg leading-normal hover:bg-green-500 hover:text-white transition-all duration-200">
                    Logout
                </a>
            </div>
        </div>
        <div class="flex flex-col gap-10 pt-20 w-full">
            @if (blank($data['folders']) && blank($data['files']))
                <div class="w-[1000px]">
                    <h1 class="text-5xl font-bold">Không có gì ở đây hihi</h1>
                </div>
            @else
                {{-- Folder --}}
                @if (!blank($data['folders']))
                    <div>
                        <h1 class="font-bold text-3xl mb-2">My folders</h1>
                        <ul class="grid gap-4 grid-cols-6">
                            @foreach ($data['folders'] as $folder)
                                <li>
                                    <a href="{{ url("/dashboard/f/{$folder['drive_id']}") }}"
                                        class="h-15 bg-[#f0f4f9] rounded-xl p-4 overflow-hidden flex items-center hover:brightness-90 cursor-pointer transition-all duration-200 gap-2">
                                        <iconify-icon icon="material-symbols:folder" class="text-xl"></iconify-icon>
                                        <h1 class="truncate">{{ $folder['name'] }}</h1>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- File --}}
                @if (!blank($data['files']))
                    <div>
                        <h1 class="font-bold text-3xl mb-2">My files</h1>
                        <ul class="grid gap-4 grid-cols-6">
                            @foreach ($data['files'] as $file)
                                <li
                                    class="bg-[#f0f4f9] rounded-xl p-4 overflow-hidden h-60  hover:brightness-90 cursor-pointer transition-all duration-200">
                                    <div class="flex gap-2 mb-2 items-center">
                                        <img src="{{ $file['icon_url'] }}" alt="" class="size-5">
                                        <h1 class="truncate">{{ $file['name'] }}</h1>
                                    </div>
                                    <div class="h-full pb-6.5">
                                        <a href="{{ url('/dashboard/f/' . $file['drive_id'] . '/info') }}">
                                            <img src="{{ $file['thumbnail_url'] }}" alt=""
                                                class="object-cover h-full w-full rounded-md" />
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
        </div>
    </div>
</body>

</html>