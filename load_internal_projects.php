<?php
header('Content-Type: application/json; charset=utf-8');

// تابع بررسی وضعیت سرور با cURL
function checkServerStatus($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_NOBODY, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ($httpCode >= 200 && $httpCode < 400);
}

$output = [];

// تعریف لیست پروژه‌های هوشمند
$projects = [
    [
        'id' => 'batis_modern',
        'url' => 'https://batis-modern.vercel.app',
        'img' => '/src/batis.png',
        'title' => 'باتیس مدرن',
        'desc' => 'طراحی مدرن و مینیمال با استفاده از تکنولوژی‌های روز دنیا (Next.js)',
        'category' => 'landing',
        'badge_bg' => 'bg-emerald-900/30',
        'badge_text_color' => 'text-emerald-400',
        'badge_label' => 'شرکتی'
    ],
    [
        'id' => 'etehad_store',
        'url' => 'https://etehad.vercel.app/',
        'img' => '/src/etehad.png',
        'title' => 'فروشگاه اتحاد',
        'desc' => 'فروشگاه تخصصی لپ‌تاپ استوک با طراحی واکنش‌گرا (React)',
        'category' => 'store',
        'badge_bg' => 'bg-blue-900/30',
        'badge_text_color' => 'text-blue-400',
        'badge_label' => 'فروشگاهی'
    ]
];

foreach ($projects as $proj) {
    $project_id = $proj['id'];
    $project_url = $proj['url'];
    $project_img = $proj['img'];
    $project_title = $proj['title'];
    $project_desc = $proj['desc'];
    $project_category = $proj['category'];
    
    // بررسی وضعیت آنلاین بودن
    $is_online = checkServerStatus($project_url);

    // ساخت HTML کارت پروژه
    $html = '';
    $html .= '<div class="portfolio-card glass-effect rounded-2xl" data-category="' . $project_category . '" data-aos="fade-up">';

    // لینک پیش‌نمایش به صورت مستقیم
    $previewLink = 'preview.php?url=' . urlencode($project_url) . '&title=' . urlencode($project_title);

    // --- بخش iframe زنده و نوار پیشرفت ---
    $html .= '<div class="relative w-full h-56 bg-slate-800 overflow-hidden group iframe-container">';

    // نوار پیشرفت در بالای تصویر (رنگ گرادینت سبز/آبی)
    $html .= '  <div class="absolute top-0 left-0 w-full h-1 bg-white/10 z-20 transition-opacity duration-300">';
    $html .= '      <div class="progress-bar h-full bg-gradient-to-r from-emerald-400 to-teal-500 w-0 transition-all duration-300 shadow-[0_0_10px_rgba(52,211,153,0.7)]"></div>';
    $html .= '  </div>';

    // --- Toast / اعلان هشدار VPN ---
    // این پیام روی آی‌فریم نمایش داده می‌شود تا کاربر بداند چرا ممکن است تصویر لود نشود
    $html .= '  <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 bg-slate-900/90 backdrop-blur border border-white/10 text-amber-400 text-[10px] py-2 px-3 rounded-full pointer-events-none flex items-center gap-2 shadow-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">';
    $html .= '      <i data-feather="alert-triangle" class="w-3 h-3"></i>';
    $html .= '      <span>در صورت عدم مشاهده، VPN را روشن کنید</span>';
    $html .= '  </div>';
    // نسخه همیشه نمایان (اختیاری: اگر می‌خواهید همیشه دیده شود کلاس opacity-0 و group-hover را حذف کنید)
    // در اینجا من یک نسخه محوتر را همیشه نشان می‌دهم که با هاور پررنگ می‌شود:
     $html .= '  <div class="absolute bottom-2 right-2 z-10 bg-black/60 backdrop-blur text-white/70 text-[10px] py-1 px-2 rounded flex items-center gap-1 pointer-events-none group-hover:opacity-0 transition-opacity duration-300">';
    $html .= '      <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>';
    $html .= '      <span>نیاز به VPN</span>';
    $html .= '  </div>';


    // Iframe با آدرس مستقیم (بدون پروکسی)
    // کلاس‌ها برای کوچک‌نمایی (Scale) نمای دسکتاپ
    $html .= '  <iframe src="' . $project_url . '" class="w-[200%] h-[200%] transform origin-top-left scale-50 border-0 opacity-0 transition-opacity duration-700 pointer-events-none" scrolling="no" loading="lazy"></iframe>';

    // لینک نامرئی روی کل بخش تصویر برای هدایت به صفحه preview.php
    $html .= '  <a href="' . $previewLink . '" class="absolute inset-0 z-30 cursor-pointer hover:bg-black/10 transition duration-300"></a>';

    $html .= '</div>'; // پایان بخش تصویر/iframe

    // بخش محتوا
    $html .= '<div class="p-6 flex-grow flex flex-col">';

    // عنوان و تگ
    $html .= '<div class="flex justify-between items-start mb-3">';
    $html .= '<h3 class="text-xl font-bold">' . $project_title . '</h3>';
    // استفاده از استایل‌های داینامیک بجای هاردکد
    $html .= '<span class="text-xs ' . $proj['badge_bg'] . ' ' . $proj['badge_text_color'] . ' px-3 py-1 rounded-full whitespace-nowrap">' . $proj['badge_label'] . '</span>';
    $html .= '</div>';

    // توضیحات
    $html .= '<p class="text-gray-400 mb-4 flex-grow">' . $project_desc . '</p>';

    // نمایش وضعیت سرور
    if ($is_online) {
        $html .= '<div class="mb-3 text-xs text-green-400 flex items-center" title="Server Check: 200 OK">';
        $html .= '<span class="w-2 h-2 rounded-full bg-green-500 mr-2 inline-block"></span> سرور در دسترس است';
        $html .= '</div>';
    } else {
        $html .= '<div class="mb-3 text-xs text-red-400 flex items-center" title="Server Check: Failed">';
        $html .= '<span class="w-2 h-2 rounded-full bg-red-500 mr-2 inline-block"></span> سرور خارج از دسترس (بررسی کنید)';
        $html .= '</div>';
    }

    // دکمه مشاهده
    $html .= '<a href="' . $previewLink . '" class="text-blue-400 hover:text-blue-300 flex items-center mt-auto">';
    $html .= 'مشاهده پیش‌نمایش آنلاین';
    $html .= '<i data-feather="eye" class="w-4 h-4 mr-2"></i>'; 
    $html .= '</a>';

    $html .= '</div>'; // پایان div.p-6
    $html .= '</div>'; // پایان div.portfolio-card

    // اضافه کردن به آرایه خروجی
    $output[$project_id] = $html;
}

// ارسال خروجی به صورت JSON
echo json_encode($output);
?>