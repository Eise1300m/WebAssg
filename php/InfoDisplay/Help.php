<?php
require_once("../base.php");
includeNavbar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & FAQs - Secret Shelf</title>
    <link rel="stylesheet" href="/WebAssg/css/NavbarStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/FooterStyles.css">
    <link rel="stylesheet" href="/WebAssg/css/InfoDisplayStyles.css">
    <link rel="icon" type="image/x-icon" href="/WebAssg/img/Logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/WebAssg/js/Scripts.js"></script>

</head>

<body>
    <div class="info-container">
        <div class="info-header">
            <h1>Help & FAQs</h1>
            <p>Find answers to common questions about Secret Shelf</p>
        </div>

        <div class="help-tabs">
            <div class="help-tab active" data-tab="general">General</div>
            <div class="help-tab" data-tab="orders">Orders & Shipping</div>
            <div class="help-tab" data-tab="account">Account & Privacy</div>
        </div>

        <div id="general" class="tab-content active">
            <div class="faq-category">
                <h2>General Questions</h2>

                <div class="faq-item">
                    <div class="faq-question">What is Secret Shelf?</div>
                    <div class="faq-answer">
                        <p>Secret Shelf is a Malaysian online bookstore offering a wide range of books across various genres. We provide nationwide delivery throughout Malaysia and pride ourselves on our carefully curated selection and exceptional customer service.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">Do you have a physical store?</div>
                    <div class="faq-answer">
                        <p>Yes, we have a physical bookstore located at 123 Jalan Bukit Bintang, Kuala Lumpur. You're welcome to visit us during our opening hours: Monday to Saturday, 9:00am to 6:00pm (closed on Sundays and public holidays).</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">What types of books do you sell?</div>
                    <div class="faq-answer">
                        <p>We offer a diverse collection of books including fiction, non-fiction, academic books, children's books, young adult literature, comics and graphic novels, cookbooks, and more. We stock books in English, Bahasa Malaysia, and selected other languages.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">How can I contact customer service?</div>
                    <div class="faq-answer">
                        <p>You can reach our customer service team through several channels:</p>
                        <ul>
                            <li>Phone: +603 1122 3344 (Monday-Saturday, 9am-6pm)</li>
                            <li>Email: customer@secretshelf.my</li>
                            <li>Contact form on our Contact Us page</li>
                            <li>Visit our physical store</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="orders" class="tab-content">
            <div class="faq-category">
                <h2>Orders & Shipping</h2>

                <div class="faq-item">
                    <div class="faq-question">How do I place an order?</div>
                    <div class="faq-answer">
                        <p>To place an order:</p>
                        <ol>
                            <li>Log in or create an account if you don't have one</li>
                            <li>Browse our website and add items to your cart</li>
                            <li>Click on the cart icon to review your order</li>
                            <li>Proceed to checkout</li>
                            <li>Ensure your shipping and payment details are correct</li>
                            <li>Review and confirm your order</li>
                        </ol>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">What are your shipping rates?</div>
                    <div class="faq-answer">
                        <p>Our shipping rates are as follows:</p>
                        <ul>
                            <li>All shipping fee is RM5</li>
                        </ul>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">How long will it take for my order to arrive?</div>
                    <div class="faq-answer">
                        <p>Standard delivery times:</p>
                        <ul>
                            <li>West Malaysia: 3-5 working days</li>
                            <li>East Malaysia: 5-7 working days</li>
                        </ul>
                        <p>Please note that delivery times are estimates and may vary during peak periods or due to unforeseen circumstances.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">How can I track my order?</div>
                    <div class="faq-answer">
                        <p>You can track your order by:</p>
                        <ol>
                            <li>Logging into your account and checking the order status</li>
                            <li>Contacting our customer service team with your order number</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div id="account" class="tab-content">
            <div class="faq-category">
                <h2>Account & Privacy</h2>

                <div class="faq-item">
                    <div class="faq-question">How do I create an account?</div>
                    <div class="faq-answer">
                        <p>To create an account:</p>
                        <ol>
                            <li>Click on "Login / Sign up" in the top navigation</li>
                            <li>Select "Register" or "Sign up"</li>
                            <li>Fill in the required information</li>
                            <li>Verify your email address if required</li>
                            <li>Start shopping!</li>
                        </ol>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">How do I reset my password?</div>
                    <div class="faq-answer">
                        <p>To reset your password:</p>
                        <ol>
                            <li>Login to your account</li>
                            <li>Click on "Security"</li>
                            <li>Fill in the form in Change Password section</li>
                            <li>Click on "update"</li>
                        </ol>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">How is my personal information protected?</div>
                    <div class="faq-answer">
                        <p>We take data protection seriously. Your personal information is secured using industry-standard encryption and security protocols. We do not sell your data to third parties and only use it for purposes outlined in our Privacy Policy. For more details, please review our Privacy Policy page.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">How do I update my account information?</div>
                    <div class="faq-answer">
                        <p>To update your account information:</p>
                        <ol>
                            <li>Log into your account</li>
                            <li>Go to "My Account" or "Profile"</li>
                            <li>Select "Edit Profile" or "Account Settings"</li>
                            <li>Update your information as needed</li>
                            <li>Save your changes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="info-contact">
            <h3>Still Need Help?</h3>
            <p>If you couldn't find the answer to your question, please contact our customer service team:</p>
            <p>Email: customer@secretshelf.my</p>
            <p>Phone: +603 1122 3344 (Monday-Saturday, 9am-6pm)</p>
            <p>Or visit our <a href="/WebAssg/php/InfoDisplay/Contactus.php">Contact Us</a> page to send us a message.</p>
        </div>

        <a href="/WebAssg/php/index.php" class="back-link">Back to Homepage</a>
    </div>

    <?php includeFooter(); ?>

</body>

</html>