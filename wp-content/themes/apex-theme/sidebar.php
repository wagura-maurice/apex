<!-- side-column -->
<aside class="side-column w-full lg:w-80 flex-shrink-0 bg-slate-50">
<?php if (is_active_sidebar('sidebar1')) : ?>
<div class="space-y-6">
<div class="sidebar-widgets-wrapper bg-white rounded-2xl shadow-md border border-slate-200 p-6">
<?php dynamic_sidebar('sidebar1'); ?>
</div>
</div>
<?php else : ?>
<!-- Default sidebar content when no widgets -->
<div class="space-y-6">
<!-- Search Widget -->
<div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-10 lg:p-12">
<h3 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">Search</h3>
<?php get_search_form(); ?>
</div>

<!-- Categories Widget -->
<div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-10 lg:p-12">
<h3 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">Categories</h3>
<ul class="space-y-1">
<?php
$categories = get_categories(['orderby' => 'count', 'order' => 'DESC', 'number' => 10]);
foreach ($categories as $cat) :
?>
<li>
<a href="<?php echo get_category_link($cat->term_id); ?>" class="flex items-center justify-between p-3 rounded-lg hover:bg-orange-50 transition-colors">
<span class="text-slate-600"><?php echo $cat->name; ?></span>
<span class="text-xs text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full"><?php echo $cat->count; ?></span>
</a>
</li>
<?php endforeach; ?>
</ul>
</div>

<!-- Recent Posts Widget -->
<div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-10 lg:p-12">
<h3 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">Recent Posts</h3>
<ul class="space-y-1">
<?php
$recent_posts = wp_get_recent_posts(['numberposts' => 5, 'post_status' => 'publish']);
foreach ($recent_posts as $post) :
?>
<li>
<a href="<?php echo get_permalink($post['ID']); ?>" class="block p-3 rounded-lg hover:bg-orange-50 transition-colors">
<span class="text-sm font-medium text-slate-700 line-clamp-2"><?php echo $post['post_title']; ?></span>
<span class="text-xs text-slate-400 mt-1 block"><?php echo get_the_date('M j, Y', $post['ID']); ?></span>
</a>
</li>
<?php endforeach; wp_reset_query(); ?>
</ul>
</div>

<!-- Recent Comments Widget -->
<div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 sm:p-10 lg:p-12">
<h3 class="text-lg font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">Recent Comments</h3>
<ul class="space-y-3">
<?php
$recent_comments = get_comments(array(
'number' => 5,
'status' => 'approve',
'post_status' => 'publish'
));
foreach ($recent_comments as $comment) :
?>
<li>
<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#comment-<?php echo $comment->comment_ID; ?>" class="block p-3 rounded-lg hover:bg-orange-50 transition-colors border-l-2 border-transparent hover:border-orange-400">
<div class="flex items-start gap-2.5">
<div class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0 mt-0.5">
<?php echo strtoupper(substr(get_comment_author($comment), 0, 1)); ?>
</div>
<div class="flex-1 min-w-0">
<p class="text-sm font-semibold text-slate-800"><?php echo get_comment_author($comment); ?></p>
<p class="text-xs text-slate-500 line-clamp-2 mt-0.5"><?php echo wp_trim_words($comment->comment_content, 12); ?></p>
<p class="text-xs text-slate-400 mt-1">on <span class="text-slate-500"><?php echo get_the_title($comment->comment_post_ID); ?></span></p>
</div>
</div>
</a>
</li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php endif; ?>
</aside><!-- /side-column -->
