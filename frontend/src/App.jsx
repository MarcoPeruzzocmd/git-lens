// =============================================================================
// 📁 ARQUIVO: frontend/src/App.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o COMPONENTE RAIZ do React — o ponto de partida de toda a interface.
//   Todos os outros componentes são filhos dele.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Organizar a estrutura geral da página:
//   - Renderizar o formulário de busca (SearchForm)
//   - Quando o usuário submeter, chamar a API do backend
//   - Passar os dados recebidos para os componentes de visualização
//   - Gerenciar o estado global da aplicação (loading, erro, dados)
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. ESTADOS (useState):
//      Criar estados para controlar a aplicação:
//      - loading (boolean) → true enquanto espera a resposta da API
//      - error (string|null) → mensagem de erro, se houver
//      - data (object|null) → dados da análise retornados pela API
//
//   2. FUNÇÃO: handleAnalyze(url, branch)
//      Chamada quando o usuário submete o formulário.
//      Passo a passo:
//        a) Setar loading = true, error = null
//        b) Fazer um GET para: http://localhost/api/analyze?url={url}&branch={branch}
//           Usar fetch() ou axios
//        c) Se der certo: setar data com a resposta, loading = false
//        d) Se der erro: setar error com a mensagem, loading = false
//
//   3. RENDERIZAÇÃO (return JSX):
//      Montar a página com os componentes:
//        <header> → Título do projeto (GitLens)
//        <SearchForm onSubmit={handleAnalyze} />
//        {loading && <LoadingSpinner />}
//        {error && <ErrorMessage message={error} />}
//        {data && (
//          <>
//            <SummaryCards data={data} />
//            <TypeChart data={data.by_type} />
//            <AuthorTable data={data.by_author} />
//            <CommitList commits={data.commits} />
//          </>
//        )}
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - React (componentes, JSX, renderização)
//   - useState (gerenciamento de estado)
//   - useEffect (efeitos colaterais, se necessário)
//   - fetch API ou axios (requisições HTTP)
//   - async/await (programação assíncrona em JavaScript)
//   - Renderização condicional no React ({condition && <Component />})
//   - Props (como passar dados de pai para filho)
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Com o Docker rodando, acessar http://localhost:5173
//   Deve aparecer a interface. Colar uma URL de repo e submeter.
//   Verificar no DevTools (F12 → Network) se a requisição ao backend funciona.
//
// ▸ DICA:
//   Comece simples: só o formulário + um console.log dos dados.
//   Depois vá adicionando os componentes visuais um por um.
// =============================================================================
