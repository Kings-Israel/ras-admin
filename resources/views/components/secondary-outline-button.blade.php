<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-transparent dark:bg-transparent border-2 border-gray-300 dark:border-gray-300 rounded-md font-semibold text-dark tracking-tight dark:text-dark tracking-widest shadow-sm hover:bg-gray-400 dark:hover:bg-gray-400 focus:outline-none focus:ring-1 focus:ring-gray-400 focus:ring-offset-1 dark:focus:ring-offset-gray-500 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
