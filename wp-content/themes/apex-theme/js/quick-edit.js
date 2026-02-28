jQuery(document).ready(function($) {
    // Populate quick edit taxonomy checkboxes when quick edit is opened
    $(document).on('click', '.editinline', function() {
        var post_id = $(this).closest('tr').attr('id').replace('post-', '');
        
        // Populate Industries
        if (typeof apex_quick_edit !== 'undefined' && apex_quick_edit.taxonomies.success_story_industry) {
            var industry_terms = apex_quick_edit.taxonomies.success_story_industry.terms;
            var industry_checkboxes = $('input[name="success_story_industry[]"]');
            
            industry_checkboxes.prop('checked', false);
            
            // Get current terms for this post
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'apex_get_post_taxonomies',
                    post_id: post_id,
                    taxonomy: 'success_story_industry',
                    nonce: apex_quick_edit.nonce
                },
                success: function(response) {
                    if (response.success && response.data.terms) {
                        response.data.terms.forEach(function(term_id) {
                            $('input[name="success_story_industry[]"][value="' + term_id + '"]').prop('checked', true);
                        });
                    }
                }
            });
        }
        
        // Populate Regions
        if (typeof apex_quick_edit !== 'undefined' && apex_quick_edit.taxonomies.success_story_region) {
            var region_terms = apex_quick_edit.taxonomies.success_story_region.terms;
            var region_checkboxes = $('input[name="success_story_region[]"]');
            
            region_checkboxes.prop('checked', false);
            
            // Get current terms for this post
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'apex_get_post_taxonomies',
                    post_id: post_id,
                    taxonomy: 'success_story_region',
                    nonce: apex_quick_edit.nonce
                },
                success: function(response) {
                    if (response.success && response.data.terms) {
                        response.data.terms.forEach(function(term_id) {
                            $('input[name="success_story_region[]"][value="' + term_id + '"]').prop('checked', true);
                        });
                    }
                }
            });
        }
        
        // Populate Solutions
        if (typeof apex_quick_edit !== 'undefined' && apex_quick_edit.taxonomies.success_story_solution) {
            var solution_terms = apex_quick_edit.taxonomies.success_story_solution.terms;
            var solution_checkboxes = $('input[name="success_story_solution[]"]');
            
            solution_checkboxes.prop('checked', false);
            
            // Get current terms for this post
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'apex_get_post_taxonomies',
                    post_id: post_id,
                    taxonomy: 'success_story_solution',
                    nonce: apex_quick_edit.nonce
                },
                success: function(response) {
                    if (response.success && response.data.terms) {
                        response.data.terms.forEach(function(term_id) {
                            $('input[name="success_story_solution[]"][value="' + term_id + '"]').prop('checked', true);
                        });
                    }
                }
            });
        }
    });
});
