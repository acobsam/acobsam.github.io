<?php
/**
 * Search Form Template
 *
 */
?>


<div class="search-widget">
    <form method="get" class="search" action="<?php echo esc_url( home_url( '/' ) ); ?>" id="search">
        <input type="text" class="search-input" name="s" placeholder="<?php esc_html_e( 'Search...', 'myhouse' ); ?>" />
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>
</div>