<?php
// =============================================================================
// 📁 ARQUIVO: backend/controllers/AnalyzeController.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o CONTROLLER — o "maestro" que coordena tudo.
//   Ele recebe a requisição do frontend, chama os serviços certos,
//   e devolve a resposta. Ele NÃO faz lógica pesada, só orquestra.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Frontend faz requisição → index.php roteia → ESTE CONTROLLER recebe
//   → chama GitHubService (buscar commits) → chama CommitAnalyzerService
//   (analisar) → chama AnalysisRepository (salvar) → devolve JSON.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. CONSTRUTOR: __construct()
//      - Criar instâncias dos 3 objetos que este controller precisa:
//        a) GitHubService → para buscar commits do GitHub
//        b) CommitAnalyzerService → para analisar/classificar os commits
//        c) AnalysisRepository → para salvar/buscar do banco de dados
//      - Guardar cada um numa propriedade da classe
//
//   2. MÉTODO: analyze()
//      Rota: GET /api/analyze?url=https://github.com/user/repo&branch=main
//      Passo a passo:
//        a) Pegar o parâmetro "url" da query string ($_GET['url'])
//        b) Pegar o parâmetro "branch" (opcional, padrão "main")
//        c) Validar: se url estiver vazio, lançar Exception com código 400
//        d) Chamar GitHubService::parseRepoUrl($url) para extrair owner e repo
//        e) Chamar GitHubService->fetchCommits($owner, $repo, $branch)
//        f) Chamar CommitAnalyzerService->analyze($commits)
//        g) Chamar AnalysisRepository->save($owner, $repo, $stats, $total, $branch)
//        h) Montar o JSON de resposta com os dados e dar echo
//
//   3. MÉTODO: history()
//      Rota: GET /api/history
//      - Chamar AnalysisRepository->findAll()
//      - Retornar a lista como JSON
//      - Simples: só busca do banco e devolve
//
//   4. MÉTODO: show($id)
//      Rota: GET /api/history/{id}
//      - Receber o ID como parâmetro
//      - Chamar AnalysisRepository->findById($id)
//      - Se não encontrar, lançar Exception com código 404
//      - Se encontrar, retornar como JSON
//
// ▸ FORMATO DA RESPOSTA JSON (para o frontend):
//   Sucesso:
//   {
//     "success": true,
//     "data": { ... os dados ... }
//   }
//
//   Erro (tratado no index.php):
//   {
//     "error": true,
//     "message": "Repositório não encontrado",
//     "code": 404
//   }
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Padrão MVC (Model-View-Controller) — entender o papel do Controller
//   - Superglobais do PHP ($_GET, $_POST, $_SERVER)
//   - json_encode() para transformar arrays PHP em JSON
//   - Tratamento de erros com Exception (throw, try/catch)
//   - HTTP Status Codes (200 OK, 400 Bad Request, 404 Not Found, 500 Server Error)
//   - O que é uma API REST e como estruturar respostas
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Com o Docker rodando, acessar no navegador ou Postman:
//   - http://localhost/api/analyze?url=https://github.com/usuario/repo
//   - http://localhost/api/history
//   - http://localhost/api/history/1
//   Verificar se o JSON retornado está correto.
//
// ▸ DICA:
//   Este é o arquivo mais SIMPLES de implementar, porque ele só chama
//   métodos dos outros arquivos. Implemente os Services e Repository
//   primeiro, depois este controller fica fácil.
// =============================================================================
class AnalyzeController{
    private $GitHubService;
    private $CommitAnalyzerService;
    private $AnalysisRepository;

    public function __construct(){
    $this->GitHubService = new GitHubService();
    $this->CommitAnalyzerService = new CommitAnalyzerService();
    $this->AnalysisRepository = new AnalysisRepository();
}
    public function analyze(){
        $url = $_GET['url'] ?? '';
        $branch = $_GET['branch'] ?? 'main';
        if(empty($url)){
            throw new Exception("URL do repositório é obrigatória.", 400);
        }
        $repoData = GitHubService::parseRepoUrl($url);
        $commits = $this->GitHubService->fetchCommits($repoData['owner'], $repoData['repo'], $branch);
        $analysis = $this->CommitAnalyzerService->analyze($commits);
        $this->AnalysisRepository->save($repoData['owner'], $repoData['repo'], $analysis, $analysis['total_commits'], $branch);
        echo json_encode(['success' => true, 'data' => $analysis]);
    }
    public function history(){
       $indexHistory = $this->AnalysisRepository->findAll();
       if (!$indexHistory) {
        return json_encode(['erro' => false, 'message' => 'Nenhuma análise encontrada.']);
       }
       echo json_encode(['success' => true, 'data' => $indexHistory]);
    }
    public function show($id){
        $analysis = $this->AnalysisRepository->findById($id);
        if (!$analysis) {
            throw new Exception("Análise não encontrada.", 404);
        }
        echo json_encode(['success' => true, 'data' => $analysis]);
    }
}