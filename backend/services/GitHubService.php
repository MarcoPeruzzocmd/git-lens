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
//      - Usar regex ou explode para separar as partes da URL
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
//   - Regex no PHP (preg_match) para parsear a URL do repositório
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
