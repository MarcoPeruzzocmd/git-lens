<?php
// =============================================================================
// 📁 ARQUIVO: backend/repositories/AnalysisRepository.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o REPOSITORY — a camada que fala diretamente com o banco de dados.
//   Toda query SQL do projeto fica concentrada aqui.
//   Nenhum outro arquivo do projeto deve escrever SQL.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Quando o Controller quer salvar uma análise ou buscar o histórico,
//   ele chama ESTE arquivo. Este arquivo monta a query SQL, executa
//   no banco, e retorna os dados prontos como array PHP.
//
// ▸ POR QUE SEPARAR O SQL NUM ARQUIVO SÓ?
//   Se amanhã você trocar MySQL por PostgreSQL, ou mudar a estrutura
//   da tabela, só precisa mudar ESTE arquivo. O resto do sistema
//   nem percebe. Isso se chama "separação de responsabilidades".
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. CONSTRUTOR: __construct()
//      - Chamar Database::getConnection() para pegar a conexão PDO
//      - Guardar numa propriedade da classe:
//        private PDO $db;
//        public function __construct() {
//            $this->db = Database::getConnection();
//        }
//
//   2. MÉTODO: save($owner, $repo, $stats, $totalCommits, $branch)
//      O que faz: Salva uma nova análise no banco.
//      Como fazer com PDO:
//
//        a) Preparar a query com placeholders nomeados (:nome):
//           $stmt = $this->db->prepare(
//               'INSERT INTO analyses (owner, repo, stats, total_commits, branch)
//                VALUES (:owner, :repo, :stats, :total, :branch)'
//           );
//
//        b) Converter o array $stats para JSON:
//           $statsJson = json_encode($stats, JSON_UNESCAPED_UNICODE);
//
//        c) Executar passando os valores:
//           $stmt->execute([
//               ':owner'  => $owner,
//               ':repo'   => $repo,
//               ':stats'  => $statsJson,
//               ':total'  => $totalCommits,
//               ':branch' => $branch,
//           ]);
//
//        d) Retornar o ID gerado:
//           return (int) $this->db->lastInsertId();
//
//   3. MÉTODO: findAll($limit = 50)
//      O que faz: Busca todas as análises salvas (resumo, sem o JSON pesado).
//      Como fazer com PDO:
//
//        $stmt = $this->db->prepare(
//            'SELECT id, owner, repo, total_commits, branch, created_at
//             FROM analyses
//             ORDER BY created_at DESC
//             LIMIT :limit'
//        );
//        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
//        $stmt->execute();
//        return $stmt->fetchAll(); // retorna array com todas as linhas
//
//      ATENÇÃO: LIMIT precisa de bindValue com PDO::PARAM_INT
//      Se passar direto no execute(), o PDO trata como string e o MySQL rejeita.
//
//   4. MÉTODO: findById($id)
//      O que faz: Busca UMA análise específica com todos os dados.
//      Como fazer com PDO:
//
//        $stmt = $this->db->prepare(
//            'SELECT * FROM analyses WHERE id = :id'
//        );
//        $stmt->execute([':id' => $id]);
//        $row = $stmt->fetch(); // fetch() pega só uma linha (ou false se não achar)
//
//        if (!$row) return null;
//
//        // Decodificar o JSON de stats de volta para array PHP
//        $row['stats'] = json_decode($row['stats'], true);
//        return $row;
//
// ▸ DIFERENÇA ENTRE fetch() E fetchAll():
//   - fetch()    → retorna UMA linha (a próxima) ou false se acabou
//   - fetchAll() → retorna TODAS as linhas de uma vez como array
//   Use fetch() quando espera 0 ou 1 resultado (busca por ID).
//   Use fetchAll() quando espera múltiplos resultados (listagem).
//
// ▸ SEGURANÇA — PREPARED STATEMENTS (MUITO IMPORTANTE!):
//   NUNCA faça isso: "SELECT * FROM analyses WHERE id = $id"
//   Isso permite SQL INJECTION — alguém pode destruir seu banco.
//   SEMPRE use placeholders (:id ou ?) e deixe o PDO escapar os valores.
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - SQL básico (INSERT, SELECT, WHERE, ORDER BY, LIMIT)
//   - PDO prepare() e execute() — como funcionam os prepared statements
//   - PDO fetch() vs fetchAll()
//   - PDO lastInsertId() — pegar o ID do último INSERT
//   - PDO bindValue() vs bindParam() — diferença e quando usar cada um
//   - SQL Injection — o que é e por que prepared statements protegem
//   - JSON no PHP (json_encode para salvar, json_decode para ler)
//   - Padrão Repository — separar acesso a dados da lógica de negócio
//
// ▸ COMO TESTAR SE FUNCIONA?
//   - Chamar save() com dados fake e verificar se aparece no banco
//     (usar DBeaver ou MySQL CLI para conferir)
//   - Chamar findAll() e ver se retorna os registros
//   - Chamar findById() com um ID que existe e um que não existe (deve retornar null)
// =============================================================================
