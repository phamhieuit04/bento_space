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
        <div class="flex gap-5">
            <button>
                <a href="{{ url('/dashboard/sync') }}"
                    class="bg-green-500 py-2.5 px-10 text-2xl font-bold text-white rounded-xl cursor-pointer hover:opacity-75 transition-all duration-200">Sync</a>
            </button>
            <button>
                <a href="{{ url('/google/refresh_token') }}"
                    class="bg-green-500 py-2.5 px-10 text-2xl font-bold text-white rounded-xl cursor-pointer hover:opacity-75 transition-all duration-200">Refresh
                    token</a>
            </button>
        </div>
        <div class="flex flex-col gap-10">
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
                                    <h1 class="truncate mb-2">{{ $file['name'] }}</h1>
                                    <div class="h-full pb-6.5">
                                        <img src="{{ $file['thumbnail_url'] }}" alt=""
                                            class="object-cover h-full w-full rounded-md" />
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