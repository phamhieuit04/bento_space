@extends('layouts.master')
@section('content')
    <div class="flex h-screen grow flex-col gap-8 pt-24 pb-4">
        <div
            class="flex h-screen flex-col gap-8 overflow-x-hidden overflow-y-scroll pr-5"
        >
            @if (blank($data['folders']) && blank($data['files']))
                <div>
                    <h1 class="text-5xl font-bold">Không có gì ở đây hihi</h1>
                </div>
            @else
                {{-- Folder --}}
                @if (! blank($data['folders']))
                    <div>
                        <h1 class="mb-3 text-3xl font-bold">My folders</h1>
                        <ul class="grid grid-cols-5 gap-4">
                            @foreach ($data['folders'] as $folder)
                                <li>
                                    <a
                                        href="{{ url("/drive/dashboard/f/{$folder['drive_id']}") }}"
                                        class="flex h-15 cursor-pointer items-center gap-2 overflow-hidden rounded-xl bg-[#f0f4f9] p-4 transition-all duration-200 hover:brightness-90"
                                    >
                                        <iconify-icon
                                            icon="material-symbols:folder"
                                            class="text-xl"
                                        ></iconify-icon>
                                        <h1 class="truncate">
                                            {{ $folder['name'] }}
                                        </h1>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- File --}}
                @if (! blank($data['files']))
                    <div>
                        <h1 class="mb-3 text-3xl font-bold">My files</h1>
                        <ul class="grid grid-cols-5 gap-4">
                            @foreach ($data['files'] as $file)
                                <li
                                    class="h-60 cursor-pointer overflow-hidden rounded-xl bg-[#f0f4f9] p-4 transition-all duration-200 hover:brightness-90"
                                >
                                    <div class="mb-2 flex items-center gap-2">
                                        <img
                                            src="{{ $file['icon_url'] }}"
                                            alt=""
                                            class="size-5"
                                        />
                                        <h1 class="truncate">
                                            {{ $file['name'] }}
                                        </h1>
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
        </div>
    </div>
@endsection
