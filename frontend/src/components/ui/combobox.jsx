import { useState } from 'react'
import { Command } from 'cmdk'
import { GitBranch, Check, ChevronsUpDown } from 'lucide-react'
import { cn } from '@/lib/utils'

function BranchCombobox({ value, onChange, options, disabled }) {
  const [open, setOpen] = useState(false)
  const [search, setSearch] = useState('')

  const filtered = (options || []).filter((o) =>
    o.toLowerCase().includes(search.toLowerCase())
  )

  function select(option) {
    onChange(option)
    setSearch('')
    setOpen(false)
  }

  return (
    <div className={cn('relative shrink-0', disabled && 'cursor-not-allowed')}>
      {/* Trigger */}
      <button
        type="button"
        onClick={() => {
          if (disabled) return
          setOpen((v) => !v)
        }}
        className={cn(
          'flex items-center gap-1.5 border border-border rounded-md px-2.5 py-1.5 text-sm transition-colors',
          'text-subtle hover:text-foreground hover:border-primary/60',
          open && 'border-primary text-foreground',
          disabled && 'opacity-50 cursor-not-allowed '
        )}
      >
        <GitBranch size={13} />
        <span className="w-20 text-left truncate">{value || 'Branch'}</span>
        <ChevronsUpDown size={12} className="opacity-50" />
      </button>

      {/* Dropdown */}
      {open && (
        <div className="absolute right-0 top-full mt-1 z-50 w-48 rounded-md border border-border bg-surface shadow-lg">
          <Command>
            <div className="flex items-center gap-2 border-b border-border px-3 py-2">
              <GitBranch size={13} className="text-subtle shrink-0" />
              <Command.Input
                value={search}
                onValueChange={setSearch}
                placeholder="Buscar branch..."
                className="w-full bg-transparent text-sm text-foreground placeholder:text-faint focus:outline-none"
              />
            </div>
            <Command.List className="max-h-48 overflow-y-auto p-1">
              {filtered.length === 0 && (
                <Command.Empty className="py-2 text-center text-xs text-subtle">
                  Nenhuma branch encontrada
                </Command.Empty>
              )}
              {filtered.map((option) => (
                <Command.Item
                  key={option}
                  value={option}
                  onSelect={() => select(option)}
                  className={cn(
                    'flex items-center justify-between rounded px-3 py-1.5 text-sm cursor-pointer transition-colors',
                    'text-subtle hover:text-foreground hover:bg-muted',
                    value === option && 'text-foreground'
                  )}
                >
                  {option}
                  {value === option && <Check size={13} className="text-primary" />}
                </Command.Item>
              ))}
            </Command.List>
          </Command>
        </div>
      )}
    </div>
  )
}

export { BranchCombobox }
