<?php
class BranchesController {
    public function index(): void{
        $url =$_GET['url'] ?? '';
        if(!$url){
            http_response_code(400);
            echo json_encode(['error' => 'Parâmetro url é obrigatório']);
            return;
        }
        $github = new GitHubService();
        $parsed = GitHubService::parseRepoUrl($url);
        $branches = $github->fetchBranches($parsed['owner'], $parsed['repo']);
        echo json_encode(['branches' => $branches]);
    }
}