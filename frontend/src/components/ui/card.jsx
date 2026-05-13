import * as React from 'react'
import { cn } from '@/lib/utils'

const Card = React.forwardRef(({ className, ...props }, ref) => (
  <div
    ref={ref}
    className={cn('rounded-md border border-muted bg-surface text-foreground shadow-[0_0_4px_1px_#21262d,8px_8px_12px_rgba(0,0,0,0.5)]', className)}
    {...props}
  />
))
Card.displayName = 'Card'

const CardContent = React.forwardRef(({ className, ...props }, ref) => (
  <div ref={ref} className={cn('p-5', className)} {...props} />
))
CardContent.displayName = 'CardContent'

export { Card, CardContent }
