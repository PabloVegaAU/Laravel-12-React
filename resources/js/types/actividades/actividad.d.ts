import type { Respuesta } from './respuesta'
import type { Tarea } from './tarea'

export type ActivityType = 'PREGUNTA CORTA' | 'PREGUNTA LARGA' | 'VIDEO' | 'LINK'

export type Actividad = {
  id: number
  descripcion: string
  recurso?: string | null
  tipo: ActivityType
  puntaje_max?: number | null
  tarea_id: number
  tarea?: Tarea
  respuestas?: Respuesta[]
  image?: string | null
  created_at: string
  updated_at: string
}
