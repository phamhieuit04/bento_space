@use('App\Enums\Drive\TrashedStatus')
@include('modals.drive.rename')
@include('modals.drive.trash')
<flux:dropdown>
    <flux:button
        variant="subtle"
        square
        icon="ellipsis-horizontal"
        class="cursor-pointer! rounded-full!"
    />
    <flux:menu class="max-w-52">
        @if ($item['trashed'] == TrashedStatus::NOT_TRASHED->value)
            @if ($item['mime_type'] != 'application/vnd.google-apps.folder')
                <flux:button
                    href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/download') }}"
                    icon="arrow-down-tray"
                    variant="ghost"
                    class="flex w-full cursor-pointer justify-start"
                >
                    Download
                </flux:button>
            @endif

            <flux:modal.trigger
                name="{{ 'rename_modal_' . $item['drive_id'] }}"
            >
                <flux:button
                    icon="pencil-square"
                    variant="ghost"
                    class="flex w-full cursor-pointer justify-start"
                >
                    Rename
                </flux:button>
            </flux:modal.trigger>
            <flux:button
                href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/trash') }}"
                icon="trash"
                variant="ghost"
                class="flex w-full cursor-pointer justify-start"
            >
                Delete
            </flux:button>
            <flux:menu.separator />
            <flux:menu.submenu heading="Information" icon="information-circle">
                <flux:menu.item class="cursor-pointer!">
                    Name: {{ $item['name'] }}
                </flux:menu.item>
                <flux:menu.item class="cursor-pointer!">
                    Size:
                    {{ $item['size'] }}
                </flux:menu.item>
                @if ($item['mime_type'] != 'application/vnd.google-apps.folder')
                    <flux:menu.item class="cursor-pointer!">
                        Extension:
                        {{ $item['extension'] }}
                    </flux:menu.item>
                @endif

                <flux:menu.item class="cursor-pointer!">
                    Type:
                    {{ $item['mime_type'] }}
                </flux:menu.item>
                <flux:menu.item class="cursor-pointer!">
                    Created at:
                    {{ $item['created_at'] }}
                </flux:menu.item>
                <flux:menu.item class="cursor-pointer!">
                    Updated at:
                    {{ $item['updated_at'] }}
                </flux:menu.item>
            </flux:menu.submenu>
        @else
            <flux:button
                href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/restore') }}"
                variant="ghost"
                class="flex w-full cursor-pointer items-center justify-start px-2.5!"
            >
                <iconify-icon
                    icon="material-symbols-light:restore-page-rounded"
                    class="text-xl"
                ></iconify-icon>
                Restore
            </flux:button>
            <flux:modal.trigger
                name="{{ 'trash_modal_' . $item['drive_id'] }}"
            >
                <flux:button
                    variant="ghost"
                    class="flex w-full cursor-pointer items-center justify-start px-2.5!"
                >
                    <iconify-icon
                        icon="material-symbols-light:delete-forever"
                        class="text-xl"
                    ></iconify-icon>
                    Delete forever
                </flux:button>
            </flux:modal.trigger>
        @endif
    </flux:menu>
</flux:dropdown>
