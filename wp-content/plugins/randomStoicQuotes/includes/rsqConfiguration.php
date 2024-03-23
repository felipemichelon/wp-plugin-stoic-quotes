<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc;

if (!class_exists('rsqConfiguration')) {
    class rsqConfiguration extends rsqController
    {
        public $rsq_options;
        public function register()
        {
            $this->rsq_options = get_option($this->default_option_name);
    
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        public function page_init()
        {
            register_setting (
                'randomstoicquotes_options',
                'randomstoicquotes',
                array ( $this, 'sanitize')
            );
    
            add_settings_section (  
                'setting_section_id_1', 
                __('General Settings', 'random-stoic-quotes'), 
                null, 
                'randomstoicquotes_settings_sections'
            );
    
            add_settings_field(
                'number_quotes_per_page_id', 
                __('Number of quotes per page', 'random-stoic-quotes'), 
                array( $this, 'number_quotes_per_page_callback' ), 
                'randomstoicquotes_settings_sections', 
                'setting_section_id_1'
            );
    
            add_settings_field(
                'show_on_admin_id', 
                __('Show on admin', 'random-stoic-quotes'), 
                array( $this, 'show_on_admin_callback' ), 
                'randomstoicquotes_settings_sections', 
                'setting_section_id_1'
            );
    
            add_settings_field(
                'show_default_quotes_id', 
                __('Show default quotes', 'random-stoic-quotes'), 
                array( $this, 'show_default_quotes_callback' ), 
                'randomstoicquotes_settings_sections', 
                'setting_section_id_1'
            );
    
            add_settings_field(
                'shortcode_id', 
                __('Shortcode use', 'random-stoic-quotes'), 
                array( $this, 'shortcode_use_callback' ), 
                'randomstoicquotes_settings_sections', 
                'setting_section_id_1'
            );
        }

        public function number_quotes_per_page_callback () {
            $value = isset( $this->rsq_options['quotes_per_page'] ) ? esc_attr( $this->rsq_options['quotes_per_page'] ) : (int)RSQ_NUMBER_QUOTES_PER_PAGE;
            ?>
            <input type="number" min="1" id="quotes_per_page" name="randomstoicquotes[quotes_per_page]" value="<?php echo $value ?>" class="small-text">
            <?php
        }
        
        public function show_on_admin_callback () {
            $value = isset( $this->rsq_options['show_on_admin'] ) ? esc_attr( $this->rsq_options['show_on_admin'] ) : "1";
            ?>
            <input <?php echo ($value == "on") ? 'checked' : '' ?> class="form-check-input" type="checkbox" name="randomstoicquotes[show_on_admin]" id="show_on_admin">
            <?php
        }
        
        public function show_default_quotes_callback () {
            $value = isset( $this->rsq_options['show_default_quotes'] ) ? esc_attr( $this->rsq_options['show_default_quotes'] ) : "1";
            ?>
            <input <?php echo ($value == "on") ? 'checked' : '' ?> class="form-check-input" type="checkbox" name="randomstoicquotes[show_default_quotes]" id="show_default_quotes">
            <?php
        }
        
        public function shortcode_use_callback () {
            $value = isset( $this->rsq_options['shortcode_use_option'] ) ? esc_attr( $this->rsq_options['shortcode_use_option'] ) : "1";
            ?>
            <input <?php echo ($value == "on") ? 'checked' : '' ?> class="form-check-input" type="checkbox" name="randomstoicquotes[shortcode_use_option]" id="shortcode_use_option">
            <label for="shortcode_use_option"><?php echo __('to use as shortcode add the following block on post page', 'random-stoic-quotes') ?>: <strong>[random_stoic_quote]</strong></label>
            <?php
        }
    
        public function sanitize ( $input ) {
            
            $new_input = array();            
    
            if ( isset ( $input['quotes_per_page'] ) )
                $new_input['quotes_per_page'] = sanitize_text_field( $input['quotes_per_page'] );
    
            if ( isset ( $input['show_on_admin'] ) )
                $new_input['show_on_admin'] = sanitize_text_field($input['show_on_admin']);
            
            if ( isset ( $input['show_default_quotes'] ) )
                $new_input['show_default_quotes'] = sanitize_text_field($input['show_default_quotes']);
            
            if ( isset ( $input['shortcode_use_option'] ) )
                $new_input['shortcode_use_option'] = sanitize_text_field($input['shortcode_use_option']);
    
            return $new_input;
    
        }
    }
}