<?php
/* Template Name: Homepage */

get_header();
$home_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$home_t    = function( $en, $ka ) use ( $home_lang ) {
    return $home_lang === 'en' ? $en : $ka;
};
?>

<!--Slider area start here-->
<section class="slider-area">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-sm-12 pd-0">
                <div class="item-content">
                    <div class="item-slider items1 bg-img">
                        <div class="slider_section_overlay"></div>
                        <div class="container position-relative">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="contents text-center">
                                        <h2 class="wow animated fadeInUp" data-wow-duration="1s"><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h2>
                                        <p class="mr-lu mr-ru wow animated fadeInDown" data-wow-duration="1.5s"><?= esc_html( $home_t( 'Built from a forged upper and lower AR-15 receiver with a standard barrel nut interface and mil-spec controls; The MC5 is made for abuse and high round counts.', 'შექმნილია გამძლე AR-15 სისტემაზე, სტანდარტული barrel-nut ინტერფეისით და mil-spec კონტროლებით; MC5 გათვლილია ინტენსიურ გამოყენებასა და მაღალ დატვირთვაზე.' ) ); ?></p>
                                        <div class="buttons wow animated fadeInUp" data-wow-duration="2s">
                                            <a href="#" class="btn1"><?= esc_html( $home_t( 'Buy Now', 'ყიდვა' ) ); ?></a>
                                            <a href="#" class="btn2"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-slider items2 bg-img">
                        <div class="slider_section_overlay"></div>
                        <div class="container position-relative">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="contents text-center">
                                        <h2 class="wow animated fadeInDown" data-wow-duration="1s"><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h2>
                                        <p class="mr-lu mr-ru wow animated fadeInUp" data-wow-duration="1.5s"><?= esc_html( $home_t( 'Built from a forged upper and lower AR-15 receiver with a standard barrel nut interface and mil-spec controls; The MC5 is made for abuse and high round counts.', 'შექმნილია გამძლე AR-15 სისტემაზე, სტანდარტული barrel-nut ინტერფეისით და mil-spec კონტროლებით; MC5 გათვლილია ინტენსიურ გამოყენებასა და მაღალ დატვირთვაზე.' ) ); ?></p>
                                        <div class="buttons wow animated fadeInUp" data-wow-duration="2s">
                                            <a href="#" class="btn1"><?= esc_html( $home_t( 'Buy Now', 'ყიდვა' ) ); ?></a>
                                            <a href="#" class="btn2"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-slider items3 bg-img">
                        <div class="slider_section_overlay"></div>
                        <div class="container position-relative">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="contents text-right">
                                        <h2 class="wow animated fadeInRight" data-wow-duration="1s"><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h2>
                                        <p class="mr-lu wow animated fadeInRight" data-wow-duration="1.5s"><?= esc_html( $home_t( 'Built from a forged upper and lower AR-15 receiver with a standard barrel nut interface and mil-spec controls; The MC5 is made for abuse and high round counts.', 'შექმნილია გამძლე AR-15 სისტემაზე, სტანდარტული barrel-nut ინტერფეისით და mil-spec კონტროლებით; MC5 გათვლილია ინტენსიურ გამოყენებასა და მაღალ დატვირთვაზე.' ) ); ?></p>
                                        <div class="buttons wow animated fadeInUp" data-wow-duration="2s">
                                            <a href="#" class="btn1"><?= esc_html( $home_t( 'Buy Now', 'ყიდვა' ) ); ?></a>
                                            <a href="#" class="btn2"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item-slider items4 bg-img">
                        <div class="slider_section_overlay"></div>
                        <div class="container position-relative">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="contents">
                                        <h2 class="wow animated fadeInLeft" data-wow-duration="1s"><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h2>
                                        <p class="wow animated fadeInLeft" data-wow-duration="1.5s"><?= esc_html( $home_t( 'Built from a forged upper and lower AR-15 receiver with a standard barrel nut interface and mil-spec controls; The MC5 is made for abuse and high round counts.', 'შექმნილია გამძლე AR-15 სისტემაზე, სტანდარტული barrel-nut ინტერფეისით და mil-spec კონტროლებით; MC5 გათვლილია ინტენსიურ გამოყენებასა და მაღალ დატვირთვაზე.' ) ); ?></p>
                                        <div class="buttons wow animated fadeInUp" data-wow-duration="2s">
                                            <a href="#" class="btn1"><?= esc_html( $home_t( 'Buy Now', 'ყიდვა' ) ); ?></a>
                                            <a href="#" class="btn2"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="item-thumbnail">
                        <a href="#" class="col-sm-3" data-slide-index="0">
                            <div class="items">
                                <div class="dbox">
                                    <div class="dleft">
                                        <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/sliders/sm-1.jpg" alt=""></figure>
                                    </div>
                                    <div class="dright">
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                            <p>$1,499.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="col-sm-3" data-slide-index="1">
                            <div class="items">
                                <div class="dbox">
                                    <div class="dleft">
                                        <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/sliders/sm-2.jpg" alt=""></figure>
                                    </div>
                                    <div class="dright">
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                            <p>$1,499.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="col-sm-3" data-slide-index="2">
                            <div class="items">
                                <div class="dbox">
                                    <div class="dleft">
                                        <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/sliders/sm-3.jpg" alt=""></figure>
                                    </div>
                                    <div class="dright">
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                            <p>$1,499.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="col-sm-3" data-slide-index="3">
                            <div class="items">
                                <div class="dbox">
                                    <div class="dleft">
                                        <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/sliders/sm-4.jpg" alt=""></figure>
                                    </div>
                                    <div class="dright">
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                            <p>$1,499.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Slider area end here-->


