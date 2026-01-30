<?php
/**
 * Comments Template
 * Displays comments and comment form with Apex theme styling
 */

// Prevent direct access
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area mt-12 pt-8 border-t border-slate-200">
    
    <?php if (have_comments()) : ?>
        <!-- Comments Header -->
        <h3 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
            <?php
            $comment_count = get_comments_number();
            printf(
                _n('%d Comment', '%d Comments', $comment_count, 'apex-theme'),
                $comment_count
            );
            ?>
        </h3>

        <!-- Comments List -->
        <ol class="comment-list space-y-6 list-none p-0 m-0">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 48,
            ));
            ?>
        </ol>

        <!-- Comments Pagination -->
        <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
            <nav class="comment-navigation mt-8 flex justify-between items-center">
                <div class="nav-previous">
                    <?php previous_comments_link('&larr; Older Comments'); ?>
                </div>
                <div class="nav-next">
                    <?php next_comments_link('Newer Comments &rarr;'); ?>
                </div>
            </nav>
        <?php endif; ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments text-slate-500 text-center py-8 bg-slate-50 rounded-xl">
            Comments are closed.
        </p>
    <?php endif; ?>

    <?php if (comments_open()) : ?>
        <!-- Comment Form -->
        <div class="comment-respond mt-8 pt-8 border-t border-slate-200">
            <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Leave a Comment
            </h3>
            
            <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                <p class="text-slate-600">You must be <a href="<?php echo wp_login_url(get_permalink()); ?>" class="text-orange-500 hover:text-orange-600">logged in</a> to post a comment.</p>
            <?php else : ?>
                <form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" id="commentform" class="space-y-6">
                    
                    <?php if (is_user_logged_in()) : ?>
                        <p class="logged-in-as text-sm text-slate-600">
                            Logged in as <a href="<?php echo admin_url('profile.php'); ?>" class="text-orange-500 hover:text-orange-600 font-medium"><?php echo wp_get_current_user()->display_name; ?></a>. 
                            <a href="<?php echo wp_logout_url(get_permalink()); ?>" class="text-slate-500 hover:text-red-500">Log out?</a>
                        </p>
                    <?php else : ?>
                        <p class="comment-notes text-sm text-slate-500 mb-4">Your email address will not be published. Required fields are marked <span class="text-red-500">*</span></p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="comment-form-author">
                                <label for="author" class="block text-sm font-medium text-slate-700 mb-2">Name <span class="text-red-500">*</span></label>
                                <input id="author" name="author" type="text" required class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-orange-400 transition-all" />
                            </div>
                            <div class="comment-form-email">
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email <span class="text-red-500">*</span></label>
                                <input id="email" name="email" type="email" required class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-orange-400 transition-all" />
                            </div>
                        </div>
                        
                        <div class="comment-form-url">
                            <label for="url" class="block text-sm font-medium text-slate-700 mb-2">Website</label>
                            <input id="url" name="url" type="url" class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-orange-400 transition-all" />
                        </div>
                    <?php endif; ?>
                    
                    <div class="comment-form-comment">
                        <label for="comment" class="block text-sm font-medium text-slate-700 mb-2">Comment <span class="text-red-500">*</span></label>
                        <textarea id="comment" name="comment" rows="6" required class="w-full rounded-lg border border-slate-200 px-4 py-3 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 focus:border-orange-400 transition-all resize-y" placeholder="Write your comment here..."></textarea>
                    </div>
                    
                    <div class="form-submit">
                        <input name="submit" type="submit" id="submit" class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-3 text-base font-semibold text-white hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-400/50 transition-all shadow-lg cursor-pointer" value="Post Comment" />
                        <?php comment_id_fields(); ?>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</div><!-- #comments -->
