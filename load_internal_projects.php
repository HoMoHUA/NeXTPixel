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

// --- پروژه ۱: باتیس مدرن ---
// شناسه این پروژه باید دقیقاً با id تعریف شده در آرایه portfolio.php یکسان باشد
$project_id = 'batis_modern';
$project_url = 'https://batis-modern.vercel.app';
$project_img = '/src/batis.png'; // مسیر تصویر
$project_title = 'باتیس مدرن';
$project_desc = 'طراحی مدرن و مینیمال با استفاده از تکنولوژی‌های روز دنیا (Next.js)';
$project_category = 'landing';

// بررسی وضعیت آنلاین بودن (سمت سرور انجام می‌شود تا IP سرور استفاده شود)
$is_online = checkServerStatus($project_url);

// ساخت HTML کارت پروژه
$html = '';
// کلاس‌ها دقیقاً مشابه فایل اصلی برای هماهنگی ظاهری
$html .= '<div class="portfolio-card glass-effect rounded-2xl" data-category="' . $project_category . '" data-aos="fade-up">';

// بخش تصویر
$html .= '<a href="' . $project_url . '" target="_blank" rel="noopener noreferrer" class="block overflow-hidden">';
// اگر تصویر وجود نداشت، یک باکس خالی نمایش می‌دهد (اختیاری)
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $project_img)) {
    $html .= '<img src="' . $project_img . '" alt="' . $project_title . '" class="w-full h-56 object-cover">';
} else {
    // در صورتی که عکس نباشد، عکس پیش‌فرض یا پلیس‌هولدر
    $html .= '<img src="' . $project_img . '" alt="' . $project_title . '" class="w-full h-56 object-cover" onerror="this.src=\'https://via.placeholder.com/400x300?text=No+Image\'">'; 
}
$html .= '</a>';

// بخش محتوا
$html .= '<div class="p-6 flex-grow flex flex-col">';

// عنوان و تگ
$html .= '<div class="flex justify-between items-start mb-3">';
$html .= '<h3 class="text-xl font-bold">' . $project_title . '</h3>';
$html .= '<span class="text-xs bg-emerald-900/30 text-emerald-400 px-3 py-1 rounded-full whitespace-nowrap">شرکتی</span>';
$html .= '</div>';

// توضیحات
$html .= '<p class="text-gray-400 mb-4 flex-grow">' . $project_desc . '</p>';

// نمایش وضعیت سرور (این بخش مختص پروژه‌های AJAX است)
if ($is_online) {
    $html .= '<div class="mb-3 text-xs text-green-400 flex items-center" title="Server Check: 200 OK">';
    $html .= '<span class="w-2 h-2 rounded-full bg-green-500 mr-2 inline-block"></span> سرور در دسترس است';
    $html .= '</div>';
} else {
    $html .= '<div class="mb-3 text-xs text-red-400 flex items-center" title="Server Check: Failed">';
    $html .= '<span class="w-2 h-2 rounded-full bg-red-500 mr-2 inline-block"></span> سرور خارج از دسترس';
    $html .= '</div>';
}

// دکمه مشاهده
$html .= '<a href="' . $project_url . '" target="_blank" rel="noopener noreferrer" class="text-blue-400 hover:text-blue-300 flex items-center mt-auto">';
$html .= 'مشاهده وبسایت';
$html .= '<i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>';
$html .= '</a>';

$html .= '</div>'; // پایان div.p-6
$html .= '</div>'; // پایان div.portfolio-card

// اضافه کردن به آرایه خروجی با کلید شناسه پروژه
$output[$project_id] = $html;


// --- اگر در آینده پروژه‌های دیگری اضافه کردید، بلوک بالا را کپی کرده و متغیرها را تغییر دهید ---
// $output['another_project_id'] = '...HTML...';

// ارسال خروجی به صورت JSON
echo json_encode($output);
?>