<!--Products area start here-->
<section class="products-area section bg-img jarallax">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="section-heading">
                    <h2><?= esc_html( $home_t( 'Our Products', 'ჩვენი პროდუქტები' ) ); ?></h2>
                    <p><?= esc_html( $home_t( 'All modern weapons can appreciate our broad services and premium support.', 'თანამედროვე იარაღის მოყვარულებისთვის გთავაზობთ ფართო სერვისებს და ხარისხიან მხარდაჭერას.' ) ); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 pro-ctg">
                <div class="row">
                    <?php
                    $home_product_terms = get_terms( array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                        'number'     => 4,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ) );
                    $shop_pages = get_pages( array(
                        'meta_key'    => '_wp_page_template',
                        'meta_value'  => 'templates/tpl-shop.php',
                        'number'      => 1,
                    ) );
                    $shop_page_url = ! empty( $shop_pages ) ? get_permalink( $shop_pages[0]->ID ) : home_url( '/shop/' );

                    if ( ! empty( $home_product_terms ) && ! is_wp_error( $home_product_terms ) ) :
                        foreach ( $home_product_terms as $cat_index => $home_term ) :
                            $cat_card_class = ( $cat_index % 2 ) ? 'catagories-lists nd' : 'catagories-lists';
                            $term_icon_meta = get_term_meta( $home_term->term_id, 'icon', true );
                            if ( empty( $term_icon_meta ) ) {
                                $term_icon_meta = get_term_meta( $home_term->term_id, 'icon_url', true );
                            }
                            if ( empty( $term_icon_meta ) ) {
                                $term_icon_meta = get_term_meta( $home_term->term_id, 'image', true );
                            }
                            if ( empty( $term_icon_meta ) ) {
                                $term_icon_meta = get_term_meta( $home_term->term_id, 'thumbnail_id', true );
                            }

                            $cat_icon_url = '';
                            if ( is_numeric( $term_icon_meta ) ) {
                                $cat_icon_url = wp_get_attachment_image_url( (int) $term_icon_meta, 'medium' );
                            } elseif ( is_string( $term_icon_meta ) && filter_var( $term_icon_meta, FILTER_VALIDATE_URL ) ) {
                                $cat_icon_url = $term_icon_meta;
                            }
                            if ( empty( $cat_icon_url ) ) {
                                $cat_icon_url = get_template_directory_uri() . '/assets/images/products/' . ( ( $cat_index % 4 ) + 1 ) . '.png';
                            }
                            $cat_link       = add_query_arg( 'product_cat', $home_term->slug, $shop_page_url );
                    ?>
                    <div class="col-md-3 col-sm-6 pd-0">
                        <a href="<?php echo esc_url( $cat_link ); ?>" style="display:block;">
                            <div class="<?php echo esc_attr( $cat_card_class ); ?>">
                                <div class="contents">
                                    <figure><img src="<?php echo esc_url( $cat_icon_url ); ?>" alt="<?php echo esc_attr( $home_term->name ); ?>" /></figure>
                                    <h3><?php echo esc_html( $home_term->name ); ?></h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 pd-0">
                <div class="pro-sliders">
                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/1.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/2.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/3.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/4.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/1.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/2.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="products">
                            <figure><img src="<?php echo get_template_directory_uri(); ?>/assets/images/products/3.jpg" alt="" /></figure>
                            <div class="contents">
                                <h3><?= esc_html( $home_t( 'MC5 Carbine', 'MC5 კარაბინი' ) ); ?></h3>
                                <span>$1,499.00</span>
                                <a href="#" class="btn4"><?= esc_html( $home_t( 'Add To Cart', 'კალათაში დამატება' ) ); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="load-btn text-center mr-t80">
                    <a href="#" class="btn1"><?= esc_html( $home_t( 'View All', 'ყველას ნახვა' ) ); ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Products area end here-->

