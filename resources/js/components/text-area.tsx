import { cn } from '@/lib/utils'
import type * as React from 'react'
import { useEffect, useRef } from 'react'

type TextAreaProps = React.TextareaHTMLAttributes<HTMLTextAreaElement>

function TextArea({ className, ...props }: TextAreaProps) {
  const ref = useRef<HTMLTextAreaElement>(null)

  useEffect(() => {
    const textarea = ref.current
    if (!textarea) return

    const resize = () => {
      textarea.style.height = '38px'
      textarea.style.height = `${textarea.scrollHeight}px`
    }

    resize()

    textarea.addEventListener('input', resize)
    return () => textarea.removeEventListener('input', resize)
  }, [])

  return (
    <textarea
      ref={ref}
      data-slot='input'
      className={cn(
        'resize-none overflow-hidden',
        'border-input file:text-foreground placeholder:text-muted-foreground selection:bg-primary selection:text-primary-foreground flex w-full min-w-0 rounded-md border bg-transparent px-3 py-1 text-base shadow-xs transition-[color,box-shadow] outline-none file:inline-flex file:h-7 file:border-0 file:bg-transparent file:text-sm file:font-medium disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm',
        'focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px]',
        'aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive',
        className
      )}
      {...props}
    />
  )
}

export { TextArea }
