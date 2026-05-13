CREATE TABLE analyses (
    id INT PRIMARY KEY AUTO_INCREMENT, 
    owner VARCHAR(100) NOT NULL, 
    repo VARCHAR(100) NOT NULL,
    stats JSON NOT NULL,
    total_commits INT NOT NULL,
    branch VARCHAR(100) DEFAULT 'main',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_analyses_owner_repo ON analyses(owner, repo);
