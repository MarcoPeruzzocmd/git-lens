// =============================================================================
// 📁 ARQUIVO: frontend/src/services/api.js
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Centraliza TODAS as chamadas HTTP do frontend para o backend.
//   Ao invés de espalhar fetch() ou axios por vários componentes,
//   todas as requisições ficam organizadas aqui.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Ser o "carteiro" entre o frontend e o backend.
//   Os componentes chamam funções deste arquivo, e ele faz a requisição
//   HTTP, trata erros, e retorna os dados prontos.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. DEFINIR A URL BASE DO BACKEND:
//      const API_BASE = 'http://localhost'
//      (ou usar variável de ambiente do Vite: import.meta.env.VITE_API_URL)
//
//   2. FUNÇÃO: analyzeRepo(url, branch)
//      - Fazer GET para: {API_BASE}/api/analyze?url={url}&branch={branch}
//      - Tratar a resposta: verificar se response.ok é true
//      - Se ok: retornar os dados (response.json())
//      - Se erro: lançar um Error com a mensagem do backend
//      - Retornar os dados para quem chamou
//
//   3. FUNÇÃO: getHistory()
//      - Fazer GET para: {API_BASE}/api/history
//      - Retornar a lista de análises anteriores
//
//   4. FUNÇÃO: getAnalysis(id)
//      - Fazer GET para: {API_BASE}/api/history/{id}
//      - Retornar os dados completos de uma análise
//
// ▸ ESCOLHA: fetch() vs axios
//   - fetch() → Nativo do navegador, não precisa instalar nada.
//     Porém, precisa fazer response.json() manualmente e tratar erros.
//   - axios → Biblioteca externa (npm install axios).
//     Mais prático: já faz json automaticamente, interceptors, etc.
//   Recomendação para iniciante: comece com fetch() para aprender,
//   depois migre para axios se quiser.
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - fetch API do JavaScript (GET, headers, response)
//   - Promises e async/await
//   - Tratamento de erros em requisições HTTP
//   - URL encoding (encodeURIComponent para a URL do repo)
//   - Módulos ES6 (export/import)
//   - Variáveis de ambiente no Vite (import.meta.env)
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Importar as funções no App.jsx e chamar com console.log:
//     const data = await analyzeRepo('https://github.com/user/repo');
//     console.log(data);
//   Verificar no DevTools (F12 → Network) se a requisição foi feita.
//
// ▸ DICA:
//   Sempre use try/catch ao chamar essas funções nos componentes.
//   Requisições HTTP podem falhar por N motivos (rede, servidor, etc.).
// =============================================================================
