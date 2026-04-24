// =============================================================================
// 📁 ARQUIVO: frontend/src/components/CommitList.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Componente que exibe a LISTA DETALHADA de todos os commits analisados.
//   Cada commit aparece com seu tipo (badge colorido), mensagem, autor e data.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Permitir que o usuário veja commit por commit, com o tipo identificado.
//   Útil para conferir se a classificação automática está correta e para
//   ter uma visão detalhada do histórico.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. RECEBER OS DADOS VIA PROPS:
//      - commits → array de objetos:
//        [
//          {
//            sha: "abc1234",
//            message: "feat: adicionar login",
//            author: "João Silva",
//            date: "2024-01-15T10:30:00Z",
//            type: "feat",
//            label: "Feature"
//          },
//          ...
//        ]
//
//   2. RENDERIZAR A LISTA:
//      Para cada commit, renderizar um item com:
//        - BADGE colorido com o tipo (ex: [feat] em verde, [fix] em vermelho)
//        - Mensagem do commit (primeira linha)
//        - Nome do autor
//        - Data formatada (converter ISO para formato legível)
//        - Hash curto (sha) em cinza
//
//   3. FILTROS (funcionalidade importante!):
//      Adicionar filtros para o usuário poder ver só o que interessa:
//        - Filtrar por TIPO: botões/chips para cada tipo (feat, fix, refactor...)
//          Clicar em "feat" → mostrar só commits do tipo feat
//        - Filtrar por AUTOR: dropdown ou chips com os nomes dos autores
//        - Busca por TEXTO: input para buscar na mensagem do commit
//      Usar useState para guardar os filtros ativos.
//      Usar .filter() no array antes de renderizar.
//
//   4. PAGINAÇÃO OU SCROLL INFINITO:
//      Se tiver muitos commits (500+), não renderizar todos de uma vez.
//      Opções:
//        - Mostrar os primeiros 50 e um botão "Carregar mais"
//        - Paginação com botões de página
//        - Scroll infinito (mais avançado)
//
//   5. FORMATAR A DATA:
//      A data vem no formato ISO: "2024-01-15T10:30:00Z"
//      Converter para algo legível: "15 jan 2024" ou "há 3 dias"
//      Usar: new Date(dateString).toLocaleDateString('pt-BR')
//      Ou uma biblioteca como date-fns ou dayjs (opcional)
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Renderização de listas no React (.map() com key)
//   - Filtragem de arrays (.filter())
//   - useState para gerenciar filtros
//   - Formatação de datas no JavaScript (Date, toLocaleDateString)
//   - CSS para badges/chips coloridos
//   - Paginação ou "load more" pattern
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Passar um array de commits fake e verificar se renderiza.
//   Testar os filtros: clicar em "feat" e ver se só aparecem feats.
//   Testar com lista vazia (deve mostrar mensagem "Nenhum commit").
//
// ▸ DICA:
//   Este é o componente mais COMPLEXO do frontend. Implemente em etapas:
//   1° → Lista simples sem filtro
//   2° → Adicionar badges coloridos
//   3° → Adicionar filtro por tipo
//   4° → Adicionar filtro por autor
//   5° → Adicionar paginação
// =============================================================================
