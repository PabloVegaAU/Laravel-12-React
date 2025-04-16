import { Nivel } from '../academic'

export interface Grado {
  id: number
  nombre: string
  nivel: Nivel | null
  created_at: string
  updated_at: string
}
