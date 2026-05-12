// =============================================================================
// 📁 ARQUIVO: frontend/src/components/SearchForm.jsx
// =============================================================================
// Componente visual da página inicial — formulário de busca do repositório.
// A lógica (useState, handleSubmit, chamada à API) será implementada depois.
// =============================================================================

import '../styles/SearchForm.css'
import InfoCommit from './InfoCommit'

function SearchForm() {
  return (
    <div className="home">

      {/* Logo */}
      <div className="logo-box">
        <img src="logo-gitLens.png" alt="GitLens" className="logo-icon" />
      </div>

      {/* Badge */}
      <p className="badge">● Conventional Commits Analyzer</p>

      {/* Título */}
      <h1 className="title">
        Analise os commits do <span className="title-highlight">seu repositório</span>
      </h1>

      {/* Subtítulo */}
      <p className="subtitle">
        Cole o link de um repositório do GitHub ou envie um arquivo de commits.<br />
        Filtre por autor, time e período — e veja a distribuição por tipo.
      </p>

      {/* Input + Botões */}
      <div className="search-box">
        <div className="search-input-wrapper">
          <span className="search-icon">⎇</span>
          <input
            className="search-input"
            type="text"
            placeholder="https://github.com/owner/repo"
          />
        </div>
        <button className="btn-analyze">Analisar</button>
      </div>

      {/* Hint */}
      <p className="search-hint">
        Repositórios públicos · até 300 commits mais recentes · arquivo JSON ou git log
      </p>

      {/* Cards de tipos de commit */}
      <InfoCommit />

      {/* Footer */}
      <p className="footer-text">Built with Conventional Commits spec</p>

    </div>
  )
}

export default SearchForm

