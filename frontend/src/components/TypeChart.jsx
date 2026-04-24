// =============================================================================
// 📁 ARQUIVO: frontend/src/components/TypeChart.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Componente que exibe o GRÁFICO de distribuição de commits por tipo.
//   É a visualização principal do projeto — mostra visualmente quantos
//   commits são feat, fix, refactor, etc.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Transformar os dados numéricos (contagem e porcentagem por tipo)
//   em um gráfico visual (pizza, donut, ou barras).
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. ESCOLHER UMA BIBLIOTECA DE GRÁFICOS:
//      Opções populares (instalar via npm):
//      - recharts → Mais popular para React, fácil de usar
//        npm install recharts
//      - chart.js + react-chartjs-2 → Muito flexível e bonito
//        npm install chart.js react-chartjs-2
//      - nivo → Gráficos lindos, mas mais complexo
//        npm install @nivo/pie
//
//   2. TRANSFORMAR OS DADOS PARA O FORMATO DA BIBLIOTECA:
//      Os dados chegam do backend assim:
//        by_type: {
//          "feat": { count: 60, percentage: 40.0, label: "Feature" },
//          "fix":  { count: 45, percentage: 30.0, label: "Bug Fix" },
//          ...
//        }
//      Cada biblioteca espera um formato diferente. Ex para recharts:
//        [
//          { name: "Feature", value: 60, percentage: 40.0 },
//          { name: "Bug Fix", value: 45, percentage: 30.0 },
//        ]
//      Usar Object.entries() para converter o objeto em array.
//
//   3. RENDERIZAR O GRÁFICO:
//      - Gráfico de PIZZA/DONUT para visão geral de proporções
//      - OU gráfico de BARRAS para comparação direta entre tipos
//      - Adicionar legenda com os nomes dos tipos
//      - Adicionar tooltip que mostra count e porcentagem ao passar o mouse
//      - Usar cores diferentes para cada tipo (definir uma paleta)
//
//   4. DEFINIR CORES POR TIPO (sugestão):
//      feat     → verde (#22c55e)
//      fix      → vermelho (#ef4444)
//      refactor → azul (#3b82f6)
//      docs     → amarelo (#eab308)
//      style    → roxo (#a855f7)
//      test     → ciano (#06b6d4)
//      chore    → cinza (#6b7280)
//      other    → cinza claro (#9ca3af)
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Biblioteca de gráficos escolhida (ler a documentação oficial)
//   - Object.entries() e .map() para transformar dados
//   - Componentes React com props
//   - Responsividade em gráficos (ResponsiveContainer do recharts)
//   - Cores hexadecimais e paletas de cores
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Passar dados fake como prop e ver se o gráfico renderiza.
//   Testar com poucos tipos (2-3) e com muitos (10+).
//   Testar responsividade redimensionando a janela.
//
// ▸ DICA:
//   Comece com o gráfico mais simples possível (ex: PieChart do recharts
//   com dados hardcoded). Depois conecte com os dados reais.
//   A documentação do recharts tem exemplos prontos para copiar.
// =============================================================================
