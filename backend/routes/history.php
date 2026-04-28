<?php
$controller = new AnalyzeController();

switch ($method) {
    case 'GET':
        if ($code) {
            $controller->show((int) $code);
        } else {
            $controller->history();
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
        break;
}
