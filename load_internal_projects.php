<?php
header('Content-Type: application/json; charset=utf-8');

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
    
    $is_online = checkServerStatus($project_url);

    $html = '';
    $html .= '<div class="portfolio-card glass-effect rounded-2xl" data-category="' . $project_category . '" data-aos="fade-up">';

    $proxiedUrl = 'simple_proxy.php?url=' . urlencode($project_url);
    
    $previewLink = 'preview.php?url=' . urlencode($proxiedUrl) . '&title=' . urlencode($project_title);

    $html .= '<div class="relative w-full h-56 bg-slate-800 overflow-hidden group iframe-container">';

    $html .= '  <div class="absolute top-0 left-0 w-full h-1 bg-white/10 z-20 transition-opacity duration-300">';
    $html .= '      <div class="progress-bar h-full bg-gradient-to-r from-emerald-400 to-teal-500 w-0 transition-all duration-300 shadow-[0_0_10px_rgba(52,211,153,0.7)]"></div>';
    $html .= '  </div>';

    $html .= '  <iframe src="' . $proxiedUrl . '" class="w-[200%] h-[200%] transform origin-top-left scale-50 border-0 opacity-0 transition-opacity duration-700 pointer-events-none" scrolling="no" loading="lazy"></iframe>';

    $html .= '  <a href="' . $previewLink . '" class="absolute inset-0 z-30 cursor-pointer hover:bg-black/10 transition duration-300"></a>';

    $html .= '</div>'; 

    $html .= '<div class="p-6 flex-grow flex flex-col">';

    $html .= '<div class="flex justify-between items-start mb-3">';
    $html .= '<h3 class="text-xl font-bold">' . $project_title . '</h3>';
    $html .= '<span class="text-xs ' . $proj['badge_bg'] . ' ' . $proj['badge_text_color'] . ' px-3 py-1 rounded-full whitespace-nowrap">' . $proj['badge_label'] . '</span>';
    $html .= '</div>';

    $html .= '<p class="text-gray-400 mb-4 flex-grow">' . $project_desc . '</p>';

    if ($is_online) {
        $html .= '<div class="mb-3 text-xs text-green-400 flex items-center" title="Server Check: 200 OK">';
        $html .= '<span class="w-2 h-2 rounded-full bg-green-500 mr-2 inline-block"></span> سرور در دسترس است';
        $html .= '</div>';
    } else {
        $html .= '<div class="mb-3 text-xs text-red-400 flex items-center" title="Server Check: Failed">';
        $html .= '<span class="w-2 h-2 rounded-full bg-red-500 mr-2 inline-block"></span> سرور خارج از دسترس (بررسی کنید)';
        $html .= '</div>';
    }

    $html .= '<a href="' . $previewLink . '" class="text-blue-400 hover:text-blue-300 flex items-center mt-auto">';
    $html .= 'مشاهده پیش‌نمایش آنلاین';
    $html .= '<i data-feather="eye" class="w-4 h-4 mr-2"></i>'; 
    $html .= '</a>';

    $html .= '</div>'; 
    $html .= '</div>'; 

    $output[$project_id] = $html;
}

echo json_encode($output);
?>