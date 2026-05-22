import React, { useState } from 'react';
import { submitContact } from '../services/contactService';
import styles from '../styles/Contact.module.css';

const Contact = () => {
  const [formData, setFormData] = useState({ name: '', email: '', subject: '', message: '' });
  const [submitted, setSubmitted] = useState(false);
  const [error, setError] = useState('');

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');

    try {
      await submitContact(formData);
      setSubmitted(true);
      setFormData({ name: '', email: '', subject: '', message: '' });
      setTimeout(() => setSubmitted(false), 5000);
    } catch (err) {
      setError(err.response?.data?.message || 'Failed to send message. Please try again.');
    }
  };

  return (
    <div className={styles.contactPage}>
      <div className={styles.container}>
        <h1 className={styles.pageTitle}>Contact Us</h1>
        <p className={styles.pageSubtitle}>We'd love to hear from you! Get in touch with our team.</p>

        {error && (
          <div style={{ background: '#fef2f2', color: '#dc2626', padding: '12px 16px', borderRadius: '8px', marginBottom: '20px', fontSize: '14px', maxWidth: '800px', margin: '0 auto 20px' }}>
            {error}
          </div>
        )}

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
