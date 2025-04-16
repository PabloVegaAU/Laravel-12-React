import type { FlashMessage } from '@/types'

type FlashMesssageProps = {
  flash?: FlashMessage
}

export default function FlashMesssage({ flash }: FlashMesssageProps) {
  if (!flash || flash.level !== 'notice') return null

  const styles: Record<string, string> = {
    notice: 'bg-green-100 text-green-800',
    success: 'bg-green-100 text-green-800',
    error: 'bg-red-100 text-red-800',
    warning: 'bg-yellow-100 text-yellow-800'
  }

  const colorClass = styles[flash.level] ?? 'bg-gray-100 text-gray-800'

  return <div className={`mb-4 rounded p-3 ${colorClass}`}>{flash.message}</div>
}
