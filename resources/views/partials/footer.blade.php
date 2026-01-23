<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- About -->
            <div class="footer-column">
                <h3 class="footer-heading">Daience University</h3>
                <p class="footer-about">A 100% online university, headquartered in New Orleans, Louisiana.</p>
            </div>

            <!-- Learn More -->
            <div class="footer-column">
                <h4 class="footer-title">Learn More</h4>
                <ul class="footer-links">
                    <li><a href="#">Our Degree Program</a></li>
                    <li><a href="#">MS Data Science and Cyber Security</a></li>
                    <li><a href="#">Degree Course Descriptions</a></li>
                    <li><a href="#">Student Disclosures</a></li>
                    <li><a href="#">School Catalog</a></li>
                </ul>
            </div>

            <!-- Certificate Courses -->
            <div class="footer-column">
                <h4 class="footer-title">Our Certificate Courses</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('courses') }}">Cyber Security Courses</a></li>
                    <li><a href="{{ route('courses') }}">Data Science Courses</a></li>
                    <li><a href="{{ route('courses') }}">Language Courses</a></li>
                    <li><a href="{{ route('courses') }}">Business Courses</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-column">
                <h4 class="footer-title">Contact</h4>
                <address class="footer-contact">
                    <p>749 Baronne Street, Unit 100-A<br>New Orleans, LA 70113</p>
                    <p><a href="tel:504-356-0089">504-356-0089</a></p>
                    <p><a href="mailto:info@daience.university">info@daience.university</a></p>
                </address>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Daience University. All rights reserved.</p>
        </div>
    </div>
</footer>