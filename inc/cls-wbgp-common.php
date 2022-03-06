<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * Trait Common
 */
trait Wbgp_Common {
  
  protected function wbgp_get_gallery_settings_data() {
    return stripslashes_deep( unserialize( get_option('wbg_general_settings') ) );
  }
}