@extends('layouts.master')
@section('content')
    <flux:main>
        <flux:header class="px-0! py-3">
            <flux:heading size="xl">{{ $file['name'] }}</flux:heading>
            <flux:spacer />
            @include('components.drive.tooltip', ['item' => $file])
            <flux:separator vertical class="mx-2" />
            <flux:button
                href="{{ url('/drive/dashboard/f/' . $file['drive_id'] . '/download') }}"
                download="{{ $file['name'] }}"
                type="submit"
                variant="primary"
            >
                Download
            </flux:button>
        </flux:header>
        <div
            class="flex h-[700px] items-center justify-center overflow-hidden bg-black"
        >
            @if ($file['mime_type'] == 'image/jpeg' || $file['mime_type'] == 'image/png' || $file['mime_type'] == 'video/mp4')
                @if ($file['mime_type'] == 'image/jpeg' || $file['mime_type'] == 'image/png')
                    <img
                        src="{{ url('/drive/dashboard/f/' . $file['drive_id'] . '/stream') }}"
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
                <h1 class="text-5xl font-bold text-white">
                    Not supported yet.
                </h1>
            @endif
        </div>
    </flux:main>
@endsection
