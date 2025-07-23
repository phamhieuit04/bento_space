@extends('layouts.master')
@section('content')
    <flux:main class="flex flex-col gap-8">
        @if (blank($data['folders']) && blank($data['files']))
            <div>
                <h1 class="text-5xl font-bold">Không có gì ở đây hihi</h1>
            </div>
        @else
            {{-- Folder --}}
            @if (! blank($data['folders']))
                <div>
                    <flux:heading size="xl" level="1" class="mb-2 font-bold!">
                        My folders
                    </flux:heading>
                    {{-- <h1 class="mb-3 text-3xl font-bold"></h1> --}}
                    <ul
                        class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
                    >
                        @foreach ($data['folders'] as $folder)
                            <li>
                                <a
                                    href="{{ url("/drive/dashboard/f/{$folder['drive_id']}") }}"
                                    class="flex h-15 cursor-pointer items-center gap-2 overflow-hidden rounded-xl bg-[#f0f4f9] p-4 transition-all duration-200 hover:brightness-90 dark:bg-[#303032]"
                                >
                                    <iconify-icon
                                        icon="material-symbols:folder"
                                        class="text-xl"
                                    ></iconify-icon>
                                    <flux:text
                                        variant="strong"
                                        class="truncate"
                                    >
                                        {{ $folder['name'] }}
                                    </flux:text>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- File --}}
            @if (! blank($data['files']))
                <div>
                    <flux:heading size="xl" level="1" class="mb-2 font-bold!">
                        My files
                    </flux:heading>
                    <ul
                        class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
                    >
                        @foreach ($data['files'] as $file)
                            <li
                                class="h-60 cursor-pointer overflow-hidden rounded-xl bg-[#f0f4f9] p-4 transition-all duration-200 hover:brightness-90 dark:bg-[#303032]"
                            >
                                <div class="mb-2 flex items-center gap-2">
                                    <img
                                        src="{{ $file['icon_url'] }}"
                                        alt=""
                                        class="size-5"
                                    />
                                    <flux:text
                                        variant="strong"
                                        class="truncate"
                                    >
                                        {{ $file['name'] }}
                                    </flux:text>
                                </div>
                                <div class="h-full pb-6.5">
                                    <a
                                        href="{{ url('/drive/dashboard/f/' . $file['drive_id'] . '/info') }}"
                                    >
                                        <img
                                            src="{{ $file['thumbnail_url'] }}"
                                            alt=""
                                            class="h-full w-full rounded-md object-cover"
                                        />
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif
    </flux:main>
@endsection
