<flux:modal name="create_folder_modal" class="w-96">
    <form
        action="{{ url('/drive/dashboard/create') }}"
        method="post"
        class="flex flex-col gap-5"
    >
        @csrf
        <flux:heading size="lg">Create folder</flux:heading>
        <flux:input label="Folder's name" placeholder="..." name="name" />
        <flux:button type="submit" variant="primary" class="cursor-pointer">
            Create
        </flux:button>
    </form>
</flux:modal>
