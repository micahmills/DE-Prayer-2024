<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**
 * Class Ramadan_2024_Menu
 */
class Ramadan_2024_Menu {

    public $token = 'ramadan_2024';
    public $page_title = 'Ramadan 2024';

    private static $_instance = null;

    /**
     * Ramadan_2024_Menu Instance
     *
     * Ensures only one instance of Ramadan_2024_Menu is loaded or can be loaded.
     *
     * @since 0.1.0
     * @static
     * @return Ramadan_2024_Menu instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()


    /**
     * Constructor function.
     * @access  public
     * @since   0.1.0
     */
    public function __construct() {

        $this->page_title = 'ramadan-2024';

        add_action( 'dt_prayer_campaigns_admin_install_fuel', [ 'Ramadan_2024_Tab_General', 'content' ] );
    } // End __construct()
}
Ramadan_2024_Menu::instance();

/**
 * Class Ramadan_2024_Tab_General
 */
class Ramadan_2024_Tab_General {
    public static function content() {


        ?>
        <div class="wrap">
            <div id="poststuff">
                <div id="post-body" class="metabox-holder columns-2">
                    <div id="post-body-content">
                        <!-- Main Column -->

                        <?php self::main_column() ?>

                        <!-- End Main Column -->
                    </div><!-- end post-body-content -->
                    <div id="postbox-container-1" class="postbox-container">
                        <!-- Right Column -->

                        <?php self::right_column() ?>

                        <!-- End Right Column -->
                    </div><!-- postbox-container 1 -->
                    <div id="postbox-container-2" class="postbox-container">
                    </div><!-- postbox-container 2 -->
                </div><!-- post-body meta box container -->
            </div><!--poststuff end -->
        </div><!-- wrap end -->
        <?php
    }

