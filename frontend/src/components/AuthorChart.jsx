// =============================================================================
// 📁 ARQUIVO: frontend/src/components/AuthorChart.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Componente que exibe um GRÁFICO DE BARRAS EMPILHADAS por autor.
//   Cada barra representa um autor, e as cores dentro da barra mostram
//   a proporção de cada tipo de commit.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Visualizar de forma gráfica a contribuição de cada membro do time,
//   mostrando não só QUANTO cada um commitou, mas COMO (quais tipos).
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. RECEBER OS DADOS VIA PROPS:
//      - data → objeto by_author do backend
//
//   2. TRANSFORMAR OS DADOS:
//      Converter de objeto para array no formato da biblioteca de gráficos.
//      Para um StackedBarChart do recharts, o formato seria:
//        [
//          { name: "João", feat: 20, fix: 15, refactor: 5, ... },
//          { name: "Maria", feat: 10, fix: 20, refactor: 8, ... },
//        ]
//
//   3. RENDERIZAR O GRÁFICO:
//      - Gráfico de barras empilhadas (StackedBarChart)
//      - Eixo X: nomes dos autores
//      - Eixo Y: quantidade de commits
//      - Cada segmento da barra = um tipo de commit com cor diferente
//      - Legenda mostrando qual cor é qual tipo
//      - Tooltip ao passar o mouse mostrando os detalhes
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Gráficos de barras empilhadas (stacked bar chart)
//   - Biblioteca de gráficos escolhida (recharts, chart.js, etc.)
//   - Transformação de dados (Object.entries, .map, .reduce)
//
// ▸ DICA:
//   Este componente é OPCIONAL — é um extra legal para ter.
//   Implemente o TypeChart (pizza) primeiro, que é mais simples.
//   Depois faça este como melhoria.
// =============================================================================
