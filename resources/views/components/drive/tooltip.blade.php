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
        @if (request()->is('drive/dashboard') || request()->is('drive/dashboard/*'))
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
            <flux:modal.trigger
                name="{{ 'trash_modal_' . $item['drive_id'] }}"
            >
                <flux:button
                    icon="trash"
                    variant="ghost"
                    class="flex w-full cursor-pointer justify-start"
                >
                    Trash
                </flux:button>
            </flux:modal.trigger>
            <flux:menu.separator />
            <flux:menu.submenu heading="Information" icon="information-circle">
                <flux:menu.item class="cursor-pointer!">
                    Name: {{ $item['name'] }}
                </flux:menu.item>
                <flux:menu.item class="cursor-pointer!">
                    Size:
                    {{ ! blank($item['size']) ? $item['size'] : 0 }}
                </flux:menu.item>
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
        @endif

        @if (request()->is('drive/trash'))
            <flux:menu.item>TODO: restore item</flux:menu.item>
            <flux:menu.item>TODO: hard delete</flux:menu.item>
        @endif
    </flux:menu>
</flux:dropdown>
