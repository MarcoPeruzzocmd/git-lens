// =============================================================================
// 📁 ARQUIVO: frontend/src/components/SearchForm.jsx
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   Componente do formulário onde o usuário cola a URL do repositório GitHub.
//   É a PRIMEIRA coisa que o usuário interage na aplicação.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Capturar a URL do repositório e (opcionalmente) a branch,
//   e enviar esses dados para o componente pai (App) processar.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. ESTADOS LOCAIS (useState):
//      - url (string) → valor do input de URL
//      - branch (string) → valor do input de branch (padrão: "main")
//
//   2. FUNÇÃO: handleSubmit(event)
//      - Chamar event.preventDefault() (evitar reload da página)
//      - Validar se a URL não está vazia
//      - Chamar a prop onSubmit(url, branch) que veio do App
//
//   3. RENDERIZAÇÃO (JSX):
//      - Um <form> com onSubmit={handleSubmit}
//      - Um <input> para a URL do repositório
//        → type="text", placeholder="https://github.com/usuario/repo"
//        → value={url}, onChange para atualizar o estado
//      - Um <input> para a branch (opcional)
//        → type="text", placeholder="main"
//        → value={branch}, onChange para atualizar o estado
//      - Um <button> type="submit" para enviar
//      - Desabilitar o botão enquanto estiver carregando (prop loading)
//
// ▸ PROPS QUE ESTE COMPONENTE RECEBE:
//   - onSubmit(url, branch) → função chamada quando o form é submetido
//   - loading (boolean) → se true, desabilitar o botão e mostrar "Analisando..."
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - Formulários no React (controlled components)
//   - useState para inputs
//   - event.preventDefault() (por que usar em forms)
//   - Props (receber funções como prop)
//   - Validação básica de formulário
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Renderizar o componente, digitar uma URL, clicar em enviar.
//   Verificar no console se a função onSubmit é chamada com os valores certos.
//
// ▸ DICA:
//   Comece com só o input de URL e o botão. A branch pode ser adicionada depois.
// =============================================================================
