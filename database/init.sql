CREATE TABLE IF NOT EXISTS analyses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    owner VARCHAR(100) NOT NULL,
    repo VARCHAR(100) NOT NULL,
    stats JSON NOT NULL,
    total_commits INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
CREATE INDEX  idx_analyses_owner_repo ON analyses(owner, repo)