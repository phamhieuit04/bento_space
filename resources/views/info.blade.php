<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@3.0.0/dist/iconify-icon.min.js"></script>
</head>

<body>
    <div class="container mx-auto">
        <div class="my-2 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">{{ $file['name'] }}</h1>
                <ul class="flex gap-2">
                    <li class="text-xl border-r-2 border-gray-300 pr-2">Size: {{ $file['readable_size'] }}</li>
                    <li class="text-xl border-r-2 border-gray-300 pr-2">Created at: {{ $file['created_at'] }}</li>
                    <li class="text-xl">Updated at: {{ $file['created_at'] }}</li>
                </ul>
            </div>
            <a href="{{ url('/dashboard/f/' . $file['drive_id'] . '/download') }}" download="{{ $file['name'] }}"
                class="inline-block px-5 py-1.5 border-black hover:border-green-500 border text-black rounded-sm text-lg leading-normal hover:bg-green-500 hover:text-white transition-all duration-200">
                Download
            </a>
        </div>
        <div class="bg-black flex items-center justify-center h-[800px]">
            @if ($file['mime_type'] == 'image/jpeg' || $file['mime_type'] == 'image/png' || $file['mime_type'] == 'video/mp4')
                @if ($file['mime_type'] == 'image/jpeg' || $file['mime_type'] == 'image/png')
                    <img src="{{ $file['image_url'] }}" alt="" class="h-[800px] object-contain">
                @endif
                @if ($file['mime_type'] == 'video/mp4')
                    <iframe src="{{ $file['video_url'] }}" height="800" width="1600"></iframe>
                @endif
            @else
                <h1 class="text-white text-5xl font-bold">No preview...</h1>
            @endif
        </div>
    </div>
</body>

</html>