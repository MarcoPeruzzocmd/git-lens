import * as React from 'react'
import { cn } from '@/lib/utils'

function Badge({ className, ...props }) {
  return (
    <span
      className={cn(
        'inline-flex items-center font-mono text-xs font-bold tracking-wide',
        className
      )}
      {...props}
    />
  )
}

export { Badge }
