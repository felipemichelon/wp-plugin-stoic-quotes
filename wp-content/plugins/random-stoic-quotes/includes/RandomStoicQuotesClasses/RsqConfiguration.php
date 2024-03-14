<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\RandomStoicQuotesClasses;

if ( ! class_exists( 'RsqConfiguration' ) ) {
    class RsqConfiguration extends RsqController
    {
        public $options;
    
        public function register() 
        {
            $this->options = get_option('randomstoicquotes');
    
            add_action( 'admin_init', array( $this, 'page_init' ) );
    
        }
    
        public function create_admin_page () {
            ?>
            <div class="wrap">
                <h1><?php echo __('My Youtube Recommendation' , 'my-youtube-recommendation'); ?></h1>
                <form method="post" action="options.php">
                <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'my_yt_rec_options' );
                    do_settings_sections( 'my-yt-rec-admin' );
                    submit_button();
                ?>
                </form>
            </div>
            <?php
        }
    
        public function page_init () 
        {   
            register_setting (
                'randomstoicquotes_options',
                'randomstoicquotes',
                array ( $this, 'sanitize')
            );
    
            add_settings_section (  
                'setting_section_id_1', 
                __('General Settings', 'randomstoicquotes_translate'), 
                null, 
                'randomstoicquotes_settings_sections'
            );
    
            add_settings_field(
                'number_quotes_per_page_id', 
                __('Number of quotes per page', 'randomstoicquotes_translate'), 
                array( $this, 'number_quotes_per_page_callback' ), 
                'randomstoicquotes_settings_sections', 
                'setting_section_id_1'
            );
    
            add_settings_field(
                'show_on_admin_id', 
                __('Show on admin', 'randomstoicquotes_translate'), 
                array( $this, 'show_on_admin_callback' ), 
                'randomstoicquotes_settings_sections', 
                'setting_section_id_1'
            );
        }
        
        public function number_quotes_per_page_callback () {
            $value = isset( $this->options['quotes_per_page'] ) ? esc_attr( $this->options['quotes_per_page'] ) : (int)RSQ_NUMBER_QUOTES_PER_PAGE;
            ?>
            <input type="number" min="1" id="quotes_per_page" name="randomstoicquotes[quotes_per_page]" value="<?php echo $value ?>" class="small-text">
            <?php
        }
        
        public function show_on_admin_callback () {
            $value = isset( $this->options['show_on_admin'] ) ? esc_attr( $this->options['show_on_admin'] ) : "1";
            ?>
            <input <?php echo ($value == "on") ? 'checked' : '' ?> class="form-check-input" type="checkbox" name="randomstoicquotes[show_on_admin]" id="show_on_admin">
            <?php
        }
    
        public function sanitize ( $input ) {
            
            $new_input = array();            
    
            if ( isset ( $input['quotes_per_page'] ) )
                $new_input['quotes_per_page'] = sanitize_text_field( $input['quotes_per_page'] );
    
            if ( isset ( $input['show_on_admin'] ) )
                $new_input['show_on_admin'] = sanitize_text_field($input['show_on_admin']);
    
            return $new_input;
    
        }
    }
}