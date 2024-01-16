<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

//wp i18n make-pot . languages/default.pot --skip-audit --subtract="languages/terms-to-exclude.pot"

class P4_Ramadan_2024_Content {

    public static function install_content( $language = 'en_US', $names = [], $from_translation = null ) {
        $campaign = DT_Campaign_Settings::get_campaign();
        if ( empty( $campaign ) ) {
            dt_write_log( 'Campaign not set' );
            return false;
        }
        $start = $campaign['start_date']['formatted'] ?? '';
        if ( empty( $start ) ) {
            dt_write_log( 'Start date not set' );
            return false;
        }

        $installed = [];
        $content = self::content( $language, $names, $from_translation ?? $language );
        foreach ( $content as $i => $day ) {

            $title = gmdate( 'F j Y', strtotime( $start . ' + ' . $i . ' day' ) );
            $date = gmdate( 'Y-m-d', strtotime( $start . ' + ' . $i . ' day' ) );
            $slug = str_replace( ' ', '-', strtolower( gmdate( 'F j Y', strtotime( $start . ' + ' . $i . ' day' ) ) ) );
            $post_content = implode( '', wp_unslash( $day['content'] ) );

//            $day = DT_Campaign_Fuel::what_day_in_campaign( $post_date );

            $args = [
                'post_title'    => $title,

                'post_content'  => $post_content,
                'post_excerpt'  => $day['excerpt'],
                'post_type'  => PORCH_LANDING_POST_TYPE,
                'post_status'   => 'publish',
                'post_author'   => get_current_user_id(),
                'meta_input' => [
                    PORCH_LANDING_META_KEY => $slug,
                    'post_language' => $language,
                    'day' => $i + 1,
                    'fuel_tag' => 'ramadan_2024',
                    'linked_campaign' => $campaign['ID'],
                ]
            ];

            $installed[] = wp_insert_post( $args );

        }

        return $installed;
    }

    public static function content( $language, $names, $from_translation = 'en_US' ) {

        $fields = $names;
        add_filter( 'determine_locale', function ( $locale ) use ( $from_translation ) {
            if ( ! empty( $from_translation ) ) {
                return $from_translation;
            }
            return $locale;
        }, 1001, 1 );
        if ( $from_translation !== 'en_US' ){
            load_plugin_textdomain( 'ramadan-2024', false, trailingslashit( dirname( plugin_basename( __FILE__ ), 2 ) ) . 'languages' );
        }

        $data = [

        ];


        function ramadan_format_message( $message, $fields ) {
            $message = make_clickable( $message );
            $message = str_replace( '[in location]', !empty( $fields['in_location'] ) ? $fields['in_location'] : '[in location]', $message );
            $message = str_replace( '[of location]', !empty( $fields['of_location'] ) ? $fields['of_location'] : '[of location]', $message );
            $message = str_replace( '[people_group]', !empty( $fields['ppl_group'] ) ? $fields['ppl_group'] : '[people_group]', $message );
            return nl2br( $message );
        }

        $content = [];
        foreach ( $data as $index => $d ){

            $number = $index +1;
            if ( $number < 10 ){
                $number = '0' . $number;
            }

            $image = '';
            if ( file_exists( Ramadan_2024::$plugin_dir . 'images/' . $number . '.jpg' ) ) {
                $image = '<figure class="wp-block-image p4m_prayer_image"><img src="' . plugins_url( 'images/' . $number . '.jpg', __DIR__ ) . '" alt="' . $number . '"  /></figure >';
            }

            $content[] = [
                'excerpt' => wp_kses_post( ramadan_format_message( $d[0], $fields ) ),
                'content' => [
                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Our Treasure in Jesus', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[0], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Testimonies from Around the World', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[1], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Biblical Prayers', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[2], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Prayer Walk', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[3], $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',

                    '<!-- wp:image -->',
                    $image,
                    '<!-- /wp:image -->',

                    '<!-- wp:heading {"level":3} -->',
                    '<h3><strong>' . __( 'Inspirational Quotes', 'ramadan-2024' ) . '</strong></h3>',
                    '<!-- /wp:heading -->',

                    '<!-- wp:paragraph -->',
                    '<p>' . wp_kses_post( ramadan_format_message( $d[4], $fields ) ) . '</p>',
                    '<p>' . esc_html( ramadan_format_message( __( 'How could this quote inspire you to pray for [people_group]? For yourself?', 'ramadan-2024' ), $fields ) ) . '</p>',
                    '<!-- /wp:paragraph -->',
                ]
            ];
        }
        return $content;
    }
}