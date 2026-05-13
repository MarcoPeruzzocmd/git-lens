import { useState } from "react";
import { Input } from "./ui/input";
import { Button } from "./ui/button";
import { BranchCombobox } from "./ui/combobox";
import { analyzeRepo, getBranches } from "../services/api";
import InfoCommit from "./InfoCommit";

function SearchForm({ onSubmit, loading }) {
  const [url, setUrl] = useState("");
  const [branch, setBranch] = useState("");
  const [branches, setBranches] = useState([
    "main",
    "master",
    "develop",
    "staging",
    "production",
  ]);
  const [isValidUrl, setIsValidUrl] = useState(false);

  function handleSubmit(event) {
    event.preventDefault();
    if (!url) {
      return alert("url invalida");
    }
    onSubmit(url, branch);
  }


  async function handlerUrlBlur() {
    if (!url) return;
    try {
      const result = await getBranches(url);
      console.log("branches recebidas:", result);
      setBranches(result);
    } catch (e) {
      console.error("erro");
    }
  }

  return (
    <div className="flex flex-col items-center justify-center min-h-screen text-center px-8 py-8">
      {/* Logo */}
      <div className="flex items-center justify-center mb-6">
        <img
          src="logo-gitLens.png"
          alt="GitLens"
          className="w-[100px] h-[100px]"
        />
      </div>

      {/* Badge */}
      <p className="text-xs text-subtle tracking-wide mb-6">
        ● Conventional Commits Analyzer
      </p>

      {/* Título */}
      <h1 className="text-[clamp(2rem,5vw,3.2rem)] font-extrabold text-foreground leading-tight mb-4 max-w-[1000px]">
        Analise os commits do{" "}
        <span className="text-primary">seu repositório</span>
      </h1>

      {/* Subtítulo */}
      <p className="text-base text-subtle leading-relaxed mb-10 max-w-[500px]">
        Cole o link de um repositório do GitHub ou envie um arquivo de commits.
        <br />
        Filtre por autor, time e período — e veja a distribuição por tipo.
      </p>

      {/* Form */}
      <form
        onSubmit={handleSubmit}
        className="flex items-center gap-2 bg-surface border border-border rounded-lg px-4 py-2 w-full max-w-[900px] mb-3"
      >
        <span className="text-subtle text-base shrink-0">⎇</span>
        <Input
          type="text"
          placeholder="https://github.com/owner/repo"
          value={url}
          onChange={(e) => {
            const value = e.target.value
            setUrl(value)
            setIsValidUrl(/^https?:\/\/github\.com\/[^/]+\/[^/]+/.test(value))
          }}
          onBlur={handlerUrlBlur}
          style={{ fontFamily: "'Science Gothic', sans-serif" }}
        />
        <BranchCombobox
          value={branch}
          onChange={setBranch}
          options={branches}
          disabled={!isValidUrl}
        />
        <Button type="submit" disabled={loading || !isValidUrl} className="shrink-0 mr-1">
          {loading ? "Analisando..." : "Analisar"}
        </Button>
      </form>

      {/* Hint */}
      <p className="text-xs text-faint mb-12">
        Repositórios públicos · até 300 commits mais recentes · arquivo JSON ou
        git log
      </p>

      {/* Cards de tipos de commit */}
      <InfoCommit />

      {/* Footer */}
      <p className="text-xs text-subtle font-semibold mt-8">
        Built with Conventional Commits spec
      </p>
    </div>
  );
}

export default SearchForm;
