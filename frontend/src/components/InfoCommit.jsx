import '../styles/InfoCommit.css'

const COMMIT_TYPES = [
  { label: 'FEAT:', desc: 'nova funcionalidade', className: 'feat' },
  { label: 'FIX:', desc: 'correção de bug', className: 'fix' },
  { label: 'REFACTOR:', desc: 'refatoração', className: 'refactor' },
  { label: 'DOCS:', desc: 'documentação', className: 'docs' },
  { label: 'TEST:', desc: 'testes', className: 'test' },
  { label: 'CHORE:', desc: 'manutenção', className: 'chore' },
]

function InfoCommit() {
  return (
    <div className="commit-types">
      {COMMIT_TYPES.map((type) => (
        <div className="commit-card" key={type.label}>
          <span className={`commit-label ${type.className}`}>{type.label}</span>
          <p className="commit-desc">{type.desc}</p>
        </div>
      ))}
    </div>
  )
}

export default InfoCommit
