<?php
add_action('wp_ajax_carregar_mais_posts', 'carregar_mais_posts_callback');
add_action('wp_ajax_nopriv_carregar_mais_posts', 'carregar_mais_posts_callback');

if (!function_exists('carregar_mais_posts_callback')) {
  function carregar_mais_posts_callback() {

    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
    $query = new WP_Query([
      'post_type' => 'post',
      'posts_per_page' => 6,
      'paged' => $page,
    ]);

    if ($query->have_posts()) :
      while ($query->have_posts()) : $query->the_post();
          ?>
          
          <article class="item-post">
							<a href="<?php echo the_permalink() ?>" alt="Leia mais sobre: <?php echo get_the_title(); ?>">
								<?php
								if (has_post_thumbnail()) : ?>
									<div class="item-post__thumb">
										<figure>
											<?php the_post_thumbnail('medium'); ?>
										</figure>
									</div>
									<?php
								endif; ?>
								<div class="item-post__content-wrapper">
									<h2 class="item-post__title"><?php the_title(); ?></h2>
									<time class="item-post__time"><?php echo get_the_date(); ?></time>
									<p class="item-post__content"><?php echo get_the_excerpt(); ?></p>
								</div>
							</a>
						</article>
          <?php
      endwhile;
    else:
      echo '';
    endif;

    wp_reset_postdata();
    wp_die();
  }
}