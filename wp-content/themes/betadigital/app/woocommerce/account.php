<?php
add_filter('woocommerce_account_menu_items', 'remover_item_menu_conta');
function remover_item_menu_conta($menu_items) {
    unset($menu_items['downloads']); 
    return $menu_items;
}