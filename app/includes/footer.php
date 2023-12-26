<div class="footer">
        <div class="footer-content">
            <div class="footer-section about">
                <h1 class="logo-text"><span>U</span>Blog</h1>
                <p>
                    UBlog is a blog built for letting it's user write out their thoughts on a particular category they like.
                    Our main purpose is to help people's opinions and thoughts get heard.
                </p>
                <div class="contact">
                    <span><i class="fas fa-phone"></i>&nbsp; 1234567891</span>
                    <span><i class="fas fa-envelope"></i>&nbsp; info@ublog.com</span>
                </div>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-section links">
                <h2>Quick Links</h2>
                <br>
                <ul>
                    <a href="#"><li>Events</li></a>
                    <a href="#"><li>Terms and Conditions</li></a>
                </ul>
            </div>
            <div class="footer-section contact-form">
                <h2>Contact Us</h2>
                <br>
                <form action="https://formsubmit.co/35cff003942c76df9e1a5fee30831f82" method="post" id="myForm">
                    <input type="hidden" name="_captcha" value="false">
                    <input type="hidden" name="_next" value="http://localhost/ublog_php_new/index.php">
                    <input type="email" name="email" class="text-input contact-input" placeholder="Your email address..." required>
                    <textarea name="message" class="text-input contact-input" rows="4" placeholder="Your Message..." required></textarea>
                    <button type="submit" class="btn btn-big contact-btn">
                        <i class="fas fa-envelope"></i>
                        Send
                    </button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; UBlog.in | Designed by Mohammad Fahad Shaikh
        </div>
</div>
<script>
    document.getElementById("myForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "https://formsubmit.co/35cff003942c76df9e1a5fee30831f82", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                // Redirect to index.php with the success parameter
                window.location.href = "http://localhost/ublog_php/index.php?success=true";
            }
        };
        xhr.send(formData);
    });
</script>
