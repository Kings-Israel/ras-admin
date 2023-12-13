<div>
    <ol class="flex items-center w-full space-x-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 sm:space-x-4">
        @foreach ($steps as $step)
            <li class="flex items-center">
                <span class="flex items-center justify-center w-8 h-8 mr-2 text-white text-xs {{ $step->isCurrent() ? 'bg-teal-400' : 'bg-gray-400' }} rounded-full shrink-0">
                    {{ $loop->index + 1 }}
                </span>
                {{-- Product <span class="hidden sm:inline-flex sm:ml-2">Details</span> --}}
                <span class="hidden sm:inline-flex sm:ml-2">{{ $step->label }}</span>
                @if (!$loop->last)
                    <svg class="w-3 h-3 ml-2 sm:ml-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                    </svg>
                @endif
            </li>
        @endforeach
    </ol>
</div>
