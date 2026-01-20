<?php
add_action('woocommerce_order_item_meta_end', 'display_custom_order_meta', 10, 3);

function get_invoice_url( $invoice_id ){
    $Hash = get_post_meta($invoice_id, 'invoiceID', true);
    return get_site_url(null, '?invoiceID=' . $invoice_id . '&makePreview=' . $Hash);
}

function display_custom_order_meta($item_id, $item, $order) {
    $transaction_ids = [];
    $order = wc_get_order($order->id);
    $book_ids = get_posts(array(
        'post_type' => 'mec-books',
        'posts_per_page' => -1,
        'meta_query' => array(
            '' => array(
                'key' => 'mec_order_id',
                'value' => $order->id,
                'compare' => '=',
            ),
        ),
        'fields' => 'ids',
        'meta_key' => 'invoiceID',
    ));
    $line_items = $order->get_items();
    $mec_transaction_id = $line_items[$item_id]->get_meta('mec_transaction_id', true);
    
    $invoices = array();
    foreach ($book_ids as $book_id) {
        $invoice_id = get_post_meta($book_id, 'invoiceID', true);
        $transaction_id = get_post_meta($invoice_id, 'transaction_id', true);
        
        if ($mec_transaction_id === $transaction_id) {
            $invoices[$invoice_id] = array(
                'url' => get_invoice_url($invoice_id),
                'number' => get_post_meta($invoice_id, 'invoice_number', true),
            );
        }  
			
    }
    foreach ($invoices as $invoice_id => $invoice_data) {
        echo '<a href="' . $invoice_data['url'] . '" target="_blank">' . __('Ver bilhete', 'mec-invoice') . ' #' . $invoice_data['number'] . '</a>';
    }
}