<!--About area start here-->
<section class="about-area section bg-img jarallax">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-sm-12">
                <div class="section-heading2">
                    <h2><?= esc_html( $home_t( 'Who We Are', 'ვინ ვართ ჩვენ' ) ); ?></h2>
                </div>
                <div class="about-contents">
                    <p><?= esc_html( $home_t( 'With state-of-the-art indoor training facilities and a full-service custom shop, we can accommodate most requests.', 'თანამედროვე დახურული სასწავლო ინფრასტრუქტურით და სრულფასოვანი სერვისით, ჩვენ ვაკმაყოფილებთ თქვენს უმეტეს მოთხოვნას.' ) ); ?></p>
                    <blockquote><?= esc_html( $home_t( 'This platform modernizes the purchasing process and gives customers a faster, easier experience.', 'ეს პლატფორმა შესყიდვის პროცესს ამარტივებს და მომხმარებელს აძლევს უფრო სწრაფ და მოსახერხებელ გამოცდილებას.' ) ); ?></blockquote>
                    <p><?= esc_html( $home_t( 'Our experienced team provides broad services and practical support for modern weapon enthusiasts.', 'ჩვენი გამოცდილი გუნდი თანამედროვე იარაღის მოყვარულებს სთავაზობს ფართო სერვისებს და პრაქტიკულ მხარდაჭერას.' ) ); ?></p>
                    <div class="buttons">
                        <a href="#" class="btn1"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?></a>
                        <a href="#" class="btn2"><?= esc_html( $home_t( 'Our Shop', 'ჩვენი მაღაზია' ) ); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 ">
                <div class="about-cata">
                    <div class="cata-list list-t1">
                        <div class="dbox">
                            <div class="dleft">
                                <div class="content">
                                    <h4><?= esc_html( $home_t( 'Hunting', 'ნადირობა' ) ); ?></h4>
                                    <a href="#" class="btn3"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?><i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="dright">
                                <div class="cate-ico">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/01.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cata-list list-t2">
                        <div class="dbox">
                            <div class="dleft">
                                <div class="content">
                                    <h4><?= esc_html( $home_t( 'Training', 'ვარჯიში' ) ); ?></h4>
                                    <a href="#" class="btn3"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?><i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="dright">
                                <div class="cate-ico">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/02.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cata-list list-t1">
                        <div class="dbox">
                            <div class="dleft">
                                <div class="content">
                                    <h4><?= esc_html( $home_t( 'Shooting Range', 'სასროლი მოედანი' ) ); ?></h4>
                                    <a href="#" class="btn3"><?= esc_html( $home_t( 'Read More', 'დაწვრილებით' ) ); ?><i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                            <div class="dright">
                                <div class="cate-ico">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/03.png" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--About area end here-->


