<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Nepal - SaaS CRM for Nepali Businesses</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<!-- Navigation -->
<header class="landing-header">
    <div class="container">
        <div class="nav-wrapper">
            <a href="/" class="logo">
                <svg width="36" height="36" viewBox="0 0 32 32" fill="none">
                    <rect width="32" height="32" rx="8" fill="url(#lg1)"/>
                    <path d="M8 16L14 22L24 10" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    <defs><linearGradient id="lg1" x1="0" y1="0" x2="32" y2="32"><stop stop-color="#1E3A8A"/><stop offset="1" stop-color="#00E5FF"/></linearGradient></defs>
                </svg>
                <span>CRM Nepal</span>
            </a>
            <nav class="nav-links">
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
                <a href="#faq">FAQ</a>
                <a href="#contact">Contact</a>
            </nav>
            <div class="nav-actions">
                <a href="/login" class="btn btn-outline">Login</a>
                <a href="/signup" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>The <span class="gradient-text">All-in-One CRM</span> Built for Nepali Businesses</h1>
            <p class="hero-subtitle">Manage contacts, track deals, handle invoicing, and grow your business with CRM Nepal. Supports eSewa, Khalti, VAT/PAN, and is fully bilingual in English and Nepali.</p>
            <div class="hero-cta">
                <a href="/signup" class="btn btn-primary btn-lg">Start Free Trial</a>
                <a href="#demo" class="btn btn-outline btn-lg">Book a Demo</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>500+</strong>
                    <span>Businesses</span>
                </div>
                <div class="hero-stat">
                    <strong>10,000+</strong>
                    <span>Contacts Managed</span>
                </div>
                <div class="hero-stat">
                    <strong>99.9%</strong>
                    <span>Uptime</span>
                </div>
            </div>
        </div>
        <div class="hero-visual">
            <div class="app-preview">
                <div class="preview-header">
                    <div class="preview-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <span>CRM Nepal Dashboard</span>
                </div>
                <div class="preview-body">
                    <div class="preview-sidebar">
                        <div class="preview-nav-item active"></div>
                        <div class="preview-nav-item"></div>
                        <div class="preview-nav-item"></div>
                        <div class="preview-nav-item"></div>
                    </div>
                    <div class="preview-main">
                        <div class="preview-stats">
                            <div class="preview-stat"></div>
                            <div class="preview-stat"></div>
                            <div class="preview-stat"></div>
                            <div class="preview-stat"></div>
                        </div>
                        <div class="preview-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reliable Support -->
<section class="section support-section">
    <div class="container">
        <div class="support-content">
            <div class="support-badge">24/7 SUPPORT</div>
            <h2>Reliable Support, Always Here for You</h2>
            <p>Our dedicated support team is available around the clock to help you resolve any issues. From onboarding to advanced features, we've got your back.</p>
            <ul class="support-list">
                <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Live chat support in English and Nepali</li>
                <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Email support within 2 hours</li>
                <li><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Phone support for premium plans</li>
            </ul>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section why-section">
    <div class="container">
        <h2 class="section-title">Why Choose CRM Nepal?</h2>
        <p class="section-subtitle">Built specifically for the Nepali market with features you need</p>
        <div class="numbered-cards">
            <div class="numbered-card">
                <span class="card-number">1</span>
                <h3>Local Payment Integration</h3>
                <p>Seamlessly connect with eSewa, Khalti, and other popular Nepali payment gateways.</p>
            </div>
            <div class="numbered-card">
                <span class="card-number">2</span>
                <h3>VAT & PAN Ready</h3>
                <p>Automatically calculate 13% VAT and generate compliant invoices with PAN numbers.</p>
            </div>
            <div class="numbered-card">
                <span class="card-number">3</span>
                <h3>Bilingual Interface</h3>
                <p>Switch between English and Nepali instantly. Your team can use the language they prefer.</p>
            </div>
            <div class="numbered-card">
                <span class="card-number">4</span>
                <h3>Affordable Pricing</h3>
                <p>Pricing in Nepali Rupees starting at just NPR 1,999/month. No hidden charges.</p>
            </div>
            <div class="numbered-card">
                <span class="card-number">5</span>
                <h3>Cloud Hosted</h3>
                <p>Access your CRM from anywhere in Nepal or abroad. No server maintenance needed.</p>
            </div>
            <div class="numbered-card">
                <span class="card-number">6</span>
                <h3>Data Security</h3>
                <p>Bank-level encryption and secure data storage. Your business data is always protected.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features -->
<section id="features" class="section features-section">
    <div class="container">
        <h2 class="section-title">Powerful Features</h2>
        <p class="section-subtitle">Everything you need to manage your business relationships</p>
        <div class="features-grid">
            <?php if (!empty($features)): ?>
            <?php foreach ($features as $feature): ?>
            <div class="feature-card">
                <div class="feature-icon"><?= esc($feature['icon']) ?></div>
                <h3><?= esc($feature['title']) ?></h3>
                <p><?= esc($feature['description']) ?></p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Built for Nepal -->
