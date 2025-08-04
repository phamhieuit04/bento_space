@extends('layouts.master')
@section('content')
    @include('modals.drive.rename', ['id' => $file['drive_id']])
    <flux:main>
        <flux:header class="px-0! py-3">
            <flux:heading size="xl">{{ $file['name'] }}</flux:heading>
            <flux:spacer />
            <flux:dropdown>
                <flux:button
                    square
                    icon="ellipsis-horizontal"
                    class="cursor-pointer!"
                />
                <flux:menu>
                    <flux:modal.trigger name="rename_modal">
                        <flux:button
                            icon="pencil-square"
                            variant="ghost"
                            class="flex w-full justify-start"
                        >
                            Rename
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:menu.separator />
                    <flux:menu.submenu
                        heading="Information"
                        icon="information-circle"
                    >
                        <flux:menu.item class="cursor-pointer!">
                            Name: {{ $file['name'] }}
                        </flux:menu.item>
                        <flux:menu.item class="cursor-pointer!">
                            Size: {{ $file['readable_size'] }}
                        </flux:menu.item>
                        <flux:menu.item class="cursor-pointer!">
                            Type: {{ $file['mime_type'] }}
                        </flux:menu.item>
                        <flux:menu.item class="cursor-pointer!">
                            Created at: {{ $file['created_at'] }}
                        </flux:menu.item>
                        <flux:menu.item class="cursor-pointer!">
                            Updated at: {{ $file['updated_at'] }}
                        </flux:menu.item>
                    </flux:menu.submenu>
                </flux:menu>
            </flux:dropdown>
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
