<?php
// =============================================================================
// ARQUIVO: backend/services/CommitAnalyzerService.php
// =============================================================================
//
// O QUE E ESTE ARQUIVO?
//   E o CEREBRO do projeto. Ele recebe os commits brutos que vieram do GitHub
//   e faz toda a analise: classifica cada commit por tipo (feat, fix, refactor...),
//   agrupa por autor, conta quantos de cada tipo, e calcula as porcentagens.
//
// QUAL A FUNCAO DELE NO PROJETO?
//   GitHubService traz os dados crus -> ESTE ARQUIVO processa e transforma
//   em estatisticas uteis -> o Controller devolve pro frontend exibir.
//
// O QUE PRECISO FAZER AQUI?
//
//   1. DEFINIR OS TIPOS DE COMMIT (como constante ou array):
//      Os tipos seguem o padrao Conventional Commits:
//        feat     -> Nova funcionalidade
//        fix      -> Correcao de bug
//        refactor -> Refatoracao (mudar codigo sem mudar comportamento)
//        docs     -> Documentacao
//        style    -> Formatacao (espacos, virgulas, sem mudar logica)
//        test     -> Testes
//        chore    -> Manutencao (atualizar dependencias, configs)
//        perf     -> Performance
//        ci       -> CI/CD (GitHub Actions, pipelines)
//        build    -> Build (webpack, vite, npm)
//        revert   -> Reverter commit anterior
//        other    -> Nao se encaixa em nenhum (fallback)
//
//   2. METODO: analyze(commits)
//      Recebe o array de commits e retorna as estatisticas completas.
//      Passo a passo:
//
//      a) Criar 3 estruturas vazias:
//         - byAuthor -> agrupar por nome do autor
//         - byType   -> agrupar por tipo de commit
//         - commits  -> lista detalhada de cada commit
//
//      b) Para CADA commit no array:
//         - Extrair: mensagem, nome do autor, email, data, sha
//         - Chamar detectType(mensagem) para descobrir o tipo
//         - Adicionar +1 no contador do autor para aquele tipo
//         - Adicionar +1 no contador geral daquele tipo
//         - Adicionar na lista detalhada
//
//      c) Depois do loop, calcular as PORCENTAGENS:
//         - Por autor: (commits do tipo X / total do autor) * 100
//         - Por tipo:  (commits do tipo X / total geral) * 100
//         - Usar round() para arredondar (ex: 33.333 -> 33.3)
//
//      d) Ordenar: autores por total de commits (desc), tipos por count (desc)
//
//      e) Retornar tudo num array organizado
//
//   3. METODO PRIVADO: detectType(message)
//      Este e o metodo mais IMPORTANTE. Ele olha a mensagem do commit
//      e decide qual e o tipo. Duas estrategias:
//
//      ESTRATEGIA 1 - Regex para Conventional Commits:
//        O padrao e: tipo(escopo): descricao
//        Exemplos:
//          feat: login com Google        -> tipo = feat
//          fix(auth): corrigir token     -> tipo = fix
//          refactor!: simplificar logica -> tipo = refactor
//        Regex sugerida: /^(\w+)(\(.+?\))?!?:\s/
//        Se o match der um tipo conhecido, retorna ele.
//
//      ESTRATEGIA 2 - Fallback por palavras-chave:
//        Muitos repositorios NAO usam Conventional Commits.
//        Entao, se a estrategia 1 falhar, procurar palavras na mensagem:
//          fix bug no login     -> contem fix -> tipo = fix
//          add new feature      -> contem add -> tipo = feat
//          update readme        -> contem readme -> tipo = docs
//          refactor user module -> contem refactor -> tipo = refactor
//        Criar um mapa de palavras-chave para cada tipo.
//
//      ESTRATEGIA 3 - Se nada funcionar:
//        Retornar other
//
// EXEMPLO DE SAIDA ESPERADA DO analyze():
//   {
//     total_commits: 150,
//     by_author: {
//       Joao Silva: {
//         total: 50,
//         types: {
//           feat: { count: 20, percentage: 40.0 },
//           fix:  { count: 15, percentage: 30.0 }
//         }
//       }
//     },
//     by_type: {
//       feat: { count: 60, percentage: 40.0 },
//       fix:  { count: 45, percentage: 30.0 }
//     },
//     commits: [
//       { sha: abc1234, message: feat: login, author: Joao, type: feat }
//     ]
//   }
//
// CONCEITOS QUE PRECISO ESTUDAR:
//   - Conventional Commits (https://www.conventionalcommits.org/pt-br)
//   - Regex no PHP (preg_match) para detectar o tipo do commit
//   - Manipulacao de arrays no PHP (foreach, isset, array_merge)
//   - Funcoes matematicas: round() para porcentagens
//   - Ordenacao de arrays: uasort() para ordenar mantendo as chaves
//   - str_contains() do PHP 8 para buscar palavras-chave
//   - strtolower() para comparacoes case-insensitive
//
// COMO TESTAR SE FUNCIONA?
//   - Criar um array fake de commits com mensagens variadas
//   - Testar se feat: algo e detectado como feat
//   - Testar se fix bug (sem padrao) e detectado como fix pelo fallback
//   - Testar se as porcentagens somam ~100% por autor
//   - Testar com mensagens em portugues e ingles
//   - Testar com commit sem tipo reconhecivel (deve ser other)
//
// DICA:
//   Comece pelo detectType() - ele e o coracao deste arquivo.
//   Depois faca o analyze() que usa o detectType() internamente.
// =============================================================================
