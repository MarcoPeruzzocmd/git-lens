// =============================================================================
// 📁 ARQUIVO: frontend/src/components/AuthorTable.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Componente que exibe uma TABELA com as estatísticas de cada autor/contribuidor.
//   Mostra quem fez o quê: quantos commits de cada tipo cada pessoa fez.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Permitir que o usuário veja a contribuição individual de cada membro do time.
//   Exemplo: "João fez 20 feats (40%), 15 fixes (30%), 5 refactors (10%)..."
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. RECEBER OS DADOS VIA PROPS:
//      - data → objeto by_author do backend:
//        {
//          "João Silva": {
//            total: 50,
//            types: {
//              "feat": { count: 20, percentage: 40.0 },
//              "fix":  { count: 15, percentage: 30.0 }
//            }
//          },
//          "Maria Santos": { ... }
//        }
//
//   2. TRANSFORMAR EM ARRAY PARA ITERAR:
//      Usar Object.entries(data) para converter o objeto em array de [nome, dados].
//
//   3. RENDERIZAR A TABELA:
//      <table>
//        <thead>
//          <tr>
//            <th>Autor</th>
//            <th>Total</th>
//            <th>feat</th>
//            <th>fix</th>
//            <th>refactor</th>
//            ... (uma coluna para cada tipo)
//          </tr>
//        </thead>
//        <tbody>
//          Para cada autor, uma <tr> com:
//            <td>Nome do autor</td>
//            <td>Total de commits</td>
//            <td>Count (porcentagem%)</td>  ← para cada tipo
//        </tbody>
//      </table>
//
//   4. EXTRAS (melhorias opcionais):
//      - Barras de progresso dentro das células (mini progress bars)
//      - Ordenação clicando no cabeçalho da coluna
//      - Highlight na linha ao passar o mouse (hover)
//      - Filtro por autor (input de busca)
//      - Cores diferentes para cada tipo (mesma paleta do gráfico)
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Renderização de listas no React (.map() com key)
//   - Object.entries() para iterar sobre objetos
//   - Tabelas HTML (<table>, <thead>, <tbody>, <tr>, <th>, <td>)
//   - Estilização de tabelas com CSS
//   - Ordenação de arrays no JavaScript (.sort())
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Passar dados fake como prop e verificar se a tabela renderiza corretamente.
//   Testar com 1 autor, 5 autores, e 20 autores.
//
// ▸ DICA:
//   Comece com uma tabela HTML simples sem estilo. Depois vá melhorando.
//   A parte mais chatinha é alinhar as colunas dos tipos — nem todo autor
//   tem todos os tipos, então precisa tratar quando um tipo não existe
//   (mostrar 0 ou "-").
// =============================================================================
