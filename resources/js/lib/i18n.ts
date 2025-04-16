import { usePage } from '@inertiajs/react'

export function t(key: string, fallback = ''): string {
  const { translations } = usePage().props
  const segments = key.split('.')
  const group = segments.shift()! // primer segmento
  let node: any = (translations as Record<string, unknown>)[group] || {}

  for (const seg of segments) {
    if (node && typeof node === 'object' && seg in node) {
      node = node[seg]
    } else {
      return fallback
    }
  }

  return typeof node === 'string' ? node : fallback
}
