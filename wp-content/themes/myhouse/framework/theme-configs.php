<?php

    /**
     * ReduxFramework Barebones Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    // This is your option name where all the Redux data is stored.
    $opt_name = "myhouse_options";
    
    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__('Myhouse Options', 'myhouse' ),
        'page_title'           => esc_html__('Myhouse Options', 'myhouse' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => 'AIzaSyBM9vxebWLN3bq4Urobnr6tEtn7zM06rEw',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'system_info'          => false,
        // REMOVE

        //'compiler'             => true,

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
    $args['admin_bar_links'][] = array(
        'id'    => 'redux-docs',
        'href'  => 'http://docs.reduxframework.com/',
        'title' => esc_html__('Documentation', 'myhouse' ),
    );

    $args['admin_bar_links'][] = array(
        //'id'    => 'redux-support',
        'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
        'title' => esc_html__('Support', 'myhouse' ),
    );

    $args['admin_bar_links'][] = array(
        'id'    => 'redux-extensions',
        'href'  => 'reduxframework.com/extensions',
        'title' => esc_html__('Extensions', 'myhouse' ),
    );

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
        'title' => esc_html__('Visit us on GitHub', 'myhouse' ),
        'icon'  => 'el el-github'
        //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
        'title' => esc_html__('Like us on Facebook', 'myhouse' ),
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://twitter.com/reduxframework',
        'title' => esc_html__('Follow us on Twitter', 'myhouse' ),
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'http://www.linkedin.com/company/redux-framework',
        'title' => esc_html__('Find us on LinkedIn', 'myhouse' ),
        'icon'  => 'el el-linkedin'
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( esc_html__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'myhouse' ), $v );
    } else {
        $args['intro_text'] = esc_html__('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'myhouse' );
    }

    // Add content after the form.
    $args['footer_text'] = esc_html__('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'myhouse' );

    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */

    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__('Theme Information 1', 'myhouse' ),
            'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'myhouse' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__('Theme Information 2', 'myhouse' ),
            'content' => esc_html__('<p>This is the tab content, HTML is allowed.</p>', 'myhouse' )
        )
    );
    Redux::setHelpTab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__('<p>This is the sidebar content, HTML is allowed.</p>', 'myhouse' );
    Redux::setHelpSidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */
    
    
    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__('General Settings', 'myhouse' ),
        'id'     => 'general',
        'desc'   => '',
        'icon'   => 'el el-icon-cogs',
        'fields' => array(
             array(
                'id' => 'favicon',
                'type' => 'media',
                'url' => true,
                'title' => esc_html__('Custom Favicon', 'myhouse'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc' => esc_html__('Upload your Favicon.', 'myhouse'),
                'subtitle' => '',
                'default' => array('url' => ''),
            ),
            array(
                'id' => 'logo',
                'type' => 'media',
                'url' => true,
                'title' => esc_html__('Logo', 'myhouse'),
                'compiler' => 'true',
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'desc' => esc_html__('Upload your logo.', 'myhouse'),
                'subtitle' => ''
            ),
            array(
                        'id' => 'apple_icon',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Apple Touch Icon', 'myhouse'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => esc_html__('Upload your Apple touch icon 57x57.', 'myhouse'),
                        'subtitle' => '',
                        'default' => array('url' => ''),
                    ),
                    array(
                        'id' => 'apple_icon_57',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Apple Touch Icon 57x57', 'myhouse'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => esc_html__('Upload your Apple touch icon 57x57.', 'myhouse'),
                        'subtitle' => '',
                        'default' => array('url' => ''),
                    ),
                    array(
                        'id' => 'apple_icon_72',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Apple Touch Icon 72x72', 'myhouse'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => esc_html__('Upload your Apple touch icon 72x72.', 'myhouse'),
                        'subtitle' => '',
                        'default' => array('url' => ''),
                    ),
                    array(
                        'id' => 'apple_icon_114',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Apple Touch Icon 114x114', 'myhouse'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => esc_html__('Upload your Apple touch icon 114x114.', 'myhouse'),
                        'subtitle' => '',
                        'default' => array('url' => ''),
                    ),
    
                    array(
                        'id' => 'countdown',
                        'type' => 'text',
                        'title' => esc_html__('Countdown Clock', 'myhouse'),
                        'subtitle' => '',
                        'desc' => '',
                        'default' => '2016/11/27'
                    ),
            
        )
    ) );
    
    Redux::setSection( $opt_name,array(
        'icon'      => 'el el-magic',
        'title'     => esc_html__('Styling Options', 'myhouse'),
        'fields'    => array(
            array(
                'id'        => 'body_style',
                'type'      => 'select',
                'title'     => esc_html__('Theme Main Layout Style', 'myhouse'),
                'subtitle'  => esc_html__('Select your themes style.', 'myhouse'),
                'options'   => array(
                                        '1' => 'Myhouse V1', 
                                        '2' => 'Myhouse V2', 
                                        '3' => 'Myhouse v3'
                                    ),
                'default'   => '1',
            ),
            
            array(
                'id' => 'body-font2',
                'type' => 'typography',
                'output' => array('body'),
                'title' => esc_html__('Body Font', 'myhouse'),
                'subtitle' => esc_html__('Specify the body font properties.', 'myhouse'),
                'google' => true,
                'default' => array(
                    'color' => '#888888',
                    'font-size' => '13px',
                    'line-height' => '24px',
                    'font-family' => "Open Sans",
                    'font-weight' => '400',
                ),
            ),
            
            array(
                'id' => 'main-color',
                'type' => 'color',
                'title' => esc_html__('Theme main Color', 'myhouse'),
                'subtitle' => esc_html__('Pick theme main color (default: #f0542d).', 'myhouse'),
                'default' => '#f0542d',
                'validate' => 'color',
            ),
            
             array(
                'id'        => 'custom-css',
                'type'      => 'ace_editor',
                'title'     => esc_html__('Custom CSS Code', 'myhouse'),
                'subtitle'  => esc_html__('Paste your CSS code here.', 'myhouse'),
                'mode'      => 'css',
                'theme'     => 'monokai',
                'desc'      => esc_attr__('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'myhouse' ),
                'default'   => "#header{\nmargin: 0 auto;\n}"
            ),
                 
           
        )
    ));
    
     Redux::setSection( $opt_name, array(
        'title'  => esc_html__('Header Settings', 'myhouse' ),
        'id'     => 'header',
        'desc'   => '',
        'icon'   => 'el el-lines',
        'fields' => array(
             array(
                'id'       => 'header-style',
                'type'     => 'select',
                'title'    => esc_html__('Select Header style', 'myhouse' ),
                'subtitle' => '',
                'desc'     => '',
                //Must provide key => value pairs for select options
                'options'  => array(
                    'default' => 'Default',
                    'vertical' => 'Vertical',
                ),
                'default'  => 'default'
            ),array(
                'id' => 'top_slider',
                'type' => 'text',
                'title' => esc_html__('Top Banner Slider shortcode (just use for Restaurant Style)', 'myhouse'),
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'default' => '',
            ),
            
        )
    ) );
    Redux::setSection( $opt_name, array(
        'title'  => esc_html__('Footer Settings', 'myhouse' ),
        'id'     => 'footer',
        'desc'   => '',
        'icon'   => 'el el-th',
        'fields' => array(
             array(
                'id'       => 'footer-bg',
                'type'     => 'media',
                'title'    => esc_html__('Footer background', 'myhouse' ),
                'subtitle' => '',
                'desc'     => '',
                'default' => array('url' => get_template_directory_uri() ."/assets/img/content/footer.jpg" ),
            ),
             array(
                'id' => 'footer-text',
                'type' => 'editor',
                'title' => esc_html__('Footer Text', 'myhouse'),
                'default' => esc_attr__('<h2>my <span style="color:#f0542d;">house</span></h2><p>Design made with  passion by Theme Eagle <br>Copyright 2015. All Rights Reserved.</p>', 'myhouse'),
            ),
        )
    ) );
    Redux::setSection( $opt_name, array(
        'icon' => 'el el-dribbble',
        'title' => esc_html__('Social Settinigs', 'myhouse'),
        'fields' => array(
            array(
                'id' => 'facebook',
                'type' => 'text',
                'title' => esc_html__('Facebook Url', 'myhouse'),
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'default' => esc_url('https://www.facebook.com/'),
            ),
            array(
                'id' => 'twitter',
                'type' => 'text',
                'title' => esc_html__('Twitter Url', 'myhouse'),
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'default' => esc_url('https://twitter.com/'),
            ),
            array(
                'id' => 'google',
                'type' => 'text',
                'title' => esc_html__('Google+ Url', 'myhouse'),
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'default' => esc_url('https://plus.google.com'),
            ),
            array(
                'id' => 'vine',
                'type' => 'text',
                'title' => esc_html__('Vine Url', 'myhouse'),
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'default' => esc_url('https://vine.co/'),
            ),
            array(
                'id' => 'pinterest',
                'type' => 'text',
                'title' => esc_html__('Pinterest Url', 'myhouse'),
                //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                'default' => esc_url('#')
            ),
        )
    )
    );
    
    /*
     * <--- END SECTIONS
     */