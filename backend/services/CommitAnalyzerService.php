<?php
// =============================================================================
// 📁 ARQUIVO: backend/services/CommitAnalyzerService.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o CÉREBRO do projeto. Ele recebe os commits brutos que vieram do GitHub
//   e faz toda a análise: classifica cada commit por tipo (feat, fix, refactor...),
//   agrupa por autor, conta quantos de cada tipo, e calcula as porcentagens.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   GitHubService traz os dados crus → ESTE ARQUIVO processa e transforma
//   em estatísticas úteis → o Controller devolve pro frontend exibir.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. DEFINIR OS TIPOS DE COMMIT (como constante ou array):
//      Os tipos seguem o padrão "Conventional Commits":
//        feat     → Nova funcionalidade
//        fix      → Correção de bug
//        refactor → Refatoração (mudar código sem mudar comportamento)
//        docs     → Documentação
//        style    → Formatação (espaços, vírgulas, sem mudar lógica)
//        test     → Testes
//        chore    → Manutenção (atualizar dependências, configs)
//        perf     → Performance
//        ci       → CI/CD (GitHub Actions, pipelines)
//        build    → Build (webpack, vite, npm)
//        revert   → Reverter commit anterior
//        other    → Não se encaixa em nenhum (fallback)
//
//   2. MÉTODO: analyze($commits)
//      Recebe o array de commits e retorna as estatísticas completas.
//      Passo a passo:
//
//      a) Criar 3 estruturas vazias:
//         - $byAuthor → agrupar por nome do autor
//         - $byType   → agrupar por tipo de commit
//         - $commits  → lista detalhada de cada commit
//
//      b) Para CADA commit no array:
//         - Extrair: mensagem, nome do autor, email, data, sha
//         - Chamar detectType($mensagem) para descobrir o tipo
//         - Adicionar +1 no contador do autor para aquele tipo
//         - Adicionar +1 no contador geral daquele tipo
//         - Adicionar na lista detalhada
//
//      c) Depois do loop, calcular as PORCENTAGENS:
//         - Por autor: (commits do tipo X / total do autor) * 100
//         - Por tipo:  (commits do tipo X / total geral) * 100
//         - Usar round() para arredondar (ex: 33.333 → 33.3)
//
//      d) Ordenar: autores por total de commits (desc), tipos por count (desc)
//
//      e) Retornar tudo num array organizado
//
//   3. MÉTODO PRIVADO: detectType($message)
//      Este é o método mais IMPORTANTE. Ele olha a mensagem do commit
//      e decide qual é o tipo. Duas estratégias:
//
//      ESTRATÉGIA 1 — Regex para Conventional Commits:
//        O padrão é: tipo(escopo): descrição
//        Exemplos:
//          "feat: login com Google"        → tipo = feat
//          "fix(auth): corrigir token"     → tipo = fix
//          "refactor!: simplificar lógica" → tipo = refactor
//        Regex sugerida: /^(\w+)(\(.+?\))?!?:\s/
//        Se o match der um tipo conhecido, retorna ele.
//
//      ESTRATÉGIA 2 — Fallback por palavras-chave:
//        Muitos repositórios NÃO usam Conventional Commits.
//        Então, se a estratégia 1 falhar, procurar palavras na mensagem:
//          "fix bug no login"     → contém "fix" → tipo = fix
//          "add new feature"      → contém "add" → tipo = feat
//          "update readme"        → contém "readme" → tipo = docs
//          "refactor user module" → contém "refactor" → tipo = refactor
//        Criar um mapa de palavras-chave para cada tipo.
//
//      ESTRATÉGIA 3 — Se nada funcionar:
//        Retornar "other"
//
// ▸ EXEMPLO DE SAÍDA ESPERADA DO analyze():
//   {
//     "total_commits": 150,
//     "by_author": {
//       "João Silva": {
//         "total": 50,
//         "types": {
//           "feat": { "count": 20, "percentage": 40.0 },
//           "fix":  { "count": 15, "percentage": 30.0 }
//         }
//       }
//     },
//     "by_type": {
//       "feat": { "count": 60, "percentage": 40.0 },
//       "fix":  { "count": 45, "percentage": 30.0 }
//     },
//     "commits": [
//       { "sha": "abc1234", "message": "feat: login", "author": "João", "type": "feat" }
//     ]
//   }
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Conventional Commits (https://www.conventionalcommits.org/pt-br)
//     → Entender o padrão de mensagens de commit usado pela indústria
//   - Regex no PHP (preg_match) → Para detectar o tipo do commit
//   - Manipulação de arrays no PHP (foreach, isset, array_merge)
//   - Funções matemáticas: round() para porcentagens
//   - Ordenação de arrays: uasort() para ordenar mantendo as chaves
//   - str_contains() do PHP 8 para buscar palavras-chave
//   - strtolower() para comparações case-insensitive
//
// ▸ COMO TESTAR SE FUNCIONA?
//   - Criar um array fake de commits com mensagens variadas
//   - Testar se "feat: algo" é detectado como feat
//   - Testar se "fix bug" (sem padrão) é detectado como fix pelo fallback
//   - Testar se as porcentagens somam ~100% por autor
//   - Testar com mensagens em português e inglês
//   - Testar com commit sem tipo reconhecível (deve ser "other")
//
// ▸ DICA:
//   Comece pelo detectType() — ele é o coração deste arquivo.
//   Depois faça o analyze() que usa o detectType() internamente.
// =============================================================================
