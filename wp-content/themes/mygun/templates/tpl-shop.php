<?php
/* Template Name: Shop */

get_header();
?>

<!--Products area start here-->
<section class="shop-page section mt-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="sibebar">
                    <div class="wighet search">
                        <form>
                            <input type="search" placeholder="Search here">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>
                    <div class="wighet categories">
                        <?php
                        $shop_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
                        $shop_categories = get_terms( array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => false,
                            'orderby'    => 'name',
                            'order'      => 'ASC',
                        ) );
                        $active_shop_cat = isset( $_GET['product_cat'] ) ? sanitize_title( wp_unslash( $_GET['product_cat'] ) ) : '';
                        $shop_base_url   = get_permalink();
                        ?>
                        <h3><?= $shop_lang === 'en' ? 'Categ<span>ories</span>' : 'კატეგ<span>ორიები</span>'; ?></h3>
                        <ul>
                            <li>
                                <a href="<?php echo esc_url( $shop_base_url ); ?>">
                                    <i class="fa fa-angle-double-right"></i><?= $shop_lang === 'en' ? 'All Products' : 'ყველა პროდუქტი'; ?>
                                </a>
                            </li>
                            <?php if ( ! empty( $shop_categories ) && ! is_wp_error( $shop_categories ) ) : ?>
                                <?php foreach ( $shop_categories as $shop_cat ) : ?>
                                    <?php $shop_cat_link = add_query_arg( 'product_cat', $shop_cat->slug, $shop_base_url ); ?>
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
                    <div class="wighet filter">
                        <h3><?= $shop_lang === 'en' ? 'Filter by <span>Price</span>' : 'ფილტრი <span>ფასით</span>'; ?></h3>
                        <div class="price-range">
                            <div class="range">
                                <div id="range-price" class="range-box"></div>
                                <span><?= $shop_lang === 'en' ? 'From :' : 'დან :'; ?></span>
                                <input type="text" id="price" class="price-box" readonly />

                            </div>
                            <button type="submit" class="btn1"><?= $shop_lang === 'en' ? 'FILTER' : 'გაფილტვრა'; ?></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 pd-0">
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
                                <p><span><?= $shop_lang === 'en' ? 'Showing 1-9' : 'აჩვენებს 1-9'; ?></span> <?= $shop_lang === 'en' ? 'of 256 Results' : '256 შედეგიდან'; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <div class="row">
                            <?php
                            $shop_paged = max( 1, absint( get_query_var( 'paged' ) ), absint( get_query_var( 'page' ) ) );
                            $shop_query_args = array(
                                'post_type'      => 'product',
                                'post_status'    => 'publish',
                                'posts_per_page' => 9,
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

                            $shop_products = new WP_Query( $shop_query_args );

                            if ( $shop_products->have_posts() ) :
                                while ( $shop_products->have_posts() ) :
                                    $shop_products->the_post();
                                    $shop_product_price = get_post_meta( get_the_ID(), '_product_price', true );
                                    $shop_product_desc  = get_the_excerpt();
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
                                                if ( $shop_product_price !== '' ) {
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
                            if ( isset( $shop_products ) && $shop_products->max_num_pages > 1 ) :
                                $shop_pagination_links = paginate_links( array(
                                    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                    'current'   => $shop_paged,
                                    'total'     => (int) $shop_products->max_num_pages,
                                    'type'      => 'array',
                                    'prev_text' => '<span>' . ( $shop_lang === 'en' ? 'Previous' : 'წინა' ) . '</span>',
                                    'next_text' => '<span>' . ( $shop_lang === 'en' ? 'Next' : 'შემდეგი' ) . '</span>',
                                    'add_args'  => ! empty( $active_shop_cat ) ? array( 'product_cat' => $active_shop_cat ) : array(),
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