<!--Gallery area start here-->
<section class="gallery-area section2 bg-img jarallax position-relative">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="section-heading">
                    <?php $gallery_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka'; ?>
                    <h2><?= $gallery_lang === 'en' ? 'Video Gallery' : 'ვიდეო გალერეა'; ?></h2>
                    <p><?= $gallery_lang === 'en' ? 'Watch our latest weapon showcases and video highlights.' : 'ნახეთ ჩვენი უახლესი იარაღის მიმოხილვები და ვიდეო გამორჩეულები.'; ?></p>
                </div>
            </div>
            <div class="gallery col-sm-12 pd-0 position-relative">
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 pd-0">
                        <div class="row">
                            <div class="col-sm-12 mr-b30">
                                <div class="gimg">
                                    <figure>
                                        <a href="assets/images/gallery/1.jpg">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/1.jpg" alt="" />
                                            <div class="con-pop">
                                                <span><i class="fas fa-search"></i></span>
                                            </div>
                                        </a>
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'Bullets Roll', 'ტყვიების შოუ' ) ); ?></h3>
                                            <p><?= esc_html( $home_t( 'All modern weapon lovers can enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.' ) ); ?></p>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <div class="col-sm-12 mr-b30">
                                <div class="gimg">
                                    <figure>
                                        <a href="assets/images/gallery/4.jpg">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/4.jpg" alt="" />
                                            <div class="con-pop">
                                                <span><i class="fas fa-search"></i></span>
                                            </div>
                                        </a>
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'Bullets Roll', 'ტყვიების შოუ' ) ); ?></h3>
                                            <p><?= esc_html( $home_t( 'All modern weapon lovers can enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.' ) ); ?></p>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pd-0">
                        <div class="col-sm-12 mr-b30">
                            <div class="gimg">
                                <figure>
                                    <a href="assets/images/gallery/2.jpg">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/2.jpg" alt="" />
                                        <div class="con-pop">
                                            <span><i class="fas fa-search"></i></span>
                                        </div>
                                    </a>
                                    <div class="content">
                                        <h3><?= esc_html( $home_t( 'Bullets Roll', 'ტყვიების შოუ' ) ); ?></h3>
                                        <p><?= esc_html( $home_t( 'All modern weapon lovers can enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.' ) ); ?></p>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12 pd-0">
                        <div class="row">
                            <div class="col-sm-12 mr-b30">
                                <div class="gimg">
                                    <figure>
                                        <a href="assets/images/gallery/3.jpg">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/3.jpg" alt="" />
                                            <div class="con-pop">
                                                <span><i class="fas fa-search"></i></span>
                                            </div>
                                        </a>
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'Bullets Roll', 'ტყვიების შოუ' ) ); ?></h3>
                                            <p><?= esc_html( $home_t( 'All modern weapon lovers can enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.' ) ); ?></p>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                            <div class="col-sm-12 mr-b30">
                                <div class="gimg">
                                    <figure>
                                        <a href="assets/images/gallery/6.jpg">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/6.jpg" alt="" />
                                            <div class="con-pop">
                                                <span><i class="fas fa-search"></i></span>
                                            </div>
                                        </a>
                                        <div class="content">
                                            <h3><?= esc_html( $home_t( 'Bullets Roll', 'ტყვიების შოუ' ) ); ?></h3>
                                            <p><?= esc_html( $home_t( 'All modern weapon lovers can enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.' ) ); ?></p>
                                        </div>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12 pd-0 position-relative">
                        <div class="col-sm-12 mr-b30  lst_div_box_galery d-md-block d-sm-none d-none">
                            <div class="gimg">
                                <figure>
                                    <a href="assets/images/gallery/5.jpg">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gallery/5.jpg" alt="" />
                                        <div class="con-pop">
                                            <span><i class="fas fa-search"></i></span>
                                        </div>
                                    </a>
                                    <div class="content">
                                        <h3><?= esc_html( $home_t( 'Bullets Roll', 'ტყვიების შოუ' ) ); ?></h3>
                                        <p><?= esc_html( $home_t( 'All modern weapon lovers can enjoy our broad services.', 'თანამედროვე იარაღის მოყვარულებისთვის გვაქვს ფართო სერვისები.' ) ); ?></p>
                                    </div>
                                </figure>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Gallery area end here-->
