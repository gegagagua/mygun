<?php
/* Template Name: Shop */

get_header();
?>

<!--Products area start here-->
<section class="shop-page section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="sibebar mygun-shop-sidebar">
                    <?php
                    $shop_lang         = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
                    $active_shop_cat   = isset( $_GET['product_cat'] ) ? sanitize_title( wp_unslash( $_GET['product_cat'] ) ) : '';
                    $shop_base_url     = get_permalink();
                    $shop_optics_get        = isset( $_GET['mygun_optics'] ) ? sanitize_text_field( wp_unslash( $_GET['mygun_optics'] ) ) : '';
                    $shop_stock_included_get = isset( $_GET['mygun_stock_included'] ) ? sanitize_text_field( wp_unslash( $_GET['mygun_stock_included'] ) ) : '';
                    $shop_categories   = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ) );
                    $mygun_tax_labels = function_exists( 'mygun_product_spec_public_tax_labels' ) ? mygun_product_spec_public_tax_labels() : array();
                    $mygun_shop_tax_order = array(
                        'mygun_charging',
                        'mygun_caliber',
                        'mygun_firearm_type',
                        'mygun_double_barrel',
                        'mygun_location',
                        'mygun_delivery',
                        'mygun_installment',
                        'mygun_item_state',
                        'mygun_seller',
                    );
                    ?>
                    <form class="mygun-shop-filters" method="get" action="<?php echo esc_url( $shop_base_url ); ?>">
                        <?php if ( $active_shop_cat !== '' ) : ?>
                            <input type="hidden" name="product_cat" value="<?php echo esc_attr( $active_shop_cat ); ?>" />
                        <?php endif; ?>

                        <div class="wighet categories">
                            <h3><?= $shop_lang === 'en' ? 'Categ<span>ories</span>' : 'კატეგ<span>ორიები</span>'; ?></h3>
                            <ul>
                                <li>
                                    <a href="<?php echo esc_url( $shop_base_url ); ?>">
                                        <i class="fa fa-angle-double-right"></i><?= $shop_lang === 'en' ? 'All Products' : 'ყველა პროდუქტი'; ?>
                                    </a>
                                </li>
                                <?php if ( ! empty( $shop_categories ) && ! is_wp_error( $shop_categories ) ) : ?>
                                    <?php foreach ( $shop_categories as $shop_cat ) : ?>
                                        <?php
                                        $shop_cat_filter_args = function_exists( 'mygun_shop_collect_filter_query_args' ) ? mygun_shop_collect_filter_query_args() : array();
                                        unset( $shop_cat_filter_args['product_cat'] );
                                        $shop_cat_link = add_query_arg( array_merge( $shop_cat_filter_args, array( 'product_cat' => $shop_cat->slug ) ), $shop_base_url );
                                        ?>
                                        <li>
                                            <a href="<?php echo esc_url( $shop_cat_link ); ?>"<?php echo $active_shop_cat === $shop_cat->slug ? ' class="active"' : ''; ?>>
                                                <i class="fa fa-angle-double-right"></i><?php echo esc_html( $shop_cat->name ); ?>
                                                <span><?php echo (int) $shop_cat->count; ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="wighet filter mygun-filter-optics">
                            <label class="mygun-filter-select-label" for="mygun_shop_optics"><?= $shop_lang === 'en' ? 'Optics' : 'ოპტიკა'; ?></label>
                            <select id="mygun_shop_optics" name="mygun_optics" class="mygun-filter-select widefat">
                                <option value="" <?php selected( $shop_optics_get, '' ); ?>><?= $shop_lang === 'en' ? 'All' : 'ყველა'; ?></option>
                                <option value="yes" <?php selected( $shop_optics_get, 'yes' ); ?>><?= $shop_lang === 'en' ? 'Yes' : 'დიახ'; ?></option>
                                <option value="no" <?php selected( $shop_optics_get, 'no' ); ?>><?= $shop_lang === 'en' ? 'No' : 'არა'; ?></option>
                            </select>
                        </div>

                        <div class="wighet filter mygun-filter-stock-included">
                            <label class="mygun-filter-select-label" for="mygun_shop_stock_included"><?= $shop_lang === 'en' ? 'Stock' : 'კონდახი'; ?></label>
                            <select id="mygun_shop_stock_included" name="mygun_stock_included" class="mygun-filter-select widefat">
                                <option value="" <?php selected( $shop_stock_included_get, '' ); ?>><?= $shop_lang === 'en' ? 'All' : 'ყველა'; ?></option>
                                <option value="yes" <?php selected( $shop_stock_included_get, 'yes' ); ?>><?= $shop_lang === 'en' ? 'Yes' : 'დიახ'; ?></option>
                                <option value="no" <?php selected( $shop_stock_included_get, 'no' ); ?>><?= $shop_lang === 'en' ? 'No' : 'არა'; ?></option>
                            </select>
                        </div>

                        <?php
                        foreach ( $mygun_shop_tax_order as $tax ) :
                            if ( ! taxonomy_exists( $tax ) || ! isset( $mygun_tax_labels[ $tax ] ) ) {
                                continue;
                            }
                            $terms = get_terms( array( 'taxonomy' => $tax, 'hide_empty' => false ) );
                            if ( is_wp_error( $terms ) || empty( $terms ) ) {
                                continue;
                            }
                            $sel_slugs = function_exists( 'mygun_product_spec_tax_slugs_from_request' ) ? mygun_product_spec_tax_slugs_from_request( $tax ) : array();
                            $sel_one   = ! empty( $sel_slugs ) ? $sel_slugs[0] : '';
                            $lab       = $mygun_tax_labels[ $tax ][ $shop_lang === 'en' ? 'en' : 'ka' ];
                            ?>
                            <div class="wighet mygun-filter-select-wrap">
                                <label class="mygun-filter-select-label" for="mygun_shop_<?php echo esc_attr( $tax ); ?>"><?php echo esc_html( $lab ); ?></label>
                                <select id="mygun_shop_<?php echo esc_attr( $tax ); ?>" name="<?php echo esc_attr( $tax ); ?>" class="mygun-filter-select widefat">
                                    <option value=""><?php echo esc_html( $shop_lang === 'en' ? 'All' : 'ყველა' ); ?></option>
                                    <?php foreach ( $terms as $term ) : ?>
                                        <?php
                                        $tl = function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $term, $shop_lang ) : $term->name;
                                        ?>
                                        <option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $sel_one, $term->slug ); ?>><?php echo esc_html( $tl ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>

                        <details class="mygun-filter-block wighet">
                            <summary><?= $shop_lang === 'en' ? 'Magazine capacity' : 'მჭიდის ტევადობა'; ?></summary>
                            <div class="mygun-range-row">
                                <input type="number" name="mygun_mag_min" min="0" step="1" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'From' : 'დან' ); ?>" value="<?php echo isset( $_GET['mygun_mag_min'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_mag_min'] ) ) ) : ''; ?>" />
                                <input type="number" name="mygun_mag_max" min="0" step="1" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'To' : 'მდე' ); ?>" value="<?php echo isset( $_GET['mygun_mag_max'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_mag_max'] ) ) ) : ''; ?>" />
                            </div>
                        </details>
                        <details class="mygun-filter-block wighet">
                            <summary><?= $shop_lang === 'en' ? 'Length (mm)' : 'სიგრძე'; ?></summary>
                            <div class="mygun-range-row">
                                <input type="number" name="mygun_len_min" min="0" step="1" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'From' : 'დან' ); ?>" value="<?php echo isset( $_GET['mygun_len_min'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_len_min'] ) ) ) : ''; ?>" />
                                <input type="number" name="mygun_len_max" min="0" step="1" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'To' : 'მდე' ); ?>" value="<?php echo isset( $_GET['mygun_len_max'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_len_max'] ) ) ) : ''; ?>" />
                            </div>
                        </details>
                        <details class="mygun-filter-block wighet">
                            <summary><?= $shop_lang === 'en' ? 'Weight (g)' : 'წონა'; ?></summary>
                            <div class="mygun-range-row">
                                <input type="number" name="mygun_w_min" min="0" step="1" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'From' : 'დან' ); ?>" value="<?php echo isset( $_GET['mygun_w_min'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_w_min'] ) ) ) : ''; ?>" />
                                <input type="number" name="mygun_w_max" min="0" step="1" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'To' : 'მდე' ); ?>" value="<?php echo isset( $_GET['mygun_w_max'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_w_max'] ) ) ) : ''; ?>" />
                            </div>
                        </details>

                        <?php
                        $body_tax = 'mygun_body';
                        if ( taxonomy_exists( $body_tax ) && isset( $mygun_tax_labels[ $body_tax ] ) ) :
                            $body_terms = get_terms( array( 'taxonomy' => $body_tax, 'hide_empty' => false ) );
                            if ( ! is_wp_error( $body_terms ) && ! empty( $body_terms ) ) :
                                $body_sel_slugs = function_exists( 'mygun_product_spec_tax_slugs_from_request' ) ? mygun_product_spec_tax_slugs_from_request( $body_tax ) : array();
                                $body_sel_one    = ! empty( $body_sel_slugs ) ? $body_sel_slugs[0] : '';
                                $body_lab        = $mygun_tax_labels[ $body_tax ][ $shop_lang === 'en' ? 'en' : 'ka' ];
                                ?>
                            <div class="wighet mygun-filter-select-wrap mygun-filter-body-wrap">
                                <label class="mygun-filter-select-label" for="mygun_shop_body"><?php echo esc_html( $body_lab ); ?></label>
                                <select id="mygun_shop_body" name="<?php echo esc_attr( $body_tax ); ?>" class="mygun-filter-select widefat">
                                    <option value=""><?php echo esc_html( $shop_lang === 'en' ? 'All' : 'ყველა' ); ?></option>
                                    <?php foreach ( $body_terms as $body_term ) : ?>
                                        <?php
                                        $btl = function_exists( 'mygun_product_spec_term_label' ) ? mygun_product_spec_term_label( $body_term, $shop_lang ) : $body_term->name;
                                        ?>
                                        <option value="<?php echo esc_attr( $body_term->slug ); ?>" <?php selected( $body_sel_one, $body_term->slug ); ?>><?php echo esc_html( $btl ); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                                <?php
                            endif;
                        endif;
                        ?>

                        <div class="wighet filter mygun-filter-price">
                            <h3><?= $shop_lang === 'en' ? 'Filter by <span>price</span>' : 'ფილტრი <span>ფასით</span>'; ?></h3>
                            <div class="mygun-range-row">
                                <input type="number" name="mygun_price_min" min="0" step="0.01" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'Min ₾' : 'მინ. ₾' ); ?>" value="<?php echo isset( $_GET['mygun_price_min'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_price_min'] ) ) ) : ''; ?>" />
                                <input type="number" name="mygun_price_max" min="0" step="0.01" placeholder="<?php echo esc_attr( $shop_lang === 'en' ? 'Max ₾' : 'მაქს. ₾' ); ?>" value="<?php echo isset( $_GET['mygun_price_max'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_GET['mygun_price_max'] ) ) ) : ''; ?>" />
                            </div>
                        </div>

                        <div class="wighet filter mygun-filter-submit-wrap">
                            <button type="submit" class="btn1"><?= $shop_lang === 'en' ? 'FILTER' : 'გაფილტვრა'; ?></button>
                            <?php
                            $clear_url = $shop_base_url;
                            if ( $active_shop_cat !== '' ) {
                                $clear_url = add_query_arg( 'product_cat', $active_shop_cat, $clear_url );
                            }
                            ?>
                            <a class="mygun-filter-clear" href="<?php echo esc_url( $clear_url ); ?>"><?= $shop_lang === 'en' ? 'Clear filters' : 'გასუფთავება'; ?></a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-9 pd-0">
                <?php
                $shop_paged      = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
                $shop_per_page   = 9;
                $shop_query_args = array(
                    'post_type'      => 'product',
                    'post_status'    => 'publish',
                    'posts_per_page' => $shop_per_page,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'paged'          => $shop_paged,
                );

                if ( ! empty( $active_shop_cat ) ) {
                    $shop_query_args['tax_query'] = array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => $active_shop_cat,
                        ),
                    );
                }

                $shop_query_args = function_exists( 'mygun_shop_apply_filters_to_query' ) ? mygun_shop_apply_filters_to_query( $shop_query_args ) : $shop_query_args;
                $shop_products   = new WP_Query( $shop_query_args );
                $shop_total      = (int) $shop_products->found_posts;
                $shop_start      = $shop_total > 0 ? ( ( $shop_paged - 1 ) * $shop_per_page + 1 ) : 0;
                $shop_end        = min( $shop_paged * $shop_per_page, $shop_total );
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="filter-area">
                            <select>
                                <option><?= $shop_lang === 'en' ? 'Sort by' : 'დალაგება'; ?></option>
                                <option><?= $shop_lang === 'en' ? 'Newest' : 'უახლესი'; ?></option>
                                <option><?= $shop_lang === 'en' ? 'Price: Low to High' : 'ფასი: დაბლიდან მაღლისკენ'; ?></option>
                                <option><?= $shop_lang === 'en' ? 'Price: High to Low' : 'ფასი: მაღლიდან დაბლისკენ'; ?></option>
                            </select>
                            <div class="list-grid">
                                <ul class="list-inline">
                                    <li><a href="#" id="gridview"><i class="fa fa-th"></i></a></li>
                                    <li><a href="#" id="listview"><i class="fa fa-list"></i></a></li>
                                </ul>
                            </div>
                            <div class="showpro">
                                <p><span><?php echo esc_html( $shop_lang === 'en' ? "Showing {$shop_start}-{$shop_end}" : "აჩვენებს {$shop_start}-{$shop_end}" ); ?></span> <?php echo esc_html( $shop_lang === 'en' ? "of {$shop_total} results" : "{$shop_total} შედეგიდან" ); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <div class="row">
                            <?php
                            if ( $shop_products->have_posts() ) :
                                while ( $shop_products->have_posts() ) :
                                    $shop_products->the_post();
                                    $shop_product_price = get_post_meta( get_the_ID(), '_product_price', true );
                                    if ( $shop_product_price === '' || $shop_product_price === false ) {
                                        $shop_product_price = get_post_meta( get_the_ID(), '_price', true );
                                    }
                                    $shop_product_desc = get_the_excerpt();
                                    if ( empty( $shop_product_desc ) ) {
                                        $shop_product_desc = wp_trim_words( wp_strip_all_tags( get_the_content() ), 22, '...' );
                                    }
                                    ?>
                                    <div class="col-sm-4 products">
                                        <figure>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if ( has_post_thumbnail() ) : ?>
                                                    <?php the_post_thumbnail( 'medium_large', array( 'alt' => get_the_title() ) ); ?>
                                                <?php else : ?>
                                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/products/1.jpg' ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" />
                                                <?php endif; ?>
                                            </a>
                                        </figure>
                                        <div class="contents">
                                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                            <p><?php echo esc_html( $shop_product_desc ); ?></p>
                                            <span>
                                                <?php
                                                if ( $shop_product_price !== '' && $shop_product_price !== false ) {
                                                    echo esc_html( $shop_product_price ) . ' ₾';
                                                } else {
                                                    echo $shop_lang === 'en' ? 'Price on request' : 'ფასი მოთხოვნით';
                                                }
                                                ?>
                                            </span>
                                            <a href="<?php the_permalink(); ?>" class="btn4"><?= $shop_lang === 'en' ? 'View Product' : 'პროდუქტის ნახვა'; ?></a>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                ?>
                                <div class="col-sm-12">
                                    <p class="text-center" style="padding: 20px 0; color:#aaa;">
                                        <?= $shop_lang === 'en' ? 'No products found.' : 'პროდუქტები ვერ მოიძებნა.'; ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="paginations">
                            <?php
                            $shop_pagination_add_args = function_exists( 'mygun_shop_collect_filter_query_args' ) ? mygun_shop_collect_filter_query_args() : array();
                            if ( isset( $shop_products ) && $shop_products->max_num_pages > 1 ) :
                                $shop_pagination_links = paginate_links( array(
                                    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                    'current'   => $shop_paged,
                                    'total'     => (int) $shop_products->max_num_pages,
                                    'type'      => 'array',
                                    'prev_text' => '<span>' . ( $shop_lang === 'en' ? 'Previous' : 'წინა' ) . '</span>',
                                    'next_text' => '<span>' . ( $shop_lang === 'en' ? 'Next' : 'შემდეგი' ) . '</span>',
                                    'add_args'  => $shop_pagination_add_args,
                                ) );
                                if ( ! empty( $shop_pagination_links ) ) :
                                    ?>
                                    <ul>
                                        <?php foreach ( $shop_pagination_links as $shop_pagination_link ) : ?>
                                            <li><?php echo wp_kses_post( $shop_pagination_link ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php
                                endif;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Products area end here-->

<?php get_footer(); ?>
