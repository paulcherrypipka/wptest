<h3><?php _e( 'Tools', 'woocommerce-store-toolkit' ); ?></h3>

<h4><a href="<?php echo esc_url( add_query_arg( 'action', 'relink-rogue-simple-type' ) ); ?>"><?php _e( 'Re-link rogue Products to the Simple Product Type', 'woocommerce-store-toolkit' ); ?></a></h4>
<p><?php _e( 'Scan the WooCommerce Products catalogue for Products that do not have any Product Type assigned to them and assign them to the default Simple Product Type.', 'woocommerce-store-toolkit' ); ?></p>
<hr />

<h4><?php _e( 'Auto-complete Orders with 0 totals', 'woocommerce-store-toolkit' ); ?></h4>
<form method="post">
	<p><label><input type="checkbox" name="autocomplete_order" value="1"<?php checked( $autocomplete_order, 1 ); ?>><?php _e( 'Assign Completed Order Status to new Orders with 0 totals.', 'woocommerce-store-toolkit' ); ?></label></p>
	<input type="submit" value="<?php _e( 'Save changes', 'woocommerce-store-toolkit' ); ?>" class="button-primary" />
	<input type="hidden" name="action" value="autocomplete-order" />
</form>
<hr />