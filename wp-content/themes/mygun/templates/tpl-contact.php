<?php
/* Template Name: Contact */

get_header();
$contact_lang = function_exists( 'pll_current_language' ) ? pll_current_language() : 'ka';
$contact_t    = function( $en, $ka ) use ( $contact_lang ) {
    return $contact_lang === 'en' ? $en : $ka;
};
?>

<!--Breadcumb area start here-->
<section class="breadcumb-area jarallax bg-img af">
    <div class="breadcumb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="content">
                        <h2><?= esc_html( $contact_t( 'Contact Us', 'დაგვიკავშირდით' ) ); ?></h2>
                        <ul>
                            <li><a href="<?= esc_url( home_url( '/' ) ); ?>"><?= esc_html( $contact_t( 'Home', 'მთავარი' ) ); ?></a></li>
                            <li><a href="javascript:void(0)"><?= esc_html( $contact_t( 'Contact', 'კონტაქტი' ) ); ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Breadcumb area end here-->
<!--Contact area start here-->
<section class="contact-area section">
    <div class="container">
        <div class="row mr-b50">
            <div class="col-lg-4 col-md-12 col-xs-12 col-sm-12">
                <div class="contact-info">
                    <span><i class="fa fa-map-marker"></i></span>
                    <p><?= esc_html( $contact_t( 'Sector #48, 123 Street,', 'სექტორი #48, ქუჩა 123,' ) ); ?>
                        <br><?= esc_html( $contact_t( 'Colony, INDIA', 'კოლონია, ინდოეთი' ) ); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-xs-12 col-sm-12">
                <div class="contact-info">
                    <span><i class="fa fa-phone"></i></span>
                    <p>+8100 376 6284,</p>
                    <p>+8100 255 6858 </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-xs-12 col-sm-12">
                <div class="contact-info">
                    <span><i class="fa fa-envelope"></i></span>
                    <p>weapons@example.com</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="section-heading">
                    <h2><?= esc_html( $contact_t( 'Get in Touch', 'დაგვიკავშირდით' ) ); ?></h2>
                    <p><?= esc_html( $contact_t( 'All modern weapon enthusiasts can appreciate our broad services and support.', 'თანამედროვე იარაღის მოყვარულებისთვის ჩვენ გვაქვს ფართო სერვისები და მხარდაჭერა.' ) ); ?></p>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-area">
                    <form>
                        <?php wp_nonce_field( 'mygun_contact_nonce', 'contact_nonce' ); ?>
                        <fieldset>
                            <div class="row">
                                <div class="col-sm-4 col-xs-12 feld">
                                    <input type="text" class="require" placeholder="<?= esc_attr( $contact_t( 'Full Name *', 'სრული სახელი *' ) ); ?>" name="full_name">
                                    <span><i class="fa fa-user"></i></span>
                                </div>
                                <div class="col-sm-4 col-xs-12 feld">
                                    <input type="text" class="require" placeholder="<?= esc_attr( $contact_t( 'Email *', 'ელფოსტა *' ) ); ?>" name="email">
                                    <span><i class="fa fa-envelope"></i></span>
                                </div>
                                <div class="col-sm-4 col-xs-12 feld">
                                    <input type="text" class="require" placeholder="<?= esc_attr( $contact_t( 'Subject', 'თემა' ) ); ?>" name="subject">
                                    <span><i class="fa fa-star"></i></span>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="feld">
                                <textarea placeholder="<?= esc_attr( $contact_t( 'Message', 'შეტყობინება' ) ); ?>" class="require" name="message"></textarea>
                                <span class="msg"><i class="fa fa-pencil-square-o"></i></span>
                            </div>
                        </fieldset>
                        <div class="btn-area text-center">
                            <div class="response"></div>
                            <input type="hidden" name="form_type" value="contact">
                            <div class="btn-center">
                                <button type="button" class="submitForm btn1"><span><?= esc_html( $contact_t( 'Send Now', 'გაგზავნა' ) ); ?></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Contact area end here-->

<?php get_footer(); ?>