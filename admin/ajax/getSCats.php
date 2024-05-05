<?php
include "../../server/connection.php";

$cat_id = $conn->real_escape_string($_POST['value']);

$stmt3 = $conn->prepare("SELECT * FROM `sub_categories` WHERE sb_cat_categories_id = ? AND `sb_cat_status` = '1'");
$stmt3->bind_param('i', $cat_id);
if ($stmt3->execute()) {
    $categories = $stmt3->get_result()->fetch_all(MYSQLI_ASSOC);
    if (!empty($categories)) {
        echo json_encode([
            'error' => false,
            'details' => $categories,
        ]);
    } else {
        echo json_encode([
            'error' => true,
            'message' => 'No sub-categories found.',
        ]);
    }
} else {
    echo json_encode([
        'error' => true,
        'message' => 'Failed to fetch sub-categories.',
    ]);
}

die();
