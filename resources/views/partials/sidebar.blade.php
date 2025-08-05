<flux:sidebar sticky stashable class="w-96">
    <flux:navlist class="w-full gap-1">
        <flux:navlist.group heading="Google Drive" expandable>
            <flux:navlist.item
                icon="folder"
                icon:variant="solid"
                class="my-2! h-12!"
                href="{{ url('/drive/dashboard') }}"
            >
                Dashboard
            </flux:navlist.item>
            <flux:navlist.item
                href="{{ url('/drive/trash') }}"
                icon="trash"
                icon:variant="solid"
                class="my-2! h-12!"
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
