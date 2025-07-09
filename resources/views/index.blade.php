<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="mx-auto container">
        <div class="flex m-4 gap-5 flex-col">
            <button
                class="bg-green-500 py-2.5 w-40 text-2xl font-bold text-white rounded-xl cursor-pointer hover:opacity-75 transition-all duration-200">
                Sync
            </button>
            <ul class="flex gap-4 flex-wrap">
                @for ($i = 0; $i < 100; $i++)
                    <li class="size-56 bg-[#f0f4f9] rounded-xl p-4 flex flex-col gap-2">
                        <h1>Ten file</h1>
                        <div class="overflow-hidden rounded-sm">
                            <img src="https://lh3.googleusercontent.com/drive-storage/AJQWtBPfR9n937Qsdn29u_ZHDCDT-Ic1PhII1zcj7-SVJvMcKZqo4aUYLptBBOWYEtrBLdPTw9uJ3aVh2RPOJrymBoqQvhiwn6DcvT2rLbKZl0ewqG75ndhQXzDocvWGKQ=s220"
                                alt="" class="object-cover h-full w-full" />
                        </div>
                    </li>
                @endfor
            </ul>
        </div>

    </div>
</body>

</html>