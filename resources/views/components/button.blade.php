<button
    :class="getCurrentClasses"
    type="button"
    class="inline-flex items-center justify-center px-7 py-3 border text-base leading-6 rounded-sm focus:outline-none transition ease-in-out duration-150 w-full bg-blue-700 hover:bg-blue-600
        focus:border-blue-600 active:bg-blue-600 
        focus:shadow-outline-blue
        border-blue-700 text-gray-50
        hover:text-gray-50 active:text-gray-50"
>
    <slot></slot>
</button>