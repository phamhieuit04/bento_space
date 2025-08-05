<flux:modal name="{{ 'rename_modal_' . $item['drive_id'] }}" class="w-96">
    <form
        action="{{ url("/drive/dashboard/f/{$item['drive_id']}/rename") }}"
        method="post"
        class="flex flex-col gap-5"
    >
        @csrf
        <div>
            <flux:heading size="lg">Rename</flux:heading>
            <flux:text class="mt-2">
                Make changes to your file/folder's name.
            </flux:text>
        </div>
        <flux:input
            label="Name"
            placeholder="..."
            name="name"
            value="{{ $item['name'] }}"
        />
        <flux:button type="submit" variant="primary" class="cursor-pointer">
            Submit
        </flux:button>
    </form>
</flux:modal>