<!--Trainning area Start here-->
<section class="training-area section bg-img jarallax af">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="training-forms">
                    <form>
                        <fieldset>
                            <input type="text" placeholder="<?= esc_attr( $home_t( 'Full Name', 'სრული სახელი' ) ); ?>">
                        </fieldset>
                        <fieldset>
                            <input type="email" placeholder="<?= esc_attr( $home_t( 'Email Address', 'ელფოსტის მისამართი' ) ); ?>">
                        </fieldset>
                        <fieldset>
                            <input type="text" placeholder="<?= esc_attr( $home_t( 'Phone No.', 'ტელეფონის ნომერი' ) ); ?>">
                        </fieldset>
                        <fieldset>
                            <select>
                                <option><?= esc_html( $home_t( 'Weapon / Plans', 'იარაღი / გეგმები' ) ); ?></option>
                                <option><?= esc_html( $home_t( 'Basic Training Plan', 'საბაზისო სასწავლო გეგმა' ) ); ?></option>
                                <option><?= esc_html( $home_t( 'Advanced Training Plan', 'გაფართოებული სასწავლო გეგმა' ) ); ?></option>
                                <option><?= esc_html( $home_t( 'Premium Shooting Plan', 'პრემიუმ სასროლო გეგმა' ) ); ?></option>
                            </select>
                        </fieldset>
                        <fieldset class="arrows">
                            <div class="row">
                                <div class="col-md-5 col-sm-6 pd-0">
                                    <select>
                                        <option><?= esc_html( $home_t( 'Gender', 'სქესი' ) ); ?></option>
                                        <option><?= esc_html( $home_t( 'Male', 'კაცი' ) ); ?></option>
                                        <option><?= esc_html( $home_t( 'Female', 'ქალი' ) ); ?></option>
                                    </select>
                                </div>
                                <div class="col-md-7 col-sm-6 pd-r0">
                                    <input type="number" placeholder="<?= esc_attr( $home_t( 'Age', 'ასაკი' ) ); ?>">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <textarea placeholder="<?= esc_attr( $home_t( 'Message', 'შეტყობინება' ) ); ?>"></textarea>
                        </fieldset>
                        <button type="submit" class="btn1"><?= esc_html( $home_t( 'Send Now', 'გაგზავნა' ) ); ?></button>
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="training-con pd-t60">
                    <h2><?= esc_html( $home_t( 'Weapon Trainings', 'იარაღის ვარჯიშები' ) ); ?></h2>
                    <p><?= esc_html( $home_t( 'With state-of-the-art indoor training facilities and full service custom shop, we can accommodate most requests.', 'თანამედროვე ინფრასტრუქტურითა და სრულფასოვანი სერვისით, ჩვენ ვაკმაყოფილებთ თქვენს მოთხოვნებს.' ) ); ?></p>
                    <h1>P. +880 451 455</h1>
                    <p><?= esc_html( $home_t( 'Our team provides practical guidance, safe training methods, and personalized support for all experience levels.', 'ჩვენი გუნდი გთავაზობთ პრაქტიკულ გზამკვლევს, უსაფრთხო ვარჯიშის მეთოდებს და ინდივიდუალურ მხარდაჭერას ყველა დონეზე.' ) ); ?></p>
                    <ul>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?= esc_html( $home_t( 'Handgun Training Full Pack', 'პისტოლეტის სრული სასწავლო პაკეტი' ) ); ?></li>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?= esc_html( $home_t( 'Machine Gun CS5 Full Pack', 'ავტომატის CS5 სრული პაკეტი' ) ); ?></li>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?= esc_html( $home_t( 'Custom Shooting Range Training', 'ინდივიდუალური სასროლო მოედნის ვარჯიში' ) ); ?></li>
                        <li><i class="fas fa-long-arrow-alt-right"></i><?= esc_html( $home_t( 'Hunting and Tactical Shooting Programs', 'ნადირობისა და ტაქტიკური სროლის პროგრამები' ) ); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Trainning area End here-->

<!--Blog area start here-->
<?php
$hp_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$hp_news_posts = get_posts( array(
    'post_type'      => array( 'news', 'post' ),
    'numberposts'    => 10,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
));

if ( ! empty( $hp_news_posts ) ) :
    // First post for the left featured area
    $featured = $hp_news_posts[0];
    $f_cats = get_the_terms( $featured->ID, 'news_cat' );
    if ( ! $f_cats || is_wp_error( $f_cats ) ) $f_cats = get_the_terms( $featured->ID, 'category' );
    $f_cat_names = ( $f_cats && ! is_wp_error( $f_cats ) ) ? implode( ', ', wp_list_pluck( $f_cats, 'name' ) ) : '';
    $f_thumb = get_the_post_thumbnail_url( $featured->ID, 'large' );

    // Remaining posts for slider (minimum 3 slides needed)
    $slider_posts = array_slice( $hp_news_posts, 1 );
    if ( empty( $slider_posts ) ) $slider_posts = $hp_news_posts;
    while ( count( $slider_posts ) < 3 ) {
        $slider_posts = array_merge( $slider_posts, $hp_news_posts );
    }
    $slider_posts = array_slice( $slider_posts, 0, 7 );
