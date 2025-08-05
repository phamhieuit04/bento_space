<flux:modal
    name="{{ 'trash_modal_' . $item['drive_id'] }}"
    class="min-w-[22rem]"
>
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Delete {{ $item['name'] }}</flux:heading>
            <flux:text class="mt-2">
                <p>You're about to delete this file/folder.</p>
                <p>This file/folder will be moved to trash.</p>
            </flux:text>
        </div>
        <form
            class="flex gap-2"
            method="post"
            action="{{ url("/drive/dashboard/f/{$item['drive_id']}/trash") }}"
        >
            @csrf
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost" class="cursor-pointer">
                    Cancel
                </flux:button>
            </flux:modal.close>
            <flux:button type="submit" variant="danger" class="cursor-pointer">
                Delete
            </flux:button>
        </form>
    </div>
</flux:modal>
