<?php
/**
 * Created by PhpStorm.
 * User: ME
 * Date: 2/13/2017
 * Time: 1:58 PM
 */
require_once("header-basic.php");
?>
    <!-- PAGE CONTENT START -->
    <div class="section">
        <div class="line">
            <div class="margin">
                <div class="s-12 m-12 l-4 margin-bottom-30">
                    <div class="fullwidth margin-bottom-40">
                        <h2>Reach Us</h2>
                        <hr class="break-small">
                        <p>good to have you on this page.</p>
                    </div>
                    <div class="fullwidth margin-bottom-50">
                        <div class="float-left">
                            <i class="fa fa-home text-white background-primary icon-square-small"></i>
                        </div>
                        <div class="margin-left-100">
                            <h4 class="text-primary">Address</h4>
                            <p>
                                49 Bezuidenhont Ave<br/>
                                Bezvalley<br/>
                                Johannesburg<br/>
                                +27 73 530 2183<br/>
                                +27(0) 11 618 4623<br/>
                                info@laureatelebeautytraining.co.za<br/>
                            </p>
                        </div>
                    </div>
                    <div class="fullwidth margin-bottom-50">
                        <div class="float-left">
                            <i class="fa fa-home text-white background-primary icon-square-small"></i>
                        </div>
                        <div class="margin-left-100">
                            <h4 class="text-primary">Address</h4>
                            <p>
                                80 Cillers Advantor Towers<br/>
                                Office 113,<br/>
                                Sunnyside Pretoria<br/>
                                +27 63 571 6708<br/>
                                +27(0) 11 048 0102<br/>
                                nakim@laureatelebeautytraining.co.za<br/>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="s-12 m-12 l-8">
                    <div class="padding-m-s-left-50">
                        <div class="fullwidth margin-bottom-40">
                            <h2>Send Us a Line</h2>
                            <hr class="break-small">
                            <p>
                                If you want to know a little lot more please send us a message here:
                            </p>
                        </div>
                        <form class="customform" name="contact-us-form" method="post" action="mail_to_laureate.php">
                            <div class="margin">
                                <div class="s-12 m-6 l-6">
                                    <input type="text" name="user_name" placeholder="Full Name" title="Full Name"
                                           required/>
                                </div>
                                <div class="s-12 m-6 l-6">
                                    <input type="text" name="user_email" placeholder="Email" title="Email" required/>
                                </div>
                            </div>
                            <div class="margin">
                                <div class="s-12 m-6 l-6">
                                    <input type="text" name="user_mobile" placeholder="Mobile" title="Mobile Number"
                                           required/>
                                </div>
                                <div class="s-12 m-6 l-6">
                                    <input type="text" name="subject" placeholder="Subject" title="Subject"/>
                                </div>
                            </div>
                            <div class="fullwidth">
                                <textarea name="user_report" placeholder="Type your message" rows="2"
                                          required></textarea>
                            </div>
                            <div class="fullwidth">
                                <input type="submit" value="Send to Us">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PAGE CONTENT END -->



<?php
require_once("footer-basic.php");