<?php
/**
 * Template part for a single post card in the post grid.
 * Expected globals or args: $settings (array)
 */
?>
<div class="post-grid-card">
    <?php if ('yes' === $settings['show_image'] && has_post_thumbnail()) : ?>
        <div class="post-grid-image">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('large'); ?>
            </a>
        </div>
    <?php elseif('yes' === $settings['show_image']): ?>
        <div class="post-grid-image">
            <a href="<?php the_permalink(); ?>">
            <img src='https://developers.elementor.com/docs/assets/img/elementor-placeholder-image.png' alt='placeholder'>
            </a>
        </div>
    <?php endif; ?>

    <div class="post-grid-content">
        <?php if ('yes' === $settings['show_category']) : ?>
            <div class="post-grid-category">
                <?php 
                $categories = get_the_category();
                if (!empty($categories)) {
                    foreach($categories as $cat){
                    echo '<a href="' . esc_url(get_category_link($cat->term_id)) . '">' . esc_html($cat->name) . '</a>';
                    }
                }
                ?>
            </div>
        <?php endif; ?>

        <h3 class="post-grid-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <?php if ('yes' === $settings['show_author'] || 'yes' === $settings['show_date']) : ?>
            <div class="post-grid-meta">
                <?php if ('yes' === $settings['show_author']) : ?>
                    <span class="post-grid-author">
                        <?php esc_html_e('By', 'elementor-addon'); ?> 
                        <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                            <?php the_author(); ?>
                        </a>
                    </span>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_author'] && 'yes' === $settings['show_date']) : ?>
                    <span class="post-grid-separator"> | </span>
                <?php endif; ?>

                <?php if ('yes' === $settings['show_date']) : ?>
                    <span class="post-grid-date">
                        <?php echo get_the_date(); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ('yes' === $settings['show_excerpt']) : ?>
            <div class="post-grid-excerpt">
                <?php 
                $excerpt = get_the_excerpt();
                $excerpt = wp_trim_words($excerpt, $settings['excerpt_length']);
                echo wp_kses_post($excerpt);
                ?>
            </div>
        <?php endif; ?>

        <?php if ('yes' === $settings['show_read_more']) : ?>
            <div class="post-grid-read-more">
                <a href="<?php the_permalink(); ?>">
                    <?php echo esc_html($settings['read_more_text']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
