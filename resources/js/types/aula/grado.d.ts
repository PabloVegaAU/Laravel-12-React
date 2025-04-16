import { Nivel } from './nivel'

export type Grado = {
  id: number
  nombre: string
  nivel: Nivel | null
  created_at: string
  updated_at: string
}
