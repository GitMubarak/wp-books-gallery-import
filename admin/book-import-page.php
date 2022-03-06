<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wbgiUploadMsg = '';
    
if ( ! empty( $_FILES['wbgi_upload']['name'] ) ) {
    if( ! $_FILES['wbgi_upload']['error'] ) {
        
        //can't be larger than 2MB
        if ( $_FILES['wbgi_upload']['size'] > ( 2000000 ) ) {
            
            //wp_die generates a visually appealing message element
            $wbgiUploadMsg = __('Your file size is to large.', WBGI_TXT_DOMAIN);
            
        } else {
            
            if ( is_uploaded_file( $_FILES['wbgi_upload']['tmp_name'] ) ) {

                $file = WBGI_PATH . 'upload/wbg-books-import.csv';

                unlink( $file );
                
                $r = move_uploaded_file( $_FILES['wbgi_upload']['tmp_name'], WBGI_PATH . 'upload/' . $_FILES['wbgi_upload']['name'] );
                
                if ( $r === false)  {

                    $wbgiUploadMsg = 'The file cannor be copied in the folder ' . WBGI_PATH . 'upload. Check if it exists and is writeable. You can also ask for support to your hosting provider.';
                
                } else {
                    
                    // insert into database
                    global $wpdb;

                    if ( ( $handle = fopen( $file, "r" ) ) !== FALSE ) {
                        
                        $header = fgetcsv( $handle, 10000, "," );
                        //print_r($header);
                        while ( ( $data = fgetcsv( $handle, 10000, ",") ) !== FALSE ) {
                            //echo '<pre>';
                            //print_r($data);

                            $post_arr = array(
                                'post_type'		=> 'books',
                                'post_title'   	=> $data[0],
                                'post_content' 	=> $data[21],
                                'post_status'  	=> 'publish',
                                'post_author'  	=> get_current_user_id(),
                                'meta_input'   => array(
                                    'wbg_status' 		=> 'active',
                                    'wbg_author' 		=> $data[2],
                                    'wbg_publisher'		=> $data[3],
                                    'wbg_published_on' 	=> date('Y-m-d', strtotime($data[4])),
                                    'wbg_isbn'			=> $data[5],
                                    'wbg_pages'			=> $data[6],
                                    'wbg_country'		=> $data[7],
                                    'wbg_language'		=> $data[8],
                                    'wbg_dimension'		=> $data[9],
                                    'wbg_filesize'		=> $data[10],
                                    'wbg_download_link' => $data[11],
                                    'wbgp_buy_link'     => $data[12],
                                    'wbg_co_publisher'  => $data[13],
                                    'wbg_isbn_13'       => $data[14],
                                    'wbgp_regular_price' => $data[15],
                                    'wbgp_sale_price'   => $data[16],
                                    'wbg_cost_type'     => $data[17],
                                    'wbg_is_featured'   => $data[18],
                                    'wbg_item_weight'   => $data[19],
                                    'wbgp_img_url'      => $data[20],
                                ),
                            );
                            
                            $post_exists = post_exists( $data[0], '', '', 'books');
                            
                            if ( ! $post_exists ) {
                                
                                $post_id = wp_insert_post( $post_arr );

                                if ( ! is_wp_error( $post_id ) ) {

                                    wp_set_object_terms( $post_id, [$data[1]], 'book_category' );

                                } else {
                                    
                                    //there was an error in the post insertion, 
                                    echo $post_id->get_error_message();
                                }
                            }

                            /*
                            $num = count( $data );
                            $row++;

                            for ( $c=0; $c < $num; $c++ ) {
                                echo $data[$c] . "<br />\n";
                            }
                            */
                        }
                        fclose( $handle );
                    }


                    $wbgiUploadMsg = __('Books Import Successful!', WBGI_TXT_DOMAIN);
                }
            }
            
        }
    }
} else {
    //set that to be the returned message
    if ( ! empty( $_FILES )) {
        $wbgiUploadMsg = $_FILES['wbgi_upload']['error'];
    }
}
?>
<div id="wph-wrap-all" class="wrap wbg-settings-page">

    <div class="settings-banner">
        <h2><i class="fa fa-download" aria-hidden="true"></i>&nbsp;<?php _e('Import Books', WBGI_TXT_DOMAIN); ?></h2>
    </div>

    <?php 
    if ( $wbgiUploadMsg ) {
        $this->wbgi_display_notification('success', $wbgiUploadMsg);
    } 
    ?>

    <div class="wbg-wrap" style="width: 100%; border: 0px solid #000;">

        <div class="wbg_personal_wrap wbg_personal_help" style="width: 75%; float: left;">
        
            <form name="wbgi_import_settings_form" role="form" enctype="multipart/form-data" class="form-horizontal" method="post" action="" id="wbgi-import-settings-form">
            <table class="wbg-general-settings-table">
                <tr>
                    <th scope="row">
                        <label><?php _e('Upload Your File', WBGI_TXT_DOMAIN); ?>:</label>
                        <br>
                        <?php _e('Only CSV file is permitted.', WBGI_TXT_DOMAIN); ?>
                    </th>
                    <td>
                        <input type="file" name="wbgi_upload" id="wbgi_upload" class="" />
                    </td>
                </tr>
            </table>
            <p class="submit"><input type="submit" id="saveImportSettings" name="saveImportSettings"
                    class="button button-primary wbg-button" value="<?php _e('Import Books', WBGI_TXT_DOMAIN); ?>"></p>
            <a href="<?php echo esc_url( WBGI_ASSETS . 'wbg-books-import.csv' ); ?>"><?php _e('Download csv format', WBGI_TXT_DOMAIN); ?></a>
            </form>

        </div>

    </div>

</div>