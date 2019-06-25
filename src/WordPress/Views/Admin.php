<?php
/*
 * This file is part of WordPress Widget Boilerplate
 * (c) Tom McFarlin <tom@tommcfarlin.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */
?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>">
        <?php _e( 'Title', 'josh-remote-recent-posts' ); ?>
    </label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'number' ); ?>">
        <?php _e( 'Number of posts to show', 'josh-remote-recent-posts' ); ?>
    </label>
    <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" />
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'cache_time' ); ?>"><?php _e( 'Cache Time (in minutes)' ); ?></label>
    <input class="tiny-text" id="<?php echo $this->get_field_id( 'cache_time' ); ?>" name="<?php echo $this->get_field_name( 'cache_time' ); ?>" type="number" step="1" min="1" value="<?php echo $cache_time; ?>" size="3" />
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'url' ); ?>">
        <?php _e( 'Full Remote URL', 'josh-remote-recent-posts' ); ?>
    </label>
        <p class="description">
            <?php esc_html_e( 'Example: https://torquemag.io'); ?><br><br>
            <?php esc_html_e( 'This feed requires a url to a WordPress site with REST API enabled.  You can test to see if this is set correctly by testing in your own browser (example: https://wpengine.com/wp-json/).  If you see data on the screen and not an error then the remote site has a WordPress site with REST API enabled. ', 'josh-remote-recent-posts' ); ?>
        </p>
    <input class="widefat save-input" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $url; ?>" placeholder="https://torquemag.io" />
</p>

<?php if ($categories) { ?>
<p>
    <label for="<?php echo $this->get_field_id( 'category' ); ?>">
        <?php _e( 'Catgory (slug) (count)', 'josh-remote-recent-posts' ); ?>
    </label>
    <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat .select-category" style="width:100%;">
        <option selected="" value="" style="font-style:italic">Please select a Category</option>
    <?php foreach( $categories as $category) { ?>
    <option value="<?php echo $category->id; ?>" <?php selected( $instance['category'], $category->id ); ?>><?php echo $category->name; ?>&nbsp;&lpar;<?php echo $category->slug; ?>&rpar;&nbsp;&lpar;<?php echo $category->count; ?>&rpar;</option>
    <?php } ?>      
    </select>
</p>
<?php }else { ?>
<p><span class="warning">Please Enter a valid WordPress URL to select a category.</span><br>If you do not see any categories then the URL you entered is not valid.  Please check for spaces or try another URL</p>
<?php } ?>
<!-- Save URl Everytime it's added in text field - needs refactoring eventually -->
<script type="text/javascript">
$(document).ready(function(){
    $('.save-input').change(function(){
        wpWidgets.save( $(this).closest('div.widget'), 0, 1, 0 );
        return false;
    });
});
</script>