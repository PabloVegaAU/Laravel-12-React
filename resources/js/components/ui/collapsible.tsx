import { cn } from '@/lib/utils'
import * as CollapsiblePrimitive from '@radix-ui/react-collapsible'
import React, { createContext, ReactNode, useCallback, useContext, useMemo, useState } from 'react'

interface CollapseContextValue {
  open: boolean
  setOpen: React.Dispatch<React.SetStateAction<boolean>>
  triggerId: string
  contentId: string
}

const CollapseContext = createContext<CollapseContextValue | undefined>(undefined)

function useCollapseContext() {
  const context = useContext(CollapseContext)
  if (!context) throw new Error('Collapse components must be used within a Collapse provider')
  return context
}

interface CollapseProps {
  children: ReactNode
  className?: string
  id?: string
  opened?: boolean
}

export function Collapse({ children, className = '', id, opened = false }: CollapseProps) {
  const [open, setOpen] = useState(opened)

  // Generar IDs únicos para trigger y contenido
  const baseId = useMemo(() => id ?? `collapse-${Math.random().toString(36).slice(2, 9)}`, [id])
  const triggerId = `${baseId}-trigger`
  const contentId = `${baseId}-content`

  // Memoizar el contexto para evitar renders innecesarios
  const contextValue = useMemo(() => ({ open, setOpen, triggerId, contentId }), [open, setOpen, triggerId, contentId])

  return (
    <CollapseContext.Provider value={contextValue}>
      <CollapsiblePrimitive.Root open={open} onOpenChange={setOpen} className={cn('group', className)}>
        {children}
      </CollapsiblePrimitive.Root>
    </CollapseContext.Provider>
  )
}

interface CollapsibleTriggerProps extends React.HTMLAttributes<HTMLDivElement> {
  children: ReactNode
  className?: string
}

export const CollapsibleTrigger = React.memo(function CollapsibleTrigger({ children, className = '', ...props }: CollapsibleTriggerProps) {
  const { open, setOpen, triggerId, contentId } = useCollapseContext()

  // Memoizar handlers para evitar recrearlos en cada render
  const handleClick = useCallback(() => setOpen(!open), [open, setOpen])
  const handleKeyDown = useCallback(
    (e: React.KeyboardEvent<HTMLDivElement>) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault()
        setOpen(!open)
      }
    },
    [open, setOpen]
  )

  return (
    <div
      id={triggerId}
      role='button'
      tabIndex={0}
      aria-expanded={open}
      aria-controls={contentId}
      onClick={handleClick}
      onKeyDown={handleKeyDown}
      className={cn('flex w-full cursor-pointer items-center justify-between rounded-lg bg-gray-50 p-2 text-left hover:bg-gray-100', className)}
      {...props}
    >
      {children}
      <svg
        className={cn('h-5 w-5 shrink-0 transition-transform duration-300', open && 'rotate-180')}
        fill='none'
        viewBox='0 0 24 24'
        stroke='currentColor'
        aria-hidden='true'
      >
        <path strokeLinecap='round' strokeLinejoin='round' strokeWidth='2' d='M19 9l-7 7-7-7' />
      </svg>
    </div>
  )
})

interface CollapsibleContentProps extends React.HTMLAttributes<HTMLDivElement> {
  children: ReactNode
  className?: string
}

export const CollapsibleContent = React.memo(function CollapsibleContent({ children, className = '', ...props }: CollapsibleContentProps) {
  const { open, triggerId, contentId } = useCollapseContext()

  return (
    <CollapsiblePrimitive.CollapsibleContent
      id={contentId}
      aria-labelledby={triggerId}
      className={cn(
        'overflow-hidden transition-[max-height,opacity] duration-500 ease-in-out',
        open ? 'max-h-screen opacity-100' : 'max-h-0 opacity-0',
        className
      )}
      {...props}
    >
      {children}
    </CollapsiblePrimitive.CollapsibleContent>
  )
})
