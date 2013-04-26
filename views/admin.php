<p>
    <label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php _e( 'Title', MD_PP_LOCALE ) ?></label>
    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" placeholder="<?php _e( 'Widget title', MD_PP_LOCALE ) ?>" value="<?php echo $title ?>"/>
</p>

<p>
    <label for="<?php echo $this->get_field_id( 'max_posts' ) ?>"><?php _e( 'Max number of posts', MD_PP_LOCALE ) ?></label><br />
    <input type="number" id="<?php echo $this->get_field_id( 'max_posts' ) ?>" name="<?php echo $this->get_field_name( 'max_posts' ) ?>" value="<?php echo $max_posts ?>"/>
</p>