import SearchForm from './components/SearchForm'
import './styles/App.css'

function App() {
  return <SearchForm />
}

export default App

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

