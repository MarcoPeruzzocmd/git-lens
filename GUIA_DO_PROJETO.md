# 🔍 GitLens — Guia Completo do Projeto

## O que é este projeto?
Um sistema web que analisa repositórios do GitHub e classifica os commits
por tipo (feat, fix, refactor, docs, etc.), mostrando estatísticas por
autor e por tipo com gráficos e porcentagens.

---

## 📂 Estrutura de Pastas (Mapa do Projeto)

```
git-lens/
│
├── 📄 docker-compose.yml          ← Orquestra todos os containers
├── 📄 .env.example                ← Modelo de variáveis de ambiente
├── 📄 .gitignore                  ← Arquivos ignorados pelo Git
├── 📄 GUIA_DO_PROJETO.md          ← ESTE ARQUIVO (guia geral)
│
├── 📁 database/
│   └── 📄 init.sql                ← Cria as tabelas do banco MySQL
│
├── 📁 backend/
│   ├── 📄 Dockerfile              ← Receita Docker (Apache + PHP)
│   ├── 📄 .htaccess               ← Redireciona URLs para index.php
│   ├── 📄 index.php               ← Ponto de entrada da API (roteador)
│   │
│   ├── 📁 config/
│   │   └── 📄 Database.php        ← Conexão com o MySQL (Singleton)
│   │
│   ├── 📁 controllers/
│   │   └── 📄 AnalyzeController.php ← Recebe requisições e orquestra
│   │
│   ├── 📁 services/
│   │   ├── 📄 GitHubService.php     ← Comunica com a API do GitHub
│   │   └── 📄 CommitAnalyzerService.php ← Classifica commits por tipo
│   │
│   └── 📁 repositories/
│       └── 📄 AnalysisRepository.php ← Acessa o banco (SQL)
│
└── 📁 frontend/
    ├── 📄 Dockerfile              ← Receita Docker (Node + Vite)
    ├── 📄 package.json            ← Dependências do frontend
    ├── 📄 vite.config.js          ← Configuração do Vite
    ├── 📄 index.html              ← HTML base (único)
    │
    └── 📁 src/
        ├── 📄 main.jsx            ← Inicializa o React
        ├── 📄 App.jsx             ← Componente raiz (orquestra tudo)
        │
        ├── 📁 services/
        │   └── 📄 api.js          ← Chamadas HTTP ao backend
        │
        ├── 📁 components/
        │   ├── 📄 SearchForm.jsx    ← Formulário de busca (URL do repo)
        │   ├── 📄 SummaryCards.jsx  ← Cards de resumo (totais)
        │   ├── 📄 TypeChart.jsx     ← Gráfico pizza/barras por tipo
        │   ├── 📄 AuthorTable.jsx   ← Tabela de estatísticas por autor
        │   ├── 📄 AuthorChart.jsx   ← Gráfico de barras por autor
        │   └── 📄 CommitList.jsx    ← Lista detalhada de commits
        │
        └── 📁 styles/
            └── 📄 App.css          ← Estilos CSS da aplicação
```

---

## 🔄 Fluxo de Dados (como tudo se conecta)

```
USUÁRIO cola URL do repo no frontend
        │
        ▼
[SearchForm.jsx] captura a URL e envia para App.jsx
        │
        ▼
[api.js] faz GET para http://localhost/api/analyze?url=...
        │
        ▼
[index.php] recebe a requisição e roteia para o controller
        │
        ▼
[AnalyzeController.php] orquestra o fluxo:
        │
        ├──▶ [GitHubService.php] vai na API do GitHub buscar os commits
        │           │
        │           ▼
        │    API do GitHub retorna os commits brutos (JSON)
        │
        ├──▶ [CommitAnalyzerService.php] analisa cada commit:
        │       - Detecta o tipo (feat, fix, refactor...)
        │       - Agrupa por autor e por tipo
        │       - Calcula contagens e porcentagens
        │
        ├──▶ [AnalysisRepository.php] salva o resultado no MySQL
        │
        └──▶ Retorna JSON com as estatísticas
                    │
                    ▼
[App.jsx] recebe os dados e passa para os componentes:
        │
        ├──▶ [SummaryCards.jsx] → mostra totais
        ├──▶ [TypeChart.jsx] → mostra gráfico por tipo
        ├──▶ [AuthorTable.jsx] → mostra tabela por autor
        ├──▶ [AuthorChart.jsx] → mostra gráfico por autor
        └──▶ [CommitList.jsx] → mostra lista de commits
```

