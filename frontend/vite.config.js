// =============================================================================
// 📁 ARQUIVO: frontend/vite.config.js
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Configuração do Vite — o bundler/dev server do frontend.
//   O Vite é quem compila o React, faz hot reload, e serve os arquivos.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Dizer ao Vite como se comportar:
//   - Qual framework usar (React)
//   - Em qual porta rodar (5173)
//   - Configurações de proxy (opcional, para evitar CORS)
//
// ▸ O QUE PRECISO FAZER AQUI?
//   1. Importar defineConfig do 'vite'
//   2. Importar o plugin do React: @vitejs/plugin-react
//      (instalar: npm install @vitejs/plugin-react)
//   3. Exportar a configuração com:
//      - plugins: [react()]
//      - server.host: '0.0.0.0' (para acessar de fora do container Docker)
//      - server.port: 5173
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Vite (o que é, por que é rápido, diferença para Webpack)
//   - Bundlers (o que fazem, por que existem)
//   - HMR (Hot Module Replacement — atualizar sem recarregar a página)
//   - Plugins do Vite
//
// ▸ DICA:
//   Se rodar "npm create vite@latest" ele gera este arquivo automaticamente.
//   Quase nunca precisa mexer nele no início.
// =============================================================================
