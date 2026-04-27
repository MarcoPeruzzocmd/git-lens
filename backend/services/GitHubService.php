<?php
// =============================================================================
// 📁 ARQUIVO: backend/services/GitHubService.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o serviço que COMUNICA com a API do GitHub.
//   Ele é quem vai lá no GitHub, busca os commits de um repositório
//   e traz os dados de volta para o nosso sistema processar.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   É o "mensageiro" entre o nosso sistema e o GitHub.
//   O frontend manda a URL do repositório → o controller recebe →
//   chama ESTE serviço → ele vai na API do GitHub → traz os commits.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. MÉTODO: parseRepoUrl($url)
//      - Recebe uma URL como "https://github.com/facebook/react"
//      - Precisa extrair duas informações: o OWNER ("facebook") e o REPO ("react")
//      - Usar parse_url() + explode() para separar as partes da URL
//      - Tratar variações: com .git no final, sem https://, só "user/repo"
//      - Retornar um array com ['owner' => '...', 'repo' => '...']
//      - Se a URL for inválida, lançar uma Exception com mensagem clara
//
//   2. MÉTODO: fetchCommits($owner, $repo, $branch)
//      - Montar a URL da API: https://api.github.com/repos/{owner}/{repo}/commits
//      - Adicionar parâmetros: ?sha={branch}&per_page=100&page=1
//      - Fazer a requisição HTTP usando cURL (biblioteca do PHP para HTTP)
//      - IMPORTANTE: A API do GitHub retorna no MÁXIMO 100 commits por vez
//        Então precisa fazer um LOOP de paginação:
//          → Busca página 1 (100 commits)
//          → Busca página 2 (mais 100)
//          → Continua até a página vir com menos de 100 (acabou)
//      - Juntar todos os commits num array e retornar
//
//   3. MÉTODO PRIVADO: makeRequest($url)
//      - Usar cURL para fazer um GET na URL
//      - Configurar os headers obrigatórios da API do GitHub:
//          Accept: application/vnd.github.v3+json
//          User-Agent: (qualquer nome, é obrigatório)
//          Authorization: Bearer {seu_token} (se tiver token)
//      - Tratar erros: timeout, 404 (repo não existe), 403 (limite de requisições)
//      - Decodificar o JSON da resposta com json_decode
//      - Retornar o array de dados
//
// ▸ COMO FUNCIONA A API DO GITHUB (o que preciso saber):
//   - Endpoint de commits: GET /repos/{owner}/{repo}/commits
//   - Sem token: limite de 60 requisições por hora (muito pouco!)
//   - Com token: limite de 5.000 requisições por hora
//   - Cada commit retornado tem essa estrutura (simplificada):
//     {
//       "sha": "abc123...",
//       "commit": {
//         "message": "feat: adicionar login",
//         "author": {
//           "name": "João",
//           "email": "joao@email.com",
//           "date": "2024-01-15T10:30:00Z"
//         }
//       }
//     }
//   - Documentação oficial: https://docs.github.com/en/rest/commits/commits
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - cURL no PHP (curl_init, curl_setopt, curl_exec, curl_close)
//   - APIs REST (o que é, como funciona GET, headers, status codes)
//   - API do GitHub (autenticação, paginação, rate limits)
//   - JSON no PHP (json_decode para transformar JSON em array)
//   - parse_url() do PHP para parsear URLs
//   - Tratamento de erros com try/catch e Exception
//   - O que é um Personal Access Token do GitHub e como gerar
//
// ▸ COMO TESTAR SE FUNCIONA?
//   - Testar parseRepoUrl com várias URLs diferentes
//   - Testar fetchCommits com um repositório público pequeno
//   - Verificar se a paginação funciona com um repo que tem +100 commits
//   - Testar sem token (deve funcionar, mas com limite baixo)
//   - Testar com URL inválida (deve dar erro claro)
//
// ▸ CUIDADOS:
//   - Colocar um limite máximo de páginas (ex: 50) para não ficar em loop
//     infinito em repositórios gigantes como o Linux (1 milhão+ de commits)
//   - Sempre enviar o header User-Agent (a API do GitHub rejeita sem ele)
//   - Tratar o erro 403 com mensagem amigável pedindo para configurar o token
// =============================================================================

class GitHubService
{
    // =========================================================================
    // MÉTODO 1: Extrair owner e repo de uma URL do GitHub
    // =========================================================================

    public static function parseRepoUrl(string $url): array
    {
        // 1. Limpar a URL antes de parsear
        $url = trim($url);
        $url = rtrim($url, '/');
        $url = str_replace('.git', '', $url);

        // 2. Parsear a URL e extrair o path
        $parsed = parse_url($url);

        if (!$parsed || empty($parsed['path'])) {
            throw new Exception("URL do repositório inválida", 400);
        }

        // 3. Limpar o path e quebrar em partes
        $path = trim($parsed['path'], '/');
        $parts = explode('/', $path);
        $total = count($parts);

        if ($total < 2) {
            throw new Exception('URL inválida. Use: https://github.com/usuario/repositorio', 400);
        }

        // 4. Pegar owner e repo (os dois últimos pedaços)
        $owner = $parts[$total - 2];
        $repo = $parts[$total - 1];

        if (empty($owner) || empty($repo)) {
            throw new Exception('URL inválida. Use: https://github.com/usuario/repositorio', 400);
        }

        // 5. Retornar owner e repo
        return ['owner' => $owner, 'repo' => $repo];
    }

    // =========================================================================
    // MÉTODO 2: Buscar todos os commits de um repositório (com paginação)
    // =========================================================================

    public function fetchCommits(string $owner, string $repo, string $branch = 'main'): array
    {
        $allCommits = [];
        $page = 1;

        do {
            // Montar a URL da API do GitHub para cada página
            $url = "https://api.github.com/repos/$owner/$repo/commits?sha=$branch&per_page=100&page=$page";

            // Fazer a requisição HTTP (método abaixo)
            $response = $this->makeRequest($url);

            // Juntar os commits desta página com os anteriores
            $allCommits = array_merge($allCommits, $response);

            $page++;

            // Continuar enquanto a página veio cheia (100) e não passou do limite
        } while (count($response) === 100 && $page <= 50);

        return $allCommits;
    }

    // =========================================================================
    // MÉTODO 3: Fazer requisição HTTP para a API do GitHub
    // =========================================================================

    private function makeRequest(string $url): array
    {
        $ch = curl_init();
        $token = getenv('GITHUB_TOKEN');

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTPHEADER     => [
                'Accept: application/vnd.github.v3+json',
                'User-Agent: GitLens-App',
                $token ? "Authorization: Bearer $token" : '',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new Exception("Erro na requisição ao GitHub: $error", 502);
        }

        if ($httpCode === 404) {
            throw new Exception('Repositório não encontrado. Verifique a URL.', 404);
        }

        if ($httpCode === 403) {
            throw new Exception('Limite da API do GitHub atingido. Configure o GITHUB_TOKEN no .env.', 429);
        }

        if ($httpCode >= 400) {
            throw new Exception("Erro na API do GitHub (HTTP $httpCode)", $httpCode);
        }

        $data = json_decode($response, true);

        if (!is_array($data)) {
            throw new Exception('Erro ao decodificar resposta da API do GitHub', 502);
        }

        return $data;
    }
}
