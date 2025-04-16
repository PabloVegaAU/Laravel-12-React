import { type ClassValue, clsx } from 'clsx'
import { twMerge } from 'tailwind-merge'

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs))
}

export function getNestedValue(obj: any, path: string): any {
  return path.split('.').reduce((o, key) => o?.[key], obj)
}
