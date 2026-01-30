<?php
/**
 * Search Form Template
 * Used when calling get_search_form()
 */
?>
<form role="search" method="get" class="apex-search-form" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="sr-only" for="apex-search-field">Search for:</label>
    <div class="flex gap-2">
        <input 
            type="text" 
            name="s" 
            id="apex-search-field" 
            value="<?php echo get_search_query(); ?>" 
            placeholder="Search..." 
            class="flex-1 rounded-full border border-slate-200 px-4 py-2 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-orange-400 transition-all"
        >
        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-500 px-4 py-2 text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-400/50 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="sr-only">Search</span>
        </button>
    </div>
</form>