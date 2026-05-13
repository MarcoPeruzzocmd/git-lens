<?php
$controller = new BranchesController();
switch ($method) {
    case 'GET':
        $controller->index();
        break;
    
    default:
        http_response_code(400);
        echo json_encode(['error'=> 'Método não permitido']);
        break;
}