<flux:sidebar
    sticky
    stashable
    class="h-screen bg-zinc-50 xl:w-72 2xl:w-80 dark:bg-zinc-900"
>
    <flux:navlist class="w-full gap-1">
        <flux:navlist.group heading="Google Drive" expandable>
            <flux:navlist.item
                icon="folder"
                icon:variant="solid"
                class="mb-1 h-12!"
                href="{{ url('/drive/dashboard') }}"
            >
                Dashboard
            </flux:navlist.item>
            <flux:navlist.item
                href="{{ url('/drive/starred') }}"
                icon="star"
                icon:variant="solid"
                class="mb-1 h-12!"
            >
                Starred
            </flux:navlist.item>
            <flux:navlist.item
                href="{{ url('/drive/trash') }}"
                icon="trash"
                icon:variant="solid"
                class="mb-1 h-12!"
            >
                Trash bin
            </flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.item
            icon="pencil"
            icon:variant="solid"
            href=""
            class="h-12!"
        >
            Google Task
        </flux:navlist.item>
    </flux:navlist>
</flux:sidebar>
