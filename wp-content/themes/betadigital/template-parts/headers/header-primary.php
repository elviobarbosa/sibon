<div class="nav-container__wrapper nav-container--primary">
  
  <input type="checkbox" id="nav-toggle" class="nav-container__toggle">
  
  <h1>
    <a href="<?php echo home_url(); ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/dist/images/bmp/sibon-charters-logo.png" alt="Sibon Charters">
      <span class="sr-only">Sibon Charters</span>
    </a>
  </h1>
  
  <div>
    <div class="nav-container__menu js-nav-menu">
      <?php 
        wp_nav_menu( 
        array( 
          'theme_location' 	=> 'header-menu',
          'menu_class'		=> 'menu',
          'container'			=> 'nav',
          'container_class' 	=> 'main-menu',
        ) ); 
      ?>
    </div>
    
    <div class="nav-container__control">
      <label for="nav-toggle" class="h-menu">
        <span class="h-menu__line"></span>
        <span class="h-menu__line"></span>
        <span class="h-menu__line"></span>
      </label>
    </div>
  </div>
  
  <label for="nav-toggle" class="nav-overlay"></label>
</div>