---

## 🛤️ Ordem de Implementação Sugerida

### Fase 1 — Infraestrutura (Docker + Banco)
1. `backend/Dockerfile` — Configurar Apache + PHP
2. `frontend/Dockerfile` — Configurar Node + Vite
3. `docker-compose.yml` — Orquestrar os 3 containers
4. `database/init.sql` — Criar a tabela no MySQL
5. `.env.example` → copiar para `backend/.env` e preencher
6. Testar: `docker-compose up --build` — tudo sobe sem erro?

### Fase 2 — Backend (API)
7. `backend/config/Database.php` — Conexão com MySQL
8. `backend/services/GitHubService.php` — Buscar commits do GitHub
9. `backend/services/CommitAnalyzerService.php` — Classificar commits
10. `backend/repositories/AnalysisRepository.php` — Salvar no banco
11. `backend/controllers/AnalyzeController.php` — Orquestrar tudo
12. `backend/index.php` — Roteamento e CORS
13. `backend/.htaccess` — Rewrite de URLs
14. Testar: acessar http://localhost/api/analyze?url=... no navegador

### Fase 3 — Frontend (Interface)
15. Inicializar o projeto React: `npm create vite@latest`
16. `frontend/src/services/api.js` — Chamadas ao backend
17. `frontend/src/components/SearchForm.jsx` — Formulário
18. `frontend/src/App.jsx` — Conectar form com API
19. Testar: submeter URL e ver dados no console

### Fase 4 — Visualização
20. `frontend/src/components/SummaryCards.jsx` — Cards de resumo
21. `frontend/src/components/TypeChart.jsx` — Gráfico por tipo
22. `frontend/src/components/AuthorTable.jsx` — Tabela por autor
23. `frontend/src/components/CommitList.jsx` — Lista de commits
24. `frontend/src/styles/App.css` — Estilizar tudo
25. `frontend/src/components/AuthorChart.jsx` — Gráfico por autor (extra)

---

## 📚 O que estudar (por área)

### Docker
- O que são containers e por que usar
- Dockerfile (FROM, RUN, COPY, EXPOSE, CMD)
- docker-compose.yml (services, volumes, ports, depends_on)
- Comandos: docker-compose up, down, logs, exec

### PHP
- Sintaxe básica (variáveis, funções, classes)
- OOP (classes, métodos, construtores, visibilidade)
- mysqli (conexão com MySQL, prepared statements)
- cURL (fazer requisições HTTP para APIs externas)
- json_encode / json_decode
- Regex (preg_match) para detectar tipos de commit
- Tratamento de erros (try/catch, Exception)

### MySQL
- CREATE TABLE, INSERT, SELECT
- Tipos de dados (INT, VARCHAR, JSON, TIMESTAMP)
- Prepared Statements (segurança contra SQL Injection)
- Índices (o que são, por que usar)

### React
- Componentes funcionais e JSX
- useState e useEffect
- Props (passar dados entre componentes)
- Renderização de listas (.map com key)
- Formulários controlados
- Requisições HTTP (fetch ou axios)

### JavaScript
- async/await e Promises
- Manipulação de arrays (map, filter, reduce)
- Manipulação de objetos (Object.keys, Object.entries)
- Desestruturação
- Módulos ES6 (import/export)

### API do GitHub
- Documentação: https://docs.github.com/en/rest/commits/commits
- Autenticação com Personal Access Token
- Paginação (per_page, page)
- Rate limits (60/hora sem token, 5000/hora com token)

### Conventional Commits
- Padrão: https://www.conventionalcommits.org/pt-br
- Formato: tipo(escopo): descrição
- Tipos: feat, fix, refactor, docs, style, test, chore, perf, ci, build
