<?php
$controller = new AnalyzeController();

switch ($method) {
    case 'GET':
        $controller->analyze();
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
        break;
}
