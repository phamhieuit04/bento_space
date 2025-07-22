@extends('layouts.master')
@section('content')
    <div class="flex grow flex-col gap-2 pt-24 pr-5">
        <div class="my-2 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold">{{ $file['name'] }}</h1>
                <ul class="flex gap-2">
                    <li class="border-r-2 border-gray-300 pr-2 text-lg">
                        Size: {{ $file['readable_size'] }}
                    </li>
                    <li class="border-r-2 border-gray-300 pr-2 text-lg">
                        Created at: {{ $file['created_at'] }}
                    </li>
                    <li class="text-lg">
                        Updated at: {{ $file['created_at'] }}
                    </li>
                </ul>
            </div>
            <a
                href="{{ url('/drive/dashboard/f/' . $file['drive_id'] . '/download') }}"
                download="{{ $file['name'] }}"
                class="inline-block rounded-sm border border-black px-5 py-1.5 text-lg leading-normal text-black transition-all duration-200 hover:border-green-500 hover:bg-green-500 hover:text-white"
            >
                Download
            </a>
        </div>
        <div class="flex h-[700px] items-center justify-center bg-black">
            @if ($file['mime_type'] == 'image/jpeg' || $file['mime_type'] == 'image/png' || $file['mime_type'] == 'video/mp4')
                @if ($file['mime_type'] == 'image/jpeg' || $file['mime_type'] == 'image/png')
                    <img
                        src="{{ $file['image_url'] }}"
                        alt=""
                        class="h-[700px] object-contain"
                    />
                @endif

                @if ($file['mime_type'] == 'video/mp4')
                    <iframe
                        src="{{ $file['video_url'] }}"
                        height="700"
                        width="1490"
                    ></iframe>
                @endif
            @else
                <h1 class="text-5xl font-bold text-white">No preview...</h1>
            @endif
        </div>
    </div>
@endsection
