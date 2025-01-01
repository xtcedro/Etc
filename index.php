<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dominguez Tech Solutions offers fast, affordable iPhone and computer repairs, custom software development, and website design in Oklahoma City. Quality service with a 24-hour turnaround.">
    <title>Sign Up - Dominguez Tech Solutions</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function setLanguage(lang) {
            if (lang === 'es') {
                window.location.href = 'index_es.html'; // Redirect to Spanish version
            } else {
                document.getElementById('language-modal').style.display = 'none';
            }
        }
    </script>
</head>

<body>
    <!-- Language Selection Modal -->
    <div id="language-modal" class="modal">
        <div class="modal-content">
            <h2>Language / Idioma</h2>
            <div class="language-options">
                <button onclick="setLanguage('en')">
                    <img src="assets/images/us-flag.png" alt="English" class="flag-icon"> English
                </button>
                <button onclick="setLanguage('es')">
                    <img src="assets/images/mx-flag.png" alt="Español" class="flag-icon"> Español
                </button>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <header>
        <h1 class="header-title">Dominguez Tech Solutions</h1>
        <div class="title-banner">
            <img src="assets/images/banner1.png" alt="Dominguez Tech Solutions">
        </div>
    </header>

    <!-- Desktop Navigation -->
    <div class="desktop-nav">
        <a href="index.php" class="active">Home</a>
        <a href="about.html">About Us</a>
        <a href="about2.html">About Pedro Dominguez</a>
        <a href="services.html">Services</a>
        <a href="appointments.html">Appointments</a>
        <a href="offers.html">Special Offers</a>
        <a href="contact.html">Contact Us</a>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1 class="hero-title">
            Welcome to Dominguez Tech Solutions - Fast, Reliable, and Affordable Tech Services for Oklahoma City
        </h1>
        <p>
            Why settle for long wait times and expensive services? At <strong>Dominguez Tech Solutions</strong>, 
            we specialize in delivering <strong>24-hour iPhone, computer, and laptop repairs</strong>, 
            alongside <strong>custom software development</strong> and <strong>website design</strong>. 
            Our mission is to provide exceptional service tailored to your needs—at a price you’ll love.
        </p>
        <p>
            Experience the difference of personalized, transparent, and affordable technology solutions.
        </p>
        <button class="cta-button" onclick="location.href='services.html'">Discover Our Services</button>
    </section>

    <!-- Signup Form Section -->
    <section class="signup-section">
        <h2>Create Your Account</h2>
        <form action="signup.php" method="POST" class="signup-form">
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required pattern="[0-9]{10}">
            
            <label for="pin">6-Digit PIN:</label>
            <input type="text" id="pin" name="pin" placeholder="Enter a 6-digit PIN" required pattern="[0-9]{6}">
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit" class="cta-button">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in here</a>.</p>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section">
        <h2>What We Offer</h2>
        <div class="services-container">
            <div class="service-item">
                <h3>📱 iPhone Repairs</h3>
                <p>Same-day repairs for cracked screens, battery replacements, and more. Affordable pricing with quality guaranteed.</p>
            </div>
            <div class="service-item">
                <h3>💻 Computer Repairs</h3>
                <p>From virus removal to hardware upgrades, we ensure your devices run like new. All brands and operating systems supported.</p>
            </div>
            <div class="service-item">
                <h3>⚙️ Custom Software Development</h3>
                <p>Streamline your operations with software solutions tailored to your business. Let’s turn your ideas into reality.</p>
            </div>
            <div class="service-item">
                <h3>🌐 Website Development</h3>
                <p>Get a professional, fully optimized website in just 24 hours. Perfect for businesses ready to make an impact online.</p>
            </div>
        </div>
        <button class="cta-button" onclick="location.href='services.html'">View All Services</button>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Dominguez Tech Solutions. All rights reserved.</p>
        <ul class="legal-links">
            <li><a href="terms.html">Terms and Conditions</a></li>
            <li><a href="privacy.html">Privacy Policy</a></li>
            <li><a href="disclaimer.html">Disclaimer</a></li>
            <li><a href="warranty.html">Warranty Policy</a></li>
            <li><a href="refund.html">Refund Policy</a></li>
            <li><a href="accessibility.html">Accessibility Statement</a></li>
            <li><a href="cookies.html">Cookie Policy</a></li>
        </ul>
    </footer>
</body>
</html>