?>
<section class="blog-area section bg-img jarallax">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="section-heading">
                    <h2><?= $hp_lang === 'en' ? 'Latest News' : 'სიახლეები'; ?></h2>
                    <p><?= $hp_lang === 'en' ? 'Stay up to date with our latest news and updates.' : 'იყავი კურსში უახლესი სიახლეებისა და განახლებების შესახებ.'; ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 pd-0">
                <div class="news_left_wrapper"<?php if ( $f_thumb ) : ?> style="background-image:url('<?= esc_url( $f_thumb ); ?>'); background-size:cover; background-position:center;"<?php endif; ?>>
                    <div class="news_left_img_overlay"></div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="news_left_cont position-relative">
                                <?php if ( $f_cat_names ) : ?>
                                    <p><i><?= esc_html( $f_cat_names ); ?></i></p>
                                <?php endif; ?>
                                <div class="heart_box">
                                    <a href="<?= get_permalink( $featured->ID ); ?>"><i class="fa fa-heart"></i></a>
                                </div>
                                <h6><i class="fa fa-calendar-alt"></i><?= get_the_date( 'd-M-Y', $featured->ID ); ?></h6>
                                <h3><?= esc_html( $featured->post_title ); ?></h3>
                                <h5><a href="<?= get_permalink( $featured->ID ); ?>"><?= $hp_lang === 'en' ? 'Read More' : 'სრულად'; ?></a> &nbsp;<i class="fa fa-long-arrow-alt-right"></i></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 pd-0">
                <div class="ln-sliders">
                    <?php foreach ( $slider_posts as $sp ) :
                        $s_cats = get_the_terms( $sp->ID, 'news_cat' );
                        if ( ! $s_cats || is_wp_error( $s_cats ) ) $s_cats = get_the_terms( $sp->ID, 'category' );
                        $s_cat_names = ( $s_cats && ! is_wp_error( $s_cats ) ) ? implode( ', ', wp_list_pluck( $s_cats, 'name' ) ) : '';
                    ?>
                    <div class="col-sm-12">
                        <div class="main_news_right_box">
                            <div class="news_right_box1_wrapper">
                                <div class="news_right_box1">
                                    <?php if ( $s_cat_names ) : ?>
                                        <p><?= esc_html( $s_cat_names ); ?></p>
                                    <?php endif; ?>
                                    <h3><?= esc_html( $sp->post_title ); ?></h3>
                                    <h6><i class="fa fa-calendar-alt"></i><?= get_the_date( 'd-M-Y', $sp->ID ); ?></h6>
                                    <div class="news_border_bottom"></div>
                                </div>
                            </div>
                            <div class="news_botton_cont">
                                <p><?= wp_trim_words( $sp->post_excerpt ? $sp->post_excerpt : $sp->post_content, 12, '...' ); ?></p>
                                <h5><a href="<?= get_permalink( $sp->ID ); ?>"><?= $hp_lang === 'en' ? 'Read More' : 'სრულად'; ?></a> &nbsp;<i class="fa fa-long-arrow-alt-right"></i></h5>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<!--Blog area end here-->


<!--Subscribe area start here-->
<section class="subscribe-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="subscribe">
                    <span class="ico"><i class="far fa-envelope"></i></span>
                    <div class="conts">
                        <h2><?= esc_html( $home_t( 'Get Our Latest News', 'მიიღეთ უახლესი სიახლეები' ) ); ?></h2>
                        <p><?= esc_html( $home_t( 'Subscribe to our newsletter now!', 'გამოიწერეთ ჩვენი ნიუსლეთერი ახლავე!' ) ); ?></p>
                    </div>
                    <form>
                        <input type="email" placeholder="<?= esc_attr( $home_t( 'Email Address', 'ელფოსტის მისამართი' ) ); ?>">
                        <button type="submit" class="btn1"><?= esc_html( $home_t( 'Subscribe', 'გამოწერა' ) ); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Subscribe area End here-->

<?php get_footer(); ?>