// =============================================================================
// 📁 ARQUIVO: frontend/src/components/SummaryCards.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Componente que exibe os CARDS DE RESUMO no topo da página de resultados.
//   São aqueles cartõezinhos com números grandes que dão uma visão geral rápida.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Mostrar de forma visual e rápida:
//   - Total de commits analisados
//   - Quantidade de autores/contribuidores
//   - Tipo de commit mais frequente
//   - Branch analisada
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. RECEBER OS DADOS VIA PROPS:
//      - data → objeto com total_commits, by_author, by_type, branch
//
//   2. CALCULAR OS VALORES:
//      - Total de commits: data.total_commits (já vem pronto)
//      - Total de autores: Object.keys(data.by_author).length
//      - Tipo mais frequente: pegar a primeira chave de by_type
//        (já vem ordenado do backend, o primeiro é o mais frequente)
//
//   3. RENDERIZAR OS CARDS:
//      Cada card é um <div> com:
//        - Um ícone ou emoji representativo
//        - O número grande (ex: "150")
//        - Um label descritivo (ex: "Total de Commits")
//      Usar CSS Grid ou Flexbox para alinhar os cards lado a lado.
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Componentes funcionais no React
//   - Desestruturação de props
//   - Object.keys() e Object.entries() do JavaScript
//   - CSS Grid ou Flexbox para layout de cards
//   - Estilização no React (CSS Modules, styled-components, ou CSS puro)
//
// ▸ DICA:
//   Comece com HTML/CSS puro e dados hardcoded. Depois substitua pelos dados reais.
// =============================================================================
