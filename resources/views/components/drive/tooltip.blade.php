@use('App\Enums\Drive\TrashedStatus')
@use('App\Enums\Drive\StarredStatus')
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
            @if ($item['starred'] == StarredStatus::NOT_STARRED->value)
                <flux:button
                    href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/star') }}"
                    variant="ghost"
                    class="flex w-full cursor-pointer items-center justify-start px-2.5!"
                >
                    <iconify-icon
                        icon="material-symbols-light:kid-star-outline"
                        class="text-xl"
                    ></iconify-icon>
                    Add star
                </flux:button>
            @else
                <flux:button
                    href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/unstar') }}"
                    variant="ghost"
                    class="flex w-full cursor-pointer items-center justify-start px-2.5!"
                >
                    <iconify-icon
                        icon="material-symbols-light:kid-star"
                        class="text-xl"
                    ></iconify-icon>
                    Remove star
                </flux:button>
            @endif

            @if ($item['mime_type'] != 'application/vnd.google-apps.folder')
                <flux:button
                    href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/download') }}"
                    variant="ghost"
                    class="flex w-full cursor-pointer items-center justify-start px-2.5!"
                >
                    <iconify-icon
                        icon="material-symbols:download-2-rounded"
                        class="text-xl"
                    ></iconify-icon>
                    Download
                </flux:button>
            @endif

            <flux:modal.trigger
                name="{{ 'rename_modal_' . $item['drive_id'] }}"
            >
                <flux:button
                    variant="ghost"
                    class="flex w-full cursor-pointer items-center justify-start px-2.5!"
                >
                    <iconify-icon
                        icon="material-symbols-light:edit-square"
                        class="text-xl"
                    ></iconify-icon>
                    Rename
                </flux:button>
            </flux:modal.trigger>
            <flux:button
                href="{{ url('/drive/dashboard/f/' . $item['drive_id'] . '/trash') }}"
                variant="ghost"
                class="flex w-full cursor-pointer items-center justify-start px-2.5!"
            >
                <iconify-icon
                    icon="material-symbols:delete"
                    class="text-xl"
                ></iconify-icon>
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
