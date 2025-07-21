<?php
// تعطيل عرض الأخطاء وزيادة وقت التنفيذ
error_reporting(0);
ini_set('max_execution_time', 120);

function run_real_scan($url) {
    $report = "NullSpecter Scan Report - " . date('Y-m-d H:i:s') . "\n";
    $report .= "Target URL: $url\n\n";
    
    // قائمة الفحوصات مع وقت تنفيذ محدود
    $scans = [
        'general_security_checks' => 'المخاطر العامة',
        'xss_scan' => 'فحص ثغرات XSS',
        'sql_injection_scan' => 'فحص ثغرات SQL Injection',
        'security_headers_scan' => 'فحص إعدادات الأمان',
        'sensitive_files_scan' => 'فحص الملفات الحساسة',
        'information_disclosure_scan' => 'فحص تسرب المعلومات'
    ];
    
    foreach ($scans as $function => $title) {
        // تنفيذ الفحص مع مراقبة الوقت
        $start = microtime(true);
        $report .= "===== $title =====\n";
        $report .= call_user_func($function, $url);
        $time = round(microtime(true) - $start, 2);
        $report .= "وقت التنفيذ: {$time} ثانية\n\n";
    }
    
    return $report;
}

function get_single_header($headers, $header_name) {
    if (!isset($headers[$header_name])) {
        return null;
    }
    
    // إذا كانت المصفوفة تحتوي على عدة قيم، نأخذ الأولى
    if (is_array($headers[$header_name])) {
        return $headers[$header_name][0];
    }
    
    return $headers[$header_name];
}

function general_security_checks($url) {
    $report = "";
    $parsed = parse_url($url);
    $domain = $parsed['host'] ?? 'unknown';
    
    // فحص بروتوكول HTTPS
    if (($parsed['scheme'] ?? 'http') !== 'https') {
        $report .= "[!] Critical: الموقع لا يستخدم HTTPS\n";
        $report .= "    - التوصية: تفعيل شهادة SSL/TLS\n";
    } else {
        $report .= "[✓] HTTPS is enabled\n";
    }
    
    // فحص DNS
    $dns = @dns_get_record($domain, DNS_ALL);
    if ($dns) {
        $report .= "[✓] DNS Records: " . count($dns) . " سجلات\n";
    } else {
        $report .= "[!] DNS Lookup Failed\n";
    }
    
    // فحص ملقم الويب باستخدام curl
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    
    if ($response) {
        $headers = [];
        $headerText = substr($response, 0, strpos($response, "\r\n\r\n"));
        foreach (explode("\r\n", $headerText) as $i => $line) {
            if ($i === 0) continue;
            list($key, $value) = explode(': ', $line, 2);
            $headers[$key] = $value;
        }
        
        $server = get_single_header($headers, 'Server') ?? 'غير معروف';
        $report .= "[!] Server: $server\n";
        
        // تحذير إذا كان خادم قديم
        if (strpos($server, 'Apache/2.2') !== false || strpos($server, 'nginx/1.0') !== false) {
            $report .= "    - Warning: إصدار خادم قديم مع ثغرات معروفة\n";
        }
    } else {
        $report .= "[!] Failed to retrieve server headers\n";
    }
    
    curl_close($ch);
    return $report;
}

