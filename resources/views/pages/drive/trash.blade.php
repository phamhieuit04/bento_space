@use('App\Enums\Drive\TrashedDate')
@extends('layouts.master')
@section('content')
    <flux:main>
        @if (blank($data[TrashedDate::TODAY->value]) && blank($data[TrashedDate::YESTERDAY->value]) && blank($data[TrashedDate::LONG_TIME_AGO->value]))
            <h1 class="text-5xl font-bold">Không có gì ở đây hihi</h1>
        @else
            <div
                class="mb-5 flex items-center justify-between rounded-lg bg-[#f0f4f9] px-4 py-3.5 dark:bg-[#303032]"
            >
                <flux:heading size="lg">
                    Items in the trash will be permanently deleted after 30
                    days.
                </flux:heading>
                <flux:button
                    variant="danger"
                    class="cursor-pointer"
                    href="{{ url('/drive/trash/empty') }}"
                >
                    Empty all
                </flux:button>
            </div>
            @for ($i = 0; $i < $data->count(); $i++)
                @if ($data[$data->keys()[$i]]->count() > 0)
                    <flux:heading size="xl" level="1" class="mb-2 font-bold!">
                        {{ $data->keys()[$i] }}
                    </flux:heading>
                    <ul
                        class="mb-8 grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
                    >
                        @foreach ($data[$data->keys()[$i]] as $item)
                            <li
                                class="group flex h-64 flex-col overflow-hidden rounded-xl bg-[#f0f4f9] px-4 pt-2 pb-3 dark:bg-[#303032]"
                            >
                                <div
                                    class="mb-2 flex shrink-0 items-center justify-between gap-1"
                                >
                                    <div
                                        class="flex grow items-center gap-2 overflow-hidden"
                                    >
                                        <img
                                            src="{{ $item['icon_url'] }}"
                                            alt=""
                                            class="size-5"
                                        />
                                        <flux:text
                                            variant="strong"
                                            class="truncate"
                                        >
                                            {{ $item['name'] }}
                                        </flux:text>
                                    </div>
                                    @include('components.drive.tooltip', ['item' => $item])
                                </div>
                                <div class="grow overflow-hidden">
                                    <img
                                        src="{{ $item['thumbnail_url'] }}"
                                        alt=""
                                        class="h-full w-full rounded-md object-cover"
                                    />
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endfor
        @endif
    </flux:main>
@endsection
