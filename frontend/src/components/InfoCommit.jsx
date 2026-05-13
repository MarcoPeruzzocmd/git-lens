import { Badge } from './ui/badge'
import { Card, CardContent } from './ui/card'

const COMMIT_TYPES = [
  { label: 'FEAT:', desc: 'nova funcionalidade' },
  { label: 'FIX:', desc: 'correção de bug' },
  { label: 'REFACTOR:', desc: 'refatoração' },
  { label: 'DOCS:', desc: 'documentação' },
  { label: 'TEST:', desc: 'testes' },
  { label: 'CHORE:', desc: 'manutenção' },
]

function InfoCommit() {
  return (
    <div className="grid grid-cols-3 gap-2.5 w-full max-w-[900px] p-1">
      {COMMIT_TYPES.map((type) => (
        <Card key={type.label}>
          <CardContent className="p-5">
            <Badge className="text-primary mb-1.5 block">{type.label}</Badge>
            <p className="text-sm text-subtle">{type.desc}</p>
          </CardContent>
        </Card>
      ))}
    </div>
  )
}

export default InfoCommit
