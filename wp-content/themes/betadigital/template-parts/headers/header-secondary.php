<div class="nav-container__wrapper nav-container--secondary">
  
  <input type="checkbox" id="nav-toggle" class="nav-container__toggle">
  
  <h1>
    <a href="<?php echo home_url(); ?>">
      <svg role="img" aria-labelledby="logo-title">
        <title id="logo-title">Hub Mercantil</title>
        <use href="<?php echo SVGPATH ?>logo-hub-mercantil-black"></use>
      </svg>
      <span class="sr-only">Hub Mercantil</span>
    </a>
  </h1>
  
  <div>
    <div class="nav-container__menu js-nav-menu">
      <?php 
        wp_nav_menu( 
        array( 
          'theme_location' 	=> 'content-menu',
          'menu_class'		=> 'menu',
          'container'			=> 'nav',
          'container_class' 	=> 'main-menu'
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