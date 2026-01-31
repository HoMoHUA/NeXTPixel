<?php



session_start();
if (isset($_SESSION['user_id'])) {
    
    $role = $_SESSION['role'] ?? $_SESSION['user_type'] ?? null;
    
    
    switch ($role) {
        case 'customer':
        case 'client':
            header('Location: /panel/client/index.php');
            break;
        case 'seller':
            header('Location: /panel/seller/dashboard.php');
            break;
        case 'designer':
            header('Location: /panel/designer/index.php');
            break;
        case 'admin':
            header('Location: /panel/index.php');
            break;
        default:
            header('Location: /panel/index.php');
            break;
    }
    exit;
}


header('Location: /login.php');
exit;

?>

