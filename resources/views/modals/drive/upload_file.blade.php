<flux:modal name="upload_file_modal" class="w-96">
    <form
        action="{{ url('/drive/dashboard/upload') }}"
        method="post"
        enctype="multipart/form-data"
        class="flex flex-col gap-5"
    >
        @csrf
        <flux:input type="file" label="Upload file" name="file" />
        <flux:button type="submit" variant="primary" class="cursor-pointer">
            Upload
        </flux:button>
    </form>
</flux:modal>
