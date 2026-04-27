-- =============================================================================
-- 📁 ARQUIVO: database/init.sql
-- =============================================================================
--
-- ▸ O QUE É ESTE ARQUIVO?
--   É o script SQL que CRIA as tabelas do banco de dados.
--   Executado automaticamente pelo MySQL quando o container Docker
--   é criado pela primeira vez.
--
-- ▸ QUAL A FUNÇÃO DELE NO PROJETO?
--   Definir a ESTRUTURA do banco de dados — quais tabelas existem,
--   quais colunas cada uma tem, quais tipos de dados, índices, etc.
--
-- ▸ COMO ELE É EXECUTADO?
--   No docker-compose.yml, este arquivo é montado em:
--     /docker-entrypoint-initdb.d/init.sql
--   O MySQL executa automaticamente todos os .sql dessa pasta
--   na PRIMEIRA vez que o container é criado (quando o volume está vazio).
--   Se o container já existir, ele NÃO executa de novo.
--
-- ▸ O QUE PRECISO FAZER AQUI?
--
--   CRIAR A TABELA "analyses":
--   Cada linha desta tabela = uma análise completa de um repositório.
--
--   Colunas necessárias:
--     id            → INT, AUTO_INCREMENT, PRIMARY KEY
--                     Identificador único, gerado automaticamente
--
--     owner         → VARCHAR(100), NOT NULL
--                     Dono do repositório (ex: "facebook" em facebook/react)
--
--     repo          → VARCHAR(100), NOT NULL
--                     Nome do repositório (ex: "react" em facebook/react)
--
--     stats         → JSON, NOT NULL
--                     Campo JSON que guarda TODAS as estatísticas da análise
--                     (por autor, por tipo, lista de commits, porcentagens)
--                     O MySQL 8 tem suporte nativo a JSON!
--
--     total_commits → INT, NOT NULL
--                     Total de commits analisados (redundante com o JSON,
--                     mas útil para listagens rápidas sem parsear o JSON)
--
--     branch        → VARCHAR(100), DEFAULT 'main'
--                     Qual branch foi analisada
--
--     created_at    → TIMESTAMP, DEFAULT CURRENT_TIMESTAMP
--                     Data/hora em que a análise foi feita (automático)
CREATE TABLE analyses (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    owner VARCHAR(100) NOT NULL, 
    repo VARCHAR(100) NOT NULL,
    stats JSON NOT NULL,
    total_commits INT NOT NULL,
    branch VARCHAR(100) DEFAULT 'main',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
CREATE INDEX idx_analyses_owner_repo ON analyses(owner, repo);

--
--   CRIAR UM ÍNDICE:
--     CREATE INDEX idx_analyses_owner_repo ON analyses(owner, repo)
--     Isso acelera buscas por owner+repo (ex: "já analisei este repo antes?")
--
-- ▸ CONCEITOS QUE PRECISO ESTUDAR:
--   - SQL DDL (CREATE TABLE, tipos de dados, PRIMARY KEY, AUTO_INCREMENT)
--   - Tipos de dados MySQL (INT, VARCHAR, JSON, TIMESTAMP)
--   - Índices no MySQL (o que são, por que usar, CREATE INDEX)
--   - JSON no MySQL 8 (como armazenar e consultar dados JSON)
--   - Docker volumes (por que o init.sql só roda na primeira vez)
--
-- ▸ COMO TESTAR SE FUNCIONA?
--   1. Subir o Docker: docker-compose up db
--   2. Conectar no MySQL: docker exec -it mysql_gitlens mysql -u root -p
--   3. Rodar: USE gitlens; SHOW TABLES; DESCRIBE analyses;
--   4. Se a tabela aparecer com as colunas certas, funcionou!
--
-- ▸ CUIDADO:
--   Se mudar este arquivo DEPOIS de já ter criado o container,
--   as mudanças NÃO serão aplicadas automaticamente.
--   Precisa deletar o volume: docker-compose down -v
--   E subir de novo: docker-compose up db
-- =============================================================================