function xss_scan($url) {
    $report = "";
    $testPayload = '<script>alert("XSS-Test-'.md5(time()).'")</script>';
    
    // اختبار XSS في معاملات URL
    $testUrl = $url . (strpos($url, '?') !== false ? '&' : '?') . 'test=' . urlencode($testPayload);
    
    $ch = curl_init($testUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if ($response && strpos($response, $testPayload) !== false) {
        $report .= "[!] Critical: XSS Reflected Detected\n";
        $report .= "    - المعلمة: test\n";
        $report .= "    - التوصية: تطبيق HTML Encoding على المدخلات\n";
    } else {
        $report .= "[✓] No Reflected XSS Detected\n";
    }
    
    // فحص إعدادات الحماية
    $headers = @get_headers($url, 1);
    if ($headers) {
        $csp = get_single_header($headers, 'Content-Security-Policy');
        if ($csp) {
            $report .= "[✓] Content Security Policy Header Present\n";
        } else {
            $report .= "[!] Missing Content Security Policy Header\n";
        }
    } else {
        $report .= "[!] Failed to retrieve headers for CSP check\n";
    }
    
    return $report;
}

function sql_injection_scan($url) {
    $report = "";
    $vulnerable = false;
    
    // اختبارات SQLi السريعة فقط
    $tests = [
        "' OR '1'='1",
        "1' OR 1=1--",
        "' OR SLEEP(1)--" // وقت نوم أقل
    ];
    
    foreach ($tests as $test) {
        $testUrl = $url . (strpos($url, '?') !== false ? '&' : '?') . 'id=' . urlencode($test);
        
        // استخدام curl مع مهلة زمنية
        $ch = curl_init($testUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // 5 ثواني كحد أقصى
        $response = curl_exec($ch);
        $time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
        curl_close($ch);
        
        // اكتشاف بناء على الوقت (Time-based)
        if ($time > 1.5) {
            $report .= "[!] Critical: Time-based SQL Injection Detected\n";
            $report .= "    - المعلمة: id\n";
            $report .= "    - الحمولة: $test\n";
            $vulnerable = true;
        }
        
        // اكتشاف بناء على رسائل الخطأ
        if ($response && preg_match('/SQL syntax|MySQL server|syntax error/', $response)) {
            $report .= "[!] Critical: Error-based SQL Injection Detected\n";
            $report .= "    - المعلمة: id\n";
            $report .= "    - الحمولة: $test\n";
            $vulnerable = true;
        }
    }
    
    if (!$vulnerable) {
        $report .= "[✓] No SQL Injection Detected\n";
    } else {
        $report .= "    - التوصية: استخدام Prepared Statements\n";
    }
    
    return $report;
}

function security_headers_scan($url) {
    $report = "";
    $headers = @get_headers($url, 1);
    
    if (!$headers) {
        $report .= "[!] Failed to retrieve headers\n";
        return $report;
    }
    
    // X-Frame-Options
    $xfo = get_single_header($headers, 'X-Frame-Options');
    if ($xfo) {
        $report .= "[✓] X-Frame-Options: $xfo\n";
    } else {
        $report .= "[!] Missing X-Frame-Options (Clickjacking risk)\n";
    }
    
    // X-XSS-Protection
    $xxss = get_single_header($headers, 'X-XSS-Protection');
    if ($xxss) {
        $report .= "[✓] X-XSS-Protection: $xxss\n";
    } else {
        $report .= "[!] Warning: Missing X-XSS-Protection Header\n";
    }
    
    // Strict-Transport-Security
    $hsts = get_single_header($headers, 'Strict-Transport-Security');
    if ($hsts) {
        $report .= "[✓] HSTS: $hsts\n";
    } else {
        $report .= "[!] Warning: Missing HSTS Header\n";
    }
    
    return $report;
}

function sensitive_files_scan($url) {
    $report = "";
    $commonFiles = [
        '.env', '.git/config', 'wp-config.php', 'config.php',
        'backup.zip', 'phpinfo.php', 'admin.php'
    ];
    
    $baseUrl = rtrim($url, '/');
    $found = false;
    
    // استخدام curl_multi لفحص الملفات بشكل متوازي
    $mh = curl_multi_init();
    $handlers = [];
    
    foreach ($commonFiles as $file) {
        $testUrl = $baseUrl . '/' . $file;
        $ch = curl_init($testUrl);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3); // 3 ثواني لكل ملف
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_multi_add_handle($mh, $ch);
        $handlers[$file] = $ch;
    }
    
    // تنفيذ الطلبات المتوازية
    $running = null;
    do {
        curl_multi_exec($mh, $running);
        curl_multi_select($mh);
    } while ($running);
    
    // معالجة النتائج
    foreach ($handlers as $file => $ch) {
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($httpCode == 200) {
            $report .= "[!] Critical: Sensitive File Exposed: /$file\n";
            $found = true;
        }
        
        curl_multi_remove_handle($mh, $ch);
        curl_close($ch);
    }
    
    curl_multi_close($mh);
    
    if (!$found) {
        $report .= "[✓] No Common Sensitive Files Found\n";
    } else {
        $report .= "    - التوصية: منع الوصول إلى ملفات التكوين\n";
    }
    
    return $report;
}

function information_disclosure_scan($url) {
    $report = "";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    curl_close($ch);
    
    if (!$response) {
        $report .= "[!] Failed to retrieve page content\n";
        return $report;
    }
    
    $infoDisclosure = false;
    
    // اكتشاف إصدارات البرمجيات
    if (preg_match('/powered by (WordPress|Joomla|Drupal) ([0-9.]+)/i', $response, $matches)) {
        $report .= "[!] Software Version Disclosure: {$matches[1]} {$matches[2]}\n";
        $infoDisclosure = true;
    }
    
    // اكتشاف مسارات مطلقة
    if (preg_match_all('/(\/var\/www|\/home\/[a-z]+\/public_html)/i', $response, $matches)) {
        $paths = array_unique($matches[0]);
        $report .= "[!] Absolute Path Disclosure:\n";
        foreach ($paths as $path) {
            $report .= "    - $path\n";
        }
        $infoDisclosure = true;
    }
    
    // اكتشاف أخطاء PHP
    if (preg_match('/<b>Warning<\/b>:.+<b>([^<]+)<\/b>/i', $response, $matches)) {
        $report .= "[!] PHP Error Disclosure: {$matches[1]}\n";
        $infoDisclosure = true;
    }
    
    if (!$infoDisclosure) {
        $report .= "[✓] No Critical Information Disclosure Detected\n";
    } else {
        $report .= "    - التوصية: تعطيل عرض الأخطاء في الإنتاج\n";
    }
    
    return $report;
}

function save_report($conn, $url, $report) {
    $timestamp = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO scans (target_url, report, scan_date) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $url, $report, $timestamp);
    
    if ($stmt->execute()) {
        return $conn->insert_id;
    }
    
    return false;
}
?>