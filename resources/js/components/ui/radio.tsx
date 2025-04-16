import * as RadioPrimitive from '@radix-ui/react-radio-group'
import { CheckIcon } from 'lucide-react'
import type * as React from 'react'

import { cn } from '@/lib/utils'

function RadioGroup({ className, ...props }: React.ComponentProps<typeof RadioPrimitive.Root>) {
  return <RadioPrimitive.Root data-slot='radio-group' className={`grid grid-cols-2 gap-2 ${className}`} {...props} />
}

function Radio({ className, ...props }: React.ComponentProps<typeof RadioPrimitive.Item>) {
  return (
    <RadioPrimitive.Item
      className={cn(
        'peer border-input data-[state=checked]:bg-primary data-[state=checked]:text-primary-foreground data-[state=checked]:border-primary focus-visible:border-ring focus-visible:ring-ring/50 aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive size-4 shrink-0 rounded-[4px] border shadow-xs transition-shadow outline-none focus-visible:ring-[3px] disabled:cursor-not-allowed disabled:opacity-50',
        className
      )}
      {...props}
    >
      <RadioPrimitive.Indicator className='flex items-center justify-center text-current transition-none'>
        <CheckIcon className='size-3.5' />
      </RadioPrimitive.Indicator>
    </RadioPrimitive.Item>
  )
}

export { Radio, RadioGroup }
