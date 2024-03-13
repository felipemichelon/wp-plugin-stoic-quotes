<?php

/**
 * @package RandomStoicQuotes
 */

namespace Inc\Base;

class RandomStoicQuotesConfiguration extends BaseController
{
    public $options;
    private $plugin_basename;
    private $plugin_slug;
    private $json_filename;
    private $channel_id;

    public function register() 
    {
        $this->options          = get_option('randomstoicquotes');
        $this->plugin_basename  = plugin_basename( __FILE__ );
        $this->plugin_slug      = "random_stoic_quotes";
        $this->json_filename    = "yt_teste.json";
        $this->channel_id    = "23452345234";

        add_action( 'admin_init', array( $this, 'page_init' ) );

    }

    public function page_footer (){
        return __('Plugin Version', 'my-youtube-recommendation');
    }

    public function show_notices () { 
        $value = isset( $this->options['channel_id'] ) ? esc_attr( $this->options['channel_id'] ) : '';

        if ( $value == '') {
            ?>
            <div class="error notice">
            <?php echo $this->channel_id ?>
                <p><strong><?php echo __( 'My Youtube Recommendation', 'my-youtube-recommendation' ); ?></strong></p>
                <p><?php echo __( 'Fill with your Youtube channel ID', 'my-youtube-recommendation' ); ?></p>
            </div>
            <?php
        }
    }

    public function add_settings_link ( $links ) {
        $settings_link = '<a href="admin.php?page=rsq_configuration">' . __('Settings', 'my-youtube-recommendation') . '</a>';
        array_unshift ( $links, $settings_link );
        return $links;
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