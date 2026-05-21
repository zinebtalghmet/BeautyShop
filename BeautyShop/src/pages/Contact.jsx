/**
 * Contact Page
 */

import React, { useState } from 'react';
import styles from '../styles/Contact.module.css';

const Contact = () => {
  const [formData, setFormData] = useState({ name: '', email: '', subject: '', message: '' });
  const [submitted, setSubmitted] = useState(false);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    setSubmitted(true);
    setTimeout(() => setSubmitted(false), 5000);
    setFormData({ name: '', email: '', subject: '', message: '' });
  };

  return (
    <div className={styles.contactPage}>
      <div className={styles.container}>
        <h1 className={styles.pageTitle}>Contact Us</h1>
        <p className={styles.pageSubtitle}>We'd love to hear from you! Get in touch with our team.</p>

        <div className={styles.contactContent}>
          <div className={styles.contactInfo}>
            <div className={styles.infoCard}>
              <div className={styles.infoIcon}>📧</div>
              <h3>Email</h3>
              <p>support@beautyshop.com</p>
            </div>
            <div className={styles.infoCard}>
              <div className={styles.infoIcon}>📞</div>
              <h3>Phone</h3>
              <p>+1 (555) 123-4567</p>
            </div>
            <div className={styles.infoCard}>
              <div className={styles.infoIcon}>📍</div>
              <h3>Address</h3>
              <p>123 Beauty Street<br />Los Angeles, CA 90001</p>
            </div>
            <div className={styles.infoCard}>
              <div className={styles.infoIcon}>⏰</div>
              <h3>Business Hours</h3>
              <p>Mon-Fri: 9AM - 6PM<br />Sat-Sun: 10AM - 4PM</p>
            </div>
          </div>

          <form onSubmit={handleSubmit} className={styles.contactForm}>
            <h2>Send us a Message</h2>
            {submitted && <div className={styles.successMessage}>Thank you! We'll get back to you soon.</div>}
            <input name="name" placeholder="Your Name" value={formData.name} onChange={handleChange} required />
            <input name="email" type="email" placeholder="Your Email" value={formData.email} onChange={handleChange} required />
            <input name="subject" placeholder="Subject" value={formData.subject} onChange={handleChange} required />
            <textarea name="message" placeholder="Your Message" rows="6" value={formData.message} onChange={handleChange} required></textarea>
            <button type="submit" className={styles.submitBtn}>Send Message</button>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Contact;