<section class="section nepal-section">
    <div class="container">
        <h2 class="section-title">Built for Nepal</h2>
        <p class="section-subtitle">Features designed specifically for Nepali businesses</p>
        <div class="features-grid">
            <?php if (!empty($localFeatures)): ?>
            <?php foreach ($localFeatures as $feature): ?>
            <div class="feature-card nepal-card">
                <div class="feature-icon"><?= esc($feature['icon']) ?></div>
                <h3><?= esc($feature['title']) ?></h3>
                <p><?= esc($feature['description']) ?></p>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Pricing -->
<section id="pricing" class="section pricing-section">
    <div class="container">
        <h2 class="section-title">Simple, Transparent Pricing</h2>
        <p class="section-subtitle">Choose the plan that fits your business</p>
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Starter</h3>
                <div class="price">
                    <span class="amount">NPR 1,999</span>
                    <span class="period">/month</span>
                </div>
                <ul class="pricing-features">
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Up to 100 Contacts</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> 5 Users</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Basic Pipeline</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Email Support</li>
                </ul>
                <a href="/signup" class="btn btn-outline btn-full">Get Started</a>
            </div>
            <div class="pricing-card popular">
                <div class="popular-badge">Most Popular</div>
                <h3>Professional</h3>
                <div class="price">
                    <span class="amount">NPR 4,999</span>
                    <span class="period">/month</span>
                </div>
                <ul class="pricing-features">
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Up to 1,000 Contacts</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> 15 Users</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Advanced Pipeline</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Invoice Management</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Priority Support</li>
                </ul>
                <a href="/signup" class="btn btn-primary btn-full">Get Started</a>
            </div>
            <div class="pricing-card">
                <h3>Enterprise</h3>
                <div class="price">
                    <span class="amount">NPR 9,999</span>
                    <span class="period">/month</span>
                </div>
                <ul class="pricing-features">
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Unlimited Contacts</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Unlimited Users</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Custom Integrations</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> API Access</li>
                    <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg> Phone Support</li>
                </ul>
                <a href="/signup" class="btn btn-outline btn-full">Contact Sales</a>
            </div>
        </div>
    </div>
</section>

