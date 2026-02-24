<?php include 'header.php'; ?>

<!-- Header Start -->
<div class="container-fluid bg-breadcrumb" style="background-image:url(img/pro/contact.jpg)">
    <div class="container text-center py-5" style="max-width: 900px;">
        <h4 class="text-white display-4 mb-4 wow fadeInDown" data-wow-delay="0.1s">Contact Us</h4>
        <ol class="breadcrumb d-flex justify-content-center mb-0 wow fadeInDown" data-wow-delay="0.3s">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
            <li class="breadcrumb-item active text-primary">Contact</li>
        </ol>
    </div>
</div>
<!-- Header End -->
</div>
<!-- Navbar & Hero End -->

<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-xl-6">
                <div class="wow fadeInUp" data-wow-delay="0.2s">
                    <div class="bg-light rounded p-5 mb-5">
                        <h4 class="text-primary mb-4">Get in Touch</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4 style="color:#fff">Address</h4>
                                        <p style="color:#fff" class="mb-0">8, 12, Block 11, Tilak Nagar, New Delhi, Delhi, 110018,India</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fa fa-phone-alt fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4 style="color:#fff">Telephone</h4>
                                        <p style="color:#fff" class="mb-0">+91 76918 60662</p>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4 style="color:#fff">Mail Us</h4>
                                        <p style="color:#fff" class="mb-0">info@example.com</p>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="col-md-6">
                                <div class="contact-add-item">
                                    <div class="contact-icon text-primary mb-4">
                                        <i class="fab fa-firefox-browser fa-2x"></i>
                                    </div>
                                    <div>
                                        <h4>Yoursite@ex.com</h4>
                                        <p class="mb-0">(+012) 3456 7890</p>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                    <!-- <div class="bg-light p-5 rounded h-100 wow fadeInUp" data-wow-delay="0.2s">
                        <h4 class="text-primary">Send Your Message</h4>
                        <p style="color:#fff" class="mb-4">Connect with us today to bulk order premium ethnic and fashion wear that your customers will love!</p>
                        <form>
                            <div class="row g-4">
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="name" placeholder="Your Name">
                                        <label for="name">Your Name</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control border-0" id="email" placeholder="Your Email">
                                        <label for="email">Your Email</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="phone" class="form-control border-0" id="phone" placeholder="Phone">
                                        <label for="phone">Your Phone</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-xl-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="project" placeholder="Project">
                                        <label for="project">Your Project</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control border-0" id="subject" placeholder="Subject">
                                        <label for="subject">Subject</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control border-0" placeholder="Leave a message here" id="message" style="height: 160px"></textarea>
                                        <label for="message">Message</label>
                                    </div>

                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div> -->
                </div>
            </div>
            <div class="col-xl-6 bg-light p-5 rounded h-100 wow fadeInUp" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;" bis_skin_checked="1">
                <h4 class="text-primary">Send Your Message</h4>
                <!-- <p style="color:#fff" class="mb-4">Connect with us today to bulk order premium ethnic and fashion wear that your customers will love!</p> -->
                <form action="mailcontact.php" method="post">
                    <div class="row g-4">

                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control border-0" id="email" placeholder="Your Email">
                                <label for="email">Your Email</label>
                            </div>
                        </div>

                        <div class="col-lg-12 col-xl-6">
                            <div class="form-floating">
                                <input type="text" name="phone" class="form-control border-0" id="phone" placeholder="Phone">
                                <label for="phone">Your Phone</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="message" class="form-control border-0" placeholder="Leave a message here" id="message" style="height: 80px"></textarea>
                                <label for="message">Message</label>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 py-3" style="background-color: black;">
                                Send Message
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-12 wow fadeInRight mt-5" data-wow-delay="0.2s">
            <div class="rounded h-100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.7247676787442!2d77.093938075501!3d28.638009975661742!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d04992c662577%3A0xd9956de9b27ddaaa!2s8%2C%2011%2F12%2C%20Block%2011%2C%20Tilak%20Nagar%2C%20Delhi%2C%20110018!5e0!3m2!1sen!2sin!4v1771000206983!5m2!1sen!2sin" width="100%" height="400px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

<?php include 'footer.php'; ?>