<?php
/**
 * Widget API: WP_Widget_Text class
 *
 * @package Moral Themes
 * @subpackage Blogbook
 */

add_action( 'widgets_init', 'blogbook_register_widgets' );

function blogbook_register_widgets() {
    register_widget( 'Blogbook_Recent_Posts_Widget' );
}

/**
 * Core class used to implement a Recent Posts widget.
 *
 * @since 2.8.0
 *
 * @see WP_Widget
 */
class Blogbook_Recent_Posts_Widget extends WP_Widget {

    /**
     * Sets up a new Recent Posts widget instance.
     *
     * @since 2.8.0
     */
    public function __construct() {
        

        $widget_ops = array(
            'classname'                   => 'blogbook_recent_posts',
            'description'                 => __( 'Your site&#8217;s most recent Posts.', 'blogbook' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'blogbook-recent-posts', __( 'Blogbook Recent Posts', 'blogbook' ), $widget_ops );
    }

    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }

        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts', 'blogbook' );

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number ) {
            $number = 5;
        }
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        /**
         * Filters the arguments for the Recent Posts widget.
         *
         * @since 3.4.0
         * @since 4.9.0 Added the `$instance` parameter.
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args     An array of arguments used to retrieve the recent posts.
         * @param array $instance Array of settings for the current widget.
         */
        $r = new WP_Query(
            apply_filters(
                'blogbook_widget_posts_args', array(
                    'posts_per_page'      => $number,
                    'no_found_rows'       => true,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => true,
                ), $instance
            )
        );

        if ( ! $r->have_posts() ) {
            return;
        }
        ?>
        <?php echo $args['before_widget']; ?>
        <?php
        if ( $title ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title'];
        }
        ?>
        <ul>
            <?php foreach ( $r->posts as $recent_post ) : ?>
                <?php
                $post_title = get_the_title( $recent_post->ID );
                $title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)', 'blogbook' );
                ?>
                <li>
                    <a href="<?php the_permalink( $recent_post->ID ); ?>">
                        <?php echo get_the_post_thumbnail( $recent_post->ID, 'thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
                    </a>
                    <h3><a href="<?php the_permalink( $recent_post->ID ); ?>"><?php echo esc_html( $title ); ?></a></h3>
                    <?php if ( $show_date ) : ?>
                        <span class="post-date"><?php echo esc_html( get_the_date( '', $recent_post->ID ) ); ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Handles updating the settings for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance              = $old_instance;
        $instance['title']     = sanitize_text_field( $new_instance['title'] );
        $instance['number']    = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }

    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false; ?>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'blogbook' ); ?></label>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

        <p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'blogbook' ); ?></label>
        <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" />
        <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php _e( 'Display post date?', 'blogbook' ); ?></label></p>
<?php
    }
}

$blogbook_recent_posts_widget = new Blogbook_Recent_Posts_Widget();
