# NullSpecter Security Scanner 🔍

NullSpecter is a powerful and lightweight vulnerability scanner built with PHP, designed to help security researchers and bug bounty hunters identify common web application vulnerabilities with ease.

## 🌐 Live Demo
> Coming Soon: Deployed version on [Render](https://render.com)

## 🚀 Features
- ✅ XSS Detection (Reflected & Stored)
- ✅ SQL Injection (Error-based & Blind)
- ✅ LFI Detection
- ✅ SSRF Testing
- ✅ File Upload Bypass
- ✅ Directory Listing & Sensitive Files Discovery
- ✅ Subdomain Enumeration
- ✅ Security Headers Analyzer
- ✅ Log4j & Spring4Shell Scanner
- ✅ JSON Output for API Integration

## 📁 Folder Structure
```
nullspecter-scanner/
│
├── index.php                # Main scan form
├── scan.php                 # Handles scan execution and returns results
├── includes/
│   ├── functions.php        # Scanning logic & vulnerability checks
│   ├── db.php               # MySQL connection (if used)
│
├── assets/                  # CSS/JS/Images
├── reports/                 # Saved scan results
└── README.md                # Project documentation
```

## ⚙️ Requirements
- PHP 7.4+
- Web server (Apache/Nginx)
- Optional: MySQL (for saving scan reports)
- Permissions to run shell commands (if using tools like `nmap`, `curl`, etc.)

## 💻 How to Run Locally
1. Clone the repository:
   ```bash
   git clone https://github.com/Abdelrahmaneala/nullwebvaln.git
   cd nullspecter
   ```

2. Deploy it on XAMPP, Laragon, or any local PHP server:
   ```
   http://localhost/nullspecter
   ```

3. Enter a target URL and hit "Scan".

## ☁️ Deploy to Render.com (Free Hosting)
1. Connect your GitHub repo to [Render](https://render.com)
2. Set Environment to **PHP**
3. Leave Build & Start commands empty
4. Hit **Create Web Service**
5. Done! Your scanner is now online 🎯

## 🧠 Use Cases
- Bug bounty testing
- Educational cybersecurity labs
- Vulnerability recon in CI/CD pipelines
- Quick security checks for your own websites

## ⚠️ Legal Disclaimer
This tool is intended **only for ethical testing and educational purposes**. Do not scan websites without **explicit permission**. The author is not responsible for any misuse.

## 📧 Contact
- Author: [AbdUlrahman Elsayed](mailto:boodapro540@gmail.com)
- LinkedIn: [AbdUlrahman Elsayed](https://www.linkedin.com/in/abdulrahman-elsayed-59a664313)
- YouTube: [GamoTek Security](https://www.youtube.com/@gamotek175)

---

> "Scan responsibly. Hack ethically. Always stay curious." 🔐
