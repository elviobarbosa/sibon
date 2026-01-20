<?php
$class = $args['class'];
?>
<a 
    href="<?php echo $args['url']?>" 
    class="c-link c-link--secondary c-link--next <?php echo $class?>" 
    alt="<?php echo $args['alt'] ?>">

    <?php echo $args['label'] ?>
    <?php the_SVG('ico-arrow-right') ?>
</a>