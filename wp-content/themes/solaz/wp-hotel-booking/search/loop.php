<?php

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

global $hb_settings;
$gallery  = $room->gallery;
$featured = $gallery ? array_shift( $gallery ) : false;
?>
<li class="hb-room clearfix">

    <form name="hb-search-results" class="hb-search-room-results">
		<?php do_action( 'hotel_booking_loop_before_item', $room->post->ID ); ?>
        <div class="hb-room-content">
            <div class="hb-room-thumbnail">
				<?php if ( $featured ): ?>
                    <a class="hb-room-gallery" data-fancybox-group="hb-room-gallery-<?php echo esc_attr( $room->post->ID ); ?>" data-lightbox="hb-room-gallery[<?php echo esc_attr( $room->post->ID ); ?>]" data-title="<?php echo esc_attr( $featured['alt'] ); ?>" href="<?php echo esc_attr( $featured['src'] ); ?>">
						<?php $room->getImage( 'catalog' ); ?>
                    </a>
				<?php endif; ?>
            </div>

            <div class="hb-room-info">
                <h4 class="hb-room-name">
                    <a href="<?php echo get_the_permalink( $room->ID ) ?>">
						<?php echo esc_html( $room->name ); ?><?php $room->capacity_title ? printf( '(%s)', $room->capacity_title ) : ''; ?>
                    </a>
                </h4>
                <ul class="hb-room-meta">
                    <li class="hb_search_capacity">
                        <label><?php esc_html_e( 'Capacity:', 'solaz' ); ?></label>
                        <div class=""><?php echo esc_html( $room->capacity ); ?></div>
                    </li>
                    <li class="hb_search_max_child">
                        <label><?php esc_html_e( 'Max Child:', 'solaz' ); ?></label>
                        <div><?php echo esc_html( $room->max_child ); ?></div>
                    </li>
                    <li class="hb_search_price">
                        <label><?php esc_html_e( 'Price:', 'solaz' ); ?></label>
                        <span class="hb_search_item_price"><?php echo hb_format_price( $room->amount_singular ); ?></span>
                        <div class="hb_view_price">
                            <a href="" class="hb-view-booking-room-details"><?php _e( '(View price breakdown)', 'solaz' ); ?></a>
							<?php hb_get_template( 'search/booking-room-details.php', array( 'room' => $room ) ); ?>
                        </div>
                    </li>
                    <li class="hb_search_quantity">
                        <label><?php esc_html_e( 'Quantity: ', 'solaz' ); ?></label>
                        <div>
							<?php
							hb_dropdown_numbers(
								array(
									'name'             => 'hb-num-of-rooms',
									'min'              => 1,
									'show_option_none' => esc_html__( 'Select', 'solaz' ),
									'max'              => $room->post->available_rooms,
									'class'            => 'number_room_select'
								)
							);
							?>
                        </div>
                    </li>
                    <li class="hb_search_add_to_cart">
                        <button class="hb_add_to_cart"><?php esc_html_e( 'Select this room', 'solaz' ) ?></button>
                    </li>
                </ul>
            </div>
        </div>

		<?php wp_nonce_field( 'hb_booking_nonce_action', 'nonce' ); ?>
        <input type="hidden" name="check_in_date" value="<?php echo date( 'm/d/Y', hb_get_request( 'hb_check_in_date' ) ); ?>" />
        <input type="hidden" name="check_out_date" value="<?php echo date( 'm/d/Y', hb_get_request( 'hb_check_out_date' ) ); ?>">
        <input type="hidden" name="room-id" value="<?php echo esc_attr( $room->post->ID ); ?>">
        <input type="hidden" name="hotel-booking" value="cart">
        <input type="hidden" name="action" value="hotel_booking_ajax_add_to_cart" />

		<?php do_action( 'hotel_booking_loop_after_item', $room->post->ID ); ?>
    </form>
	<?php if ( ( isset( $atts['gallery'] ) && $atts['gallery'] === 'true' ) || $hb_settings->get( 'enable_gallery_lightbox' ) ): ?>
		<?php hb_get_template( 'loop/gallery-lightbox.php', array( 'room' => $room ) ) ?>
	<?php endif; ?>
</li>