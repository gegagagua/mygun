<?php
/* Template Name: Contact */

get_header();

$c_address = mygun_opt( 'contact_address', mygun_t( 'Tbilisi, Georgia', 'თბილისი, საქართველო', 'Тбилиси, Грузия' ) );
$c_hours   = mygun_opt( 'contact_hours', mygun_t( 'Mon–Sat: 10:00 – 19:00', 'ორშ–შაბ: 10:00 – 19:00', 'Пн–Сб: 10:00 – 19:00' ) );
$c_phone   = mygun_opt_raw( 'contact_phone', '+995 555 555 555' );
$c_phone2  = mygun_opt_raw( 'contact_phone2', '' );
$c_email   = mygun_opt_raw( 'contact_email', 'info@mygun.ge' );
$c_map     = mygun_opt_raw( 'contactp_map', '' );
?>

<!--Breadcrumb area start here-->
<section class="mygun-page-hero">
    <div class="container">
        <h1><?php echo esc_html( mygun_opt( 'contactp_heading', mygun_t( 'Contact Us', 'დაგვიკავშირდით', 'Свяжитесь с нами' ) ) ); ?></h1>
        <p class="mygun-breadcrumb">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( mygun_t( 'Home', 'მთავარი', 'Главная' ) ); ?></a>
            <span>/</span> <?php echo esc_html( mygun_t( 'Contact', 'კონტაქტი', 'Контакты' ) ); ?>
        </p>
    </div>
</section>
<!--Breadcrumb area end here-->

<!--Contact area start here-->
<section class="contact-area section">
    <div class="container">
        <div class="row mygun-contact-grid">
            <div class="col-lg-5 col-md-12">
                <div class="mygun-contact-info-card">
                    <h2><?php echo esc_html( mygun_opt( 'contactp_info_heading', mygun_t( 'Contact Information', 'საკონტაქტო ინფორმაცია', 'Контактная информация' ) ) ); ?></h2>
                    <p class="mygun-contact-intro"><?php echo esc_html( mygun_opt( 'contactp_subheading', mygun_t( 'Reach out to us — our team is ready to help with any question about our products and services.', 'დაგვიკავშირდით — ჩვენი გუნდი მზადაა დაგეხმაროთ ნებისმიერ კითხვაზე ჩვენი პროდუქციისა და სერვისების შესახებ.', 'Свяжитесь с нами — наша команда готова помочь с любым вопросом о товарах и услугах.' ) ) ); ?></p>

                    <ul class="mygun-contact-list">
                        <li>
                            <span class="ico"><i class="fa fa-map-marker-alt"></i></span>
                            <div><strong><?php echo esc_html( mygun_t( 'Address', 'მისამართი', 'Адрес' ) ); ?></strong><p><?php echo esc_html( $c_address ); ?></p></div>
                        </li>
                        <li>
                            <span class="ico"><i class="fa fa-phone-alt"></i></span>
                            <div><strong><?php echo esc_html( mygun_t( 'Phone', 'ტელეფონი', 'Телефон' ) ); ?></strong>
                                <p><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $c_phone ) ); ?>"><?php echo esc_html( $c_phone ); ?></a>
                                <?php if ( $c_phone2 ) : ?><br><a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $c_phone2 ) ); ?>"><?php echo esc_html( $c_phone2 ); ?></a><?php endif; ?></p>
                            </div>
                        </li>
                        <li>
                            <span class="ico"><i class="fa fa-envelope"></i></span>
                            <div><strong><?php echo esc_html( mygun_t( 'Email', 'ელფოსტა', 'Email' ) ); ?></strong><p><a href="mailto:<?php echo esc_attr( $c_email ); ?>"><?php echo esc_html( $c_email ); ?></a></p></div>
                        </li>
                        <li>
                            <span class="ico"><i class="fa fa-clock"></i></span>
                            <div><strong><?php echo esc_html( mygun_t( 'Working Hours', 'სამუშაო საათები', 'Часы работы' ) ); ?></strong><p><?php echo esc_html( $c_hours ); ?></p></div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-7 col-md-12">
                <div class="mygun-contact-form-card">
                    <div class="section-heading2">
                        <h2><?php echo esc_html( mygun_opt( 'contactp_form_heading', mygun_t( 'Get in Touch', 'მოგვწერეთ', 'Напишите нам' ) ) ); ?></h2>
                    </div>
                    <div class="form-area">
                        <form>
                            <?php wp_nonce_field( 'mygun_contact_nonce', 'contact_nonce' ); ?>
                            <fieldset>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12 feld">
                                        <input type="text" class="require" placeholder="<?php echo esc_attr( mygun_t( 'Full Name *', 'სრული სახელი *', 'Полное имя *' ) ); ?>" name="full_name">
                                        <span><i class="fa fa-user"></i></span>
                                    </div>
                                    <div class="col-sm-6 col-xs-12 feld">
                                        <input type="text" class="require" placeholder="<?php echo esc_attr( mygun_t( 'Email *', 'ელფოსტა *', 'Email *' ) ); ?>" name="email">
                                        <span><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <div class="col-sm-12 col-xs-12 feld">
                                        <input type="text" class="require" placeholder="<?php echo esc_attr( mygun_t( 'Subject', 'თემა', 'Тема' ) ); ?>" name="subject">
                                        <span><i class="fa fa-star"></i></span>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="feld">
                                    <textarea placeholder="<?php echo esc_attr( mygun_t( 'Message *', 'შეტყობინება *', 'Сообщение *' ) ); ?>" class="require" name="message"></textarea>
                                    <span class="msg"><i class="fa fa-pencil-alt"></i></span>
                                </div>
                            </fieldset>
                            <div class="btn-area">
                                <div class="response"></div>
                                <input type="hidden" name="form_type" value="contact">
                                <button type="button" class="submitForm btn1"><span><?php echo esc_html( mygun_t( 'Send Now', 'გაგზავნა', 'Отправить' ) ); ?></span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php if ( $c_map ) : ?>
        <div class="row">
            <div class="col-12">
                <div class="mygun-contact-map"><?php echo wp_kses( $c_map, mygun_options_allowed_html() ); ?></div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<!--Contact area end here-->

<?php get_footer(); ?>
