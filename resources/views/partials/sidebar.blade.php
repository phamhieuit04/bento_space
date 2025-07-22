<div class="flex h-screen w-96 shrink-0 flex-col pt-20">
    <ul class="flex h-screen flex-col gap-2 overflow-y-scroll p-5">
        @for ($i = 0; $i < 50; $i++)
            <li>
                <a class="text-xl" href="{{ url('drive/dashboard') }}">
                    Item {{ $i + 1 }}
                </a>
            </li>
        @endfor
    </ul>
</div>
