<?php
// =============================================================================
// 📁 ARQUIVO: backend/index.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o PONTO DE ENTRADA de toda a API. Toda requisição HTTP que chega
//   no backend passa por aqui PRIMEIRO. É como a "recepção" de um prédio.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   1. Carregar as variáveis de ambiente (.env)
//   2. Configurar os headers CORS
//   3. Registrar o autoload de classes
//   4. Rotear a requisição para o controller correto
//   5. Tratar erros globais
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   PARTE 1 — CARREGAR VARIÁVEIS DE AMBIENTE:
//     - Ler o arquivo .env linha por linha com file()
//     - Para cada linha que não for vazia e não começar com #:
//       → Registrar como variável de ambiente com putenv()
//     - Isso permite usar getenv('GITHUB_TOKEN') em qualquer lugar
//
//   PARTE 2 — CONFIGURAR HEADERS CORS:
//     O que é CORS? Quando o frontend (porta 5173) tenta acessar o backend
//     (porta 80), o navegador BLOQUEIA por segurança (são "origens" diferentes).
//     Os headers CORS dizem ao navegador: "pode deixar, eu autorizo".
//     Headers necessários:
//       Access-Control-Allow-Origin: http://localhost:5173
//       Access-Control-Allow-Methods: GET, POST, OPTIONS
//       Access-Control-Allow-Headers: Content-Type
//       Content-Type: application/json
//     Também tratar requisições OPTIONS (preflight) — responder 200 e sair.
//
//   PARTE 3 — AUTOLOAD DE CLASSES:
//     Registrar com spl_autoload_register() uma função que, quando uma classe
//     é usada pela primeira vez (ex: new GitHubService()), automaticamente
//     procura o arquivo correspondente nas pastas:
//       services/, controllers/, repositories/, config/
//     Isso evita ter que escrever require/include manual para cada classe.
//
//   PARTE 4 — ROTEAMENTO:
//     Pegar a rota da URL ($_GET['route']) e direcionar para o controller certo.
//     Usar match() do PHP 8 ou if/elseif:
//       'api/analyze'       → (new AnalyzeController())->analyze()
//       'api/history'       → (new AnalyzeController())->history()
//       'api/history/{id}'  → (new AnalyzeController())->show($id)
//       qualquer outra      → erro 404
//
//   PARTE 5 — TRATAMENTO DE ERROS:
//     Envolver o roteamento num try/catch.
//     Se qualquer Exception for lançada em qualquer lugar do sistema,
//     ela "borbulha" até aqui e é capturada.
//     Retornar um JSON de erro: { "error": true, "message": "...", "code": 404 }
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Front Controller Pattern (toda requisição passa por um arquivo só)
//   - CORS (Cross-Origin Resource Sharing) — o que é e por que existe
//   - Variáveis de ambiente (o que são, por que usar, .env)
//   - spl_autoload_register() do PHP (autoloading de classes)
//   - match() do PHP 8 (alternativa moderna ao switch)
//   - try/catch e Exception no PHP
//   - HTTP Methods (GET, POST, OPTIONS) e Status Codes (200, 400, 404, 500)
//   - Superglobais do PHP ($_GET, $_SERVER)
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Com o Docker rodando, acessar http://localhost/ no navegador.
//   Deve retornar um JSON de erro 404 (rota não encontrada) — isso é bom!
//   Significa que o index.php está funcionando e roteando.
//
// ▸ ORDEM DE IMPLEMENTAÇÃO SUGERIDA:
//   1. Parte 1 (env) e Parte 2 (CORS) — são simples e independentes
//   2. Parte 3 (autoload) — precisa das pastas criadas
//   3. Parte 5 (try/catch) — estrutura de erro
//   4. Parte 4 (rotas) — precisa dos controllers existirem
// =============================================================================

// ⚠️  ECHO DE TESTE — remova quando começar a implementar o código de verdade
require_once __DIR__ . '/config/env.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

spl_autoload_register(function ($className) {
    $dirs = ['config/', 'services/', 'controllers/', 'repositories/'];
    foreach ($dirs as $dir) {
        $file = __DIR__ . '/' . $dir . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$resource = strtolower($segments[0] ?? null);
$code = $segments[1] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($resource) {
        case 'analyze':
            require_once __DIR__ . '/routes/analyze.php';
            break;

        case 'history':
            require_once __DIR__ . '/routes/history.php';
            break;

        default:
            http_response_code(404);
            echo json_encode(['error' => 'Rota não encontrada']);
            break;
    }
} catch (Exception $e) {
    $code = $e->getCode() ?: 500;
    http_response_code($code);
    echo json_encode([
        'error' => true,
        'message' => $e->getMessage(),
        'code' => $code
    ]);
}