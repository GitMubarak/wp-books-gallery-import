<style type="text/css">
  .wbg-search-container .wbg-search-item .submit-btn {
    background: <?php echo esc_html( $wbg_btn_color ); ?>;
    box-shadow: 0 3px 0px 0.5px <?php echo esc_html( $wbg_btn_border_color ); ?>;
    color: <?php echo esc_html( $wbg_btn_font_color ); ?>;
  }
  .wbg-main-wrapper .wbg-item img {
    width: <?php echo ( 'full' === $wbg_book_cover_width ) ? '100%' : 'auto'; ?> !important;
    height: <?php echo ( 'full' === $wbg_book_cover_width ) ? 'auto' : '150px'; ?> !important;
  }
  .wbg-main-wrapper .wbg-item a.wbg-btn {
    background: <?php esc_html_e( $wbg_download_btn_color ); ?> !important;
    color: <?php esc_html_e( $wbg_download_btn_font_color ); ?> !important;
  }
  .wbg-main-wrapper .wbg-item .wgb-item-link {
    color: <?php esc_html_e( $wbg_title_color ); ?> !important;
    font-size: <?php esc_html_e( $wbg_title_font_size ); ?>px !important;
  }
  .wbg-main-wrapper .wbg-item .wgb-item-link:hover {
    color: <?php esc_html_e( $wbg_title_hover_color ); ?> !important;
  }
  .wbg-main-wrapper .wbg-item .wbg-description-content {
    font-size: <?php esc_html_e( $wbg_description_font_size ); ?>px !important;
    color: <?php esc_html_e( $wbg_description_color ); ?> !important;
  }
</style>