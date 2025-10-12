<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Jahan University</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <!-- Main part -->
    <h1>Contact Us</h1>
    
    <!-- Contact Cards -->
    <div class="container">
        <div class="contact-cards">
            <div class="contact-card">
                <img src="icon/Email.png" alt="Email Icon">
                <h3>Email Us</h3>
                <p>info@jahan.edu.af</p>
                <p>We'll respond within 24 hours</p>
            </div>
            
            <div class="contact-card">
                <img src="icon/Call.png" alt="Call Icon">
                <h3>Call Us</h3>
                <p>+93785490049</p>
                <p>+93771919727</p>
                <p>Mon-Fri, 8:00 AM - 5:00 PM</p>
            </div>
            
            <div class="contact-card">
                <img src="icon/Location.png" alt="Location Icon">
                <h3>Visit Us</h3>
                <p>3th Street Karte Now</p>
                <p>Afghanistan, NY</p>
                <p>Get directions</p>
            </div>
        </div>
    </div>
    
    <!-- Contact Persons Table -->
    <div class="container">
        <div class="table-section">
            <div class="table-header">
                <img src="icon/Email.png" alt="Email Icon">
                <h2>University Contacts</h2>
            </div>
            <table>
                <tr>
                    <th><i>Name</i></th>
                    <th><i>Email</i></th>
                    <th><i>Position</i></th>
                </tr>
                <tr>
                    <td>Abdul Hakim Noori</td>
                    <td><span>chancellor@jahan.edu.af</span></td>
                    <td>Chancellor</td>
                </tr>
                <tr>
                    <td>Abdul Qudoos Noori</td>
                    <td><span>adminstrativevc@jahan.edu.af</span></td>
                    <td>Adminstrative VC</td>
                </tr>
                <tr>
                    <td>Salim Hamidi</td>
                    <td><span>avc@jahan.edu.af</span></td>
                    <td>AVC</td>
                </tr>
                <tr>
                    <td>Rahmat Sadat</td>
                    <td><span>vc_studentsaffairs@jahan.edu.af</span></td>
                    <td>VC_student affairs</td>
                </tr>
                <tr>
                    <td>Information</td>
                    <td><span>info@jahan.edu.af</span></td>
                    <td>Information Office</td>
                </tr>
                <tr>
                    <td>Yousuf Hotak</td>
                    <td><span>dean_cs@jahan.edu.af</span></td>
                    <td>Dean of CS</td>
                </tr>
                <tr>
                    <td>Asif Sadat</td>
                    <td><span>it_department@jahan.edu.af</span></td>
                    <td>HOD of IT</td>
                </tr>
                <tr>
                    <td>Rahmatullah Ebadi</td>
                    <td><span>rahmatullahebadi@jahan.edu.af</span></td>
                    <td>HOD of Database</td>
                </tr>
                <tr>
                    <td>Hanifulah Bashar</td>
                    <td><span>dean_economics@jahan.edu.af</span></td>
                    <td>Dean of EC</td>
                </tr>
                <tr>
                    <td>Said Shoja Saeedi</td>
                    <td><span>finance_department@jahan.edu.af</span></td>
                    <td>HOD of Finance</td>
                </tr>
                <tr>
                    <td>Dr.Said Haidar Hussani</td>
                    <td><span>dean_llb@jahan.edu.af</span></td>
                    <td>Dean of LLB</td>
                </tr>
                <tr>
                    <td>Sulaiman Muradi</td>
                    <td><span>dean_sharia@jahan.edu.af</span></td>
                    <td>Dean of Sharia</td>
                </tr>
                <tr>
                    <td>Latifullah HR</td>
                    <td><span>job@jahan.edu.af</span></td>
                    <td>HR</td>
                </tr>
                <tr>
                    <td>Matinzada</td>
                    <td><Span>ir_department@jahan.edu.af</Span></td>
                    <td>HOD of Diplomacy and administration</td>
                </tr>
                <tr>
                    <td>Matiullah Khoshiwal</td>
                    <td><span>it@jahan.edu.af</span></td>
                    <td>IT Manager</td>
                </tr>
            </table>
        </div>
    </div>
    
    <!-- Contact Form -->
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Get In Touch</h2>
                <p>Leave us a message and we'll get back to you as soon as possible</p>
            </div>
            <div class="row">
                <div class="column">
                    <!-- Optional: Could add contact info or image here -->
                </div>
                <div class="column">
                    <form action="">
                        <label for="fname">First Name</label>
                        <input type="text" id="fname" name="firstname" placeholder="Your name" required>
                        
                        <label for="lname">Last Name</label>
                        <input type="text" id="lname" name="lastname" placeholder="Your last name" required>
                        
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your email address" required>
                        
                        <label for="subject">Subject</label>
                        <textarea id="subject" name="subject" placeholder="How can we help you?" required></textarea>
                        
                        <input type="submit" value="Send Message">
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="container">
        <div class="map-section">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3387.454357746649!2d69.11248531509992!3d34.51523998023711!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38d16f5c8e6d5a5b%3A0x6a1f2d3d3e3d3e3d!2sKarte%20Now%2C%20Kabul%2C%20Afghanistan!5e0!3m2!1sen!2s!4v1620000000000!5m2!1sen!2s" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
    
    <!-- Footer -->
    <footer>
        <p>&copy; 2023 Jahan University. All rights reserved.</p>
    </footer>
</body>
</html>