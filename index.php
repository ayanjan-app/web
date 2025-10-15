<<<<<<< HEAD:Jahan_Journal/Journal.html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jahan Journal - Modern UI/UX</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <!-- Header -->
    <?php include("header.php"); ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container hero-content">
            <div class="hero-text">
                <span class="hero-badge">Featured Story</span>
                <h1 class="hero-title">Exploring the Future of Digital Innovation</h1>
                <p class="hero-description">Discover how emerging technologies are reshaping industries and creating new opportunities for growth and transformation in the digital age.</p>
                <div class="hero-buttons">
                    <a href="login.php" class="btn btn-outline">Login</a>
          <a href="register.php" class="btn btn-primary">Create account to publish</a>
                </div>
            </div>
            <div class="hero-image">
                <img src="5.jpg" alt="Digital Innovation">
            </div>
        </div>
    </section>

   <!-- Featured Research Papers -->
<section class="featured" id="articles">
    <div class="container">
        <h2 class="section-title">Featured Research Papers</h2>
        <div class="articles">

            <div class="article-card animate">
                <img src="https://images.unsplash.com/photo-1529101091764-c3526daf38fe?auto=format&fit=crop&w=1170&q=80" 
                     alt="AI Research" class="article-image">
                <span class="article-category">Computer Science</span>
                <div class="article-content">
                    <h3 class="article-title">Artificial Intelligence in Healthcare</h3>
                    <div class="article-meta">
                        <span><i class="far fa-user"></i> Dr. Sarah Johnson</span>
                        <span><i class="far fa-clock"></i> July 15, 2025</span>
                    </div>
                    <p class="article-excerpt">
                        A comprehensive study on the applications of AI in diagnostics, patient care, 
                        and future opportunities in medical research.
                    </p>
                    <a href="#" class="btn btn-outline">Read Paper</a>
                </div>
            </div>

            <div class="article-card animate delay-1">
                <img src="https://images.unsplash.com/photo-1524492449090-1a065f3a6220?auto=format&fit=crop&w=1074&q=80" 
                     alt="Climate Research" class="article-image">
                <span class="article-category">Environmental Science</span>
                <div class="article-content">
                    <h3 class="article-title">Sustainable Energy Solutions</h3>
                    <div class="article-meta">
                        <span><i class="far fa-user"></i> Prof. Michael Green</span>
                        <span><i class="far fa-clock"></i> June 30, 2025</span>
                    </div>
                    <p class="article-excerpt">
                        Research into renewable energy systems and their potential to address 
                        global climate challenges while supporting economic growth.
                    </p>
                    <a href="#" class="btn btn-outline">Read Paper</a>
                </div>
            </div>

            <div class="article-card animate delay-2">
                <img src="https://images.unsplash.com/photo-1521790797524-b2497295b8a0?auto=format&fit=crop&w=1074&q=80" 
                     alt="Social Science Research" class="article-image">
                <span class="article-category">Social Sciences</span>
                <div class="article-content">
                    <h3 class="article-title">Impact of Technology on Education</h3>
                    <div class="article-meta">
                        <span><i class="far fa-user"></i> Dr. Emily Carter</span>
                        <span><i class="far fa-clock"></i> May 22, 2025</span>
                    </div>
                    <p class="article-excerpt">
                        Examining how digital tools are transforming learning environments, 
                        improving accessibility, and shaping the future of academia.
                    </p>
                    <a href="#" class="btn btn-outline">Read Paper</a>
                </div>
            </div>

        </div>
    </div>
</section>
    </section>

    <!-- Research Section -->
    <section class="research" id="research">
        <div class="container">
            <h2 class="section-title">Research & Insights</h2>
            
            <div class="data-cards">
                <div class="data-card animate">
                    <div class="data-number">87%</div>
                    <div class="data-label">Reader Engagement</div>
                </div>
                <div class="data-card animate delay-1">
                    <div class="data-number">42</div>
                    <div class="data-label">Research Papers</div>
                </div>
                <div class="data-card animate delay-2">
                    <div class="data-number">15k</div>
                    <div class="data-label">Monthly Readers</div>
                </div>
                <div class="data-card animate delay-3">
                    <div class="data-number">96%</div>
                    <div class="data-label">Satisfaction Rate</div>
                </div>
            </div>

            <div class="table-container">
                <table class="research-table">
                    <thead>
                        <tr>
                            <th>Research Topic</th>
                            <th>Author(s)</th>
                            <th>Date Published</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Renewable Energy Adoption Rates</td>
                            <td>Chen, A., Martinez, L.</td>
                            <td>June 15, 2023</td>
                            <td>Environment</td>
                        </tr>
                        <tr>
                            <td>Economic Impact of Remote Work</td>
                            <td>Wilson, J., Okafor, T.</td>
                            <td>June 8, 2023</td>
                            <td>Economics</td>
                        </tr>
                        <tr>
                            <td>AI Ethics Framework Analysis</td>
                            <td>Park, S., Johnson, M.</td>
                            <td>May 30, 2023</td>
                            <td>Technology</td>
                        </tr>
                        <tr>
                            <td>Global Education Trends</td>
                            <td>Abebe, F., Gonzalez, R.</td>
                            <td>May 22, 2023</td>
                            <td>Education</td>
                        </tr>
                        <tr>
                            <td>Public Health Policies Comparison</td>
                            <td>Yamamoto, H., Silva, P.</td>
                            <td>May 15, 2023</td>
                            <td>Health</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="newsletter">
        <div class="container newsletter-container">
            <h2 class="section-title newsletter-title">Stay Informed</h2>
            <p class="newsletter-description">Subscribe to our newsletter to receive the latest research, articles, and insights from Jahan Journal.</p>
            
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Your email address" required>
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
            
            <p>We respect your privacy. Unsubscribe at any time.</p>
        </div>
    </section>

    <!-- Footer -->
    <?php include("footer.php"); ?>

    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const navMenu = document.getElementById('navMenu');
            
            menuToggle.addEventListener('click', function() {
                navMenu.classList.toggle('show');
                menuToggle.classList.toggle('active');
            });
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        window.scrollTo({
                            top: targetElement.offsetTop - 80,
                            behavior: 'smooth'
                        });
                        
                        // Close mobile menu if open
                        if (navMenu.classList.contains('show')) {
                            navMenu.classList.remove('show');
                            menuToggle.classList.remove('active');
                        }
                    }
                });
            });
            
            // Animation on scroll
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, observerOptions);
            
            document.querySelectorAll('.article-card, .data-card').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>