    public static function main_column() {
        $languages_manager = new DT_Campaign_Languages();
        $languages = $languages_manager->get_enabled_languages();
        $campaign = DT_Campaign_Settings::get_campaign();

        $translations = [];
        $installed_languages = get_available_languages( Ramadan_2024::$plugin_dir .'languages/' );
        foreach ( $installed_languages as $language ) {
            $mo = new MO();
            if ( $mo->import_from_file( Ramadan_2024::$plugin_dir . 'languages/' . $language . '.mo' ) ){
                $translations[$language] = $mo->entries;
            }
        }

        global $wpdb;
        $installed_langs_query = $wpdb->get_results( $wpdb->prepare("
            SELECT pm.meta_value, count(*) as count
            FROM $wpdb->posts p
            LEFT JOIN $wpdb->postmeta pm ON ( p.ID = pm.post_id AND meta_key = 'post_language' )
            INNER JOIN $wpdb->postmeta pm2 ON ( p.ID = pm2.post_id AND pm2.meta_key = 'linked_campaign' AND pm2.meta_value = %d )
            WHERE post_type = 'landing' and ( post_status = 'publish' or post_status = 'future')    
            GROUP BY pm.meta_value
        ", $campaign['ID'] ), ARRAY_A );
        $installed_langs = [];
        foreach ( $installed_langs_query as $result ){
            if ( $result['meta_value'] === null ){
                $result['meta_value'] = 'en_US';
            }
            if ( !isset( $installed_langs[$result['meta_value']] ) ){
                $installed_langs[$result['meta_value']] = 0;
            }
            $installed_langs[$result['meta_value']] += $result['count'];
        }


        $prayer_fuel_ready = [ 'en_US' ];

        ?>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Ramadan 2024 Prayer Fuel</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p>
                            This is the prayer fuel created for the Ramadan 2024 campaign.
                        </p>
                        <p>
                            Installing prayer fuel will create a post for each day. They will be visible here:
                            <a href="<?php echo esc_html( home_url( 'prayer/list' ) ); ?>" target="_blank">Prayer Fuel List</a>
                        </p>
                        <p>
                            Ramadan prayer fuel is available in multiple languages.
                            <a href="https://pray4movement.org/docs/translation/#2-toc-title" target="_blank">Help us translate it into your language here.</a>
                        </p>
                        <table class="">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Install</th>
                                    <th>Install in English</th>
                                    <th>Installed Posts</th>
                                    <th>Delete All</th>
                                </tr>
                            </thead>
                            <tbody>

                            <?php foreach ( $languages as $code => $language ):
                                $fuel_available = $code === 'en_US' || isset( $translations['ramadan-2024-' . $code] );
                                ?>

                                <tr class="<?php echo $language['enabled'] === false ? 'disabled-language' : '' ?>">
                                    <td><?php echo esc_html( $language['flag'] ) ?> <?php echo esc_html( $language['english_name'] ) ?></td>
                                    <td>
                                        <button class="button install-ramadan-content" value="<?php echo esc_html( $code ) ?>" <?php disabled( !$fuel_available || !in_array( $code, $prayer_fuel_ready ) ) ?>>
                                            Install prayer fuel in <?php echo esc_html( $language['flag'] ) ?>
                                        </button>
                                    </td>
                                    <td>
                                        <button class="button install-ramadan-content" value="<?php echo esc_html( $code ) ?>" data-default="true" >
                                            Install prayer fuel in English
                                        </button>
                                    </td>
                                    <td><?php echo esc_html( $installed_langs[$code] ?? 0 ); ?></td>
                                    <td>
                                        <button class="button delete-ramadan-content" value="<?php echo esc_html( $code ) ?>" <?php disabled( ( $installed_langs[$code] ?? 0 ) === 0 ) ?>>
                                            Delete all prayer fuel in <?php echo esc_html( $language['flag'] ) ?>
                                        </button>
                                    </td>

                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                        </table>

                    </td>
                </tr>
            </tbody>
        </table>
        <div id="ramadan-dialog" title="Install Prayer Fuel">
            <form id="ramadan-install-form">
                <h3>Install Ramadan Prayer Fuel in <span class="ramadan-new-language">French</span></h3>

                <p>The Ramadan has some placeholder text that needs to be replaced.</p>

                <h4>1. Replacing: [in location]</h4>
                <div style="margin-inline-start: 50px">
                    <p>
                        <strong>Example Sentence:</strong> <span id="ramadan-in-location"><?php esc_html_e( 'Jesus, give the church [in location] grace to cherish your name above all else', 'ramadan-2024' ); ?></span>
                    </p>
                    <p>
                        [in location] should be replaced with: <input id="ramadan-in-location-input" type="text" placeholder="in France, en France, etc" required>
                    </p>
                </div>

                <h4>2. Replacing: [of location]</h4>
                <div style="margin-inline-start: 50px">
                    <p>
                        <strong>Example Sentence:</strong> <span id="ramadan-of-location"><?php esc_html_e( 'let the people [of location] grasp the Good News', 'ramadan-2024' ); ?></span>
                    </p>
                    <p>
                        [of location] should be replaced with: <input id="ramadan-of-location-input" type="text" placeholder="of France, de la France, etc" required>
                    </p>
                </div>

                <h4>2. Replacing: [location]</h4>
                <div style="margin-inline-start: 50px">
                    <p>
                        <strong>Example Sentence:</strong> <span id="ramadan-location"><?php esc_html_e( 'Ask that God’s word would spread rapidly throughout [location].', 'ramadan-2024' ); ?></span>
                    </p>
                    <p>
                        [location] should be replaced with: <input id="ramadan-location-input" type="text" placeholder="Paris, la France, etc" required>
                    </p>
                </div>

                <br>
                <p>
                    This will create a post for each of the 30 days of Ramadan.
                </p>
                <button class="button" type="submit" id="ramadan-install-language">
                    Install Prayer Fuel in <span class="ramadan-new-language">French</span> <img id="ramadan-install-spinner" style="height:15px; vertical-align: middle; display: none" src="<?php echo esc_html( get_template_directory_uri() . '/spinner.svg' ) ?>"/>
                </button>
                <p>
    <!--                Please review the posts here: link @todo-->
                </p>
            </form>
        </div>

        <div id="ramadan-delete-fuel" title="Delete Fuel">
            <p>Are you sure you want to delete Prayer Fuel in <span class="ramadan-new-language">French</span></p>
            <button class="button button-primary" id="confirm-ramadan-delete">Delete
                <img id="ramadan-delete-spinner" style="height:15px; vertical-align: middle; display: none" src="<?php echo esc_html( get_template_directory_uri() . '/spinner.svg' ) ?>"/>
            </button>
            <button class="button" id="ramadan-close-delete">Cancel</button>
        </div>

        <script type="application/javascript">
            let translations = <?php echo json_encode( $translations ) ?>;
            let languages = <?php echo json_encode( $languages ) ?>;

            jQuery(document).ready(function ($){
                let code = null;
                let default_content = false
                $( "#ramadan-dialog" ).dialog({ autoOpen: false, minWidth: 600 });
                $( "#ramadan-delete-fuel" ).dialog({ autoOpen: false });

                $('.install-ramadan-content').on('click', function (){
                    $( "#ramadan-dialog" ).dialog( "open" );
                    code = $(this).val();
                    default_content = $(this).data('default');


                    $('.ramadan-new-language').html(languages[code]?.label || code)

                    if ( translations[`ramadan-2024-${code}`] && translations[`ramadan-2024-${code}`]['Jesus, give the church [in location] grace to cherish your name above all else']){
                        $('#ramadan-in-location').html( translations[`ramadan-2024-${code}`]['Jesus, give the church [in location] grace to cherish your name above all else']['translations'][0] )
                    }

                    if ( translations[`ramadan-2024-${code}`] && translations[`ramadan-2024-${code}`]['let the people [of location] grasp the Good News']){
                        $('#ramadan-of-location').html( translations[`ramadan-2024-${code}`]['let the people [of location] grasp the Good News']['translations'][0] )
                    }
                })

                $('#ramadan-install-form').on('submit', function (e){
                    e.preventDefault()
                    let in_location = $('#ramadan-in-location-input').val();
                    let of_location = $('#ramadan-of-location-input').val();
                    let location = $('#ramadan-location-input').val();
                    let ppl_group = $('#ramadan-people-group-input').val();

                    $('#ramadan-install-spinner').show()
                    $.ajax({
                        type: 'POST',
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        url: "<?php echo esc_url( rest_url() ) ?>ramadan-2024/install",
                        beforeSend: (xhr) => {
                            xhr.setRequestHeader("X-WP-Nonce",'<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>');
                        },
                        data: JSON.stringify({
                            in_location,
                            of_location,
                            location,
                            ppl_group,
                            lang: code,
                            default_content: !!default_content
                        })
                    }).then(()=>{
                        // $('#ramadan-install-spinner').hide()
                        window.location.reload()
                    })
                })

                let delete_code = null
                $('.delete-ramadan-content').on('click', function (){
                    delete_code = $(this).val();

                    $('.ramadan-new-language').html(languages[delete_code]?.label || delete_code)
                    $( "#ramadan-delete-fuel" ).dialog( "open" );
                })
                $('#ramadan-close-delete').on('click', function (){
                    $( "#ramadan-delete-fuel" ).dialog( "close" );
                })
                $('#confirm-ramadan-delete').on('click', function (){
                    $('#ramadan-delete-spinner').show()
                    $.ajax({
                        type: 'POST',
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        url: "<?php echo esc_url( rest_url() ) ?>ramadan-2024/delete",
                        beforeSend: (xhr) => {
                            xhr.setRequestHeader("X-WP-Nonce",'<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>');
                        },
                        data: JSON.stringify({
                            lang: delete_code,
                        })
                    }).then(()=>{
                        // $('#ramadan-delete-spinner').hide()
                        window.location.reload()
                    })
                })
            })


        </script>

        <br>
        <!-- End Box -->
        <?php
    }

    public static function right_column() {
        ?>
        <!-- Box -->
        <table class="widefat striped">
            <thead>
                <tr>
                    <th>Information</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    Content
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <!-- End Box -->
        <?php
    }
}