<!-- Book a Demo -->
<section id="demo" class="section demo-section">
    <div class="container">
        <h2 class="section-title">Book a Free Demo</h2>
        <p class="section-subtitle">See how CRM Nepal can transform your business</p>
        <div class="demo-form-container">
            <form method="POST" action="/api/chatbot-submit" class="demo-form" id="demoForm">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" required placeholder="Your name">
                </div>
                <div class="form-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" required placeholder="you@company.com">
                </div>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="company" placeholder="Your company">
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="+977 98XXXXXXXX">
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="3" placeholder="Tell us about your needs"></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Book Demo</button>
            </form>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="section faq-section">
    <div class="container">
        <h2 class="section-title">Frequently Asked Questions</h2>
        <div class="faq-accordion">
            <?php if (!empty($faqs)): ?>
            <?php foreach ($faqs as $faq): ?>
            <div class="faq-item">
                <button class="faq-question" onclick="toggleFaq(this)">
                    <span><?= esc($faq['title']) ?></span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="faq-answer">
                    <p><?= esc($faq['description']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Contact -->
<section id="contact" class="section contact-section">
    <div class="container">
        <h2 class="section-title">Get in Touch</h2>
        <p class="section-subtitle">Have questions? We'd love to hear from you.</p>
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div>
                        <h4>Email</h4>
                        <p>info@crm-nepal.com</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <h4>Phone</h4>
                        <p>+977-1-4XXXXXX</p>
                    </div>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <h4>Location</h4>
                        <p>Kathmandu, Nepal</p>
                    </div>
                </div>
            </div>
            <form method="POST" action="/api/chatbot-submit" class="contact-form">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="form-group">
                    <input type="text" name="subject" placeholder="Subject">
                </div>
                <div class="form-group">
                    <textarea name="message" rows="4" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-full">Send Message</button>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="landing-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <rect width="32" height="32" rx="8" fill="url(#lg2)"/>
                        <path d="M8 16L14 22L24 10" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <defs><linearGradient id="lg2" x1="0" y1="0" x2="32" y2="32"><stop stop-color="#1E3A8A"/><stop offset="1" stop-color="#00E5FF"/></linearGradient></defs>
                    </svg>
                    <span>CRM Nepal</span>
                </div>
                <p>The all-in-one CRM platform designed for Nepali businesses. Grow your business with confidence.</p>
            </div>
            <div class="footer-col">
                <h4>Product</h4>
                <a href="#features">Features</a>
                <a href="#pricing">Pricing</a>
                <a href="#faq">FAQ</a>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <a href="#">About Us</a>
                <a href="#">Blog</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="footer-col">
                <h4>Legal</h4>
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Refund Policy</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 CRM Nepal. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Chatbot Widget -->
<div class="chatbot-widget" id="chatbotWidget">
    <button class="chatbot-toggle" onclick="toggleChatbot()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" id="chatbotIcon"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    </button>
    <div class="chatbot-window" id="chatbotWindow" style="display:none;">
        <div class="chatbot-header">
            <h4>CRM Nepal Chat</h4>
            <button onclick="toggleChatbot()">&times;</button>
        </div>
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="chat-message bot">
                <p>Welcome! I'm here to help you get started with CRM Nepal.</p>
            </div>
            <div class="chat-quick-replies">
                <button class="quick-reply" onclick="chatQuickReply('demo')">Book a Demo</button>
                <button class="quick-reply" onclick="chatQuickReply('features')">View Features</button>
                <button class="quick-reply" onclick="chatQuickReply('pricing')">Pricing Info</button>
            </div>
        </div>
        <div class="chatbot-step" id="chatForm" style="display:none;">
            <div class="form-group">
                <input type="text" id="chatName" placeholder="Your name">
            </div>
            <div class="form-group">
                <input type="email" id="chatEmail" placeholder="Your email">
            </div>
            <div class="form-group">
                <select id="chatCountry">
                    <option value="">Select Country</option>
                    <option value="NP" selected>Nepal</option>
                    <option value="IN">India</option>
                    <option value="US">United States</option>
                    <option value="AU">Australia</option>
                    <option value="GB">United Kingdom</option>
                    <option value="AE">UAE</option>
                    <option value="SA">Saudi Arabia</option>
                    <option value="JP">Japan</option>
                    <option value="KR">South Korea</option>
                    <option value="SG">Singapore</option>
                    <option value="MY">Malaysia</option>
                    <option value="TH">Thailand</option>
                    <option value="HK">Hong Kong</option>
                    <option value="CA">Canada</option>
                    <option value="DE">Germany</option>
                    <option value="FR">France</option>
                    <option value="IT">Italy</option>
                    <option value="ES">Spain</option>
                    <option value="NL">Netherlands</option>
                    <option value="CN">China</option>
                    <option value="BD">Bangladesh</option>
                    <option value="PK">Pakistan</option>
                    <option value="LK">Sri Lanka</option>
                    <option value="MM">Myanmar</option>
                    <option value="BT">Bhutan</option>
                    <option value="MV">Maldives</option>
                    <option value="PH">Philippines</option>
                    <option value="ID">Indonesia</option>
                    <option value="VN">Vietnam</option>
                    <option value="NZ">New Zealand</option>
                    <option value="QA">Qatar</option>
                    <option value="KW">Kuwait</option>
                    <option value="BH">Bahrain</option>
                    <option value="OM">Oman</option>
                    <option value="JO">Jordan</option>
                    <option value="LB">Lebanon</option>
                    <option value="EG">Egypt</option>
                    <option value="NG">Nigeria</option>
                    <option value="KE">Kenya</option>
                    <option value="ZA">South Africa</option>
                    <option value="ET">Ethiopia</option>
                    <option value="GH">Ghana</option>
                    <option value="TZ">Tanzania</option>
                    <option value="UG">Uganda</option>
                    <option value="RW">Rwanda</option>
                    <option value="MU">Mauritius</option>
                    <option value="SE">Sweden</option>
                    <option value="NO">Norway</option>
                    <option value="DK">Denmark</option>
                    <option value="FI">Finland</option>
                    <option value="CH">Switzerland</option>
                    <option value="AT">Austria</option>
                    <option value="BE">Belgium</option>
                    <option value="PT">Portugal</option>
                    <option value="IE">Ireland</option>
                    <option value="RU">Russia</option>
                    <option value="UA">Ukraine</option>
                    <option value="PL">Poland</option>
                    <option value="CZ">Czech Republic</option>
                    <option value="RO">Romania</option>
                    <option value="HU">Hungary</option>
                    <option value="GR">Greece</option>
                    <option value="TR">Turkey</option>
                    <option value="BR">Brazil</option>
                    <option value="MX">Mexico</option>
                    <option value="AR">Argentina</option>
                    <option value="CL">Chile</option>
                    <option value="CO">Colombia</option>
                    <option value="PE">Peru</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" id="chatPhone" placeholder="Phone number">
            </div>
            <button class="btn btn-primary btn-full" onclick="submitChatForm()">Submit</button>
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatInput" placeholder="Type a message..." onkeypress="if(event.key==='Enter')sendChatMessage()">
            <button onclick="sendChatMessage()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            </button>
        </div>
    </div>
</div>

<script src="/assets/js/app.js"></script>
</body>
</html>
