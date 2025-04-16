import type { Image } from '../core/image'
import type { Respuesta } from './respuesta'
import type { Tarea } from './tarea'

export interface Actividad {
  id: number
  descripcion: string
  recurso?: string | null
  tipo: 'PREGUNTA CORTA' | 'PREGUNTA LARGA' | 'VIDEO' | 'LINK'
  puntaje_max?: number | null
  tarea_id: number
  tarea?: Tarea // Relación belongsTo Tarea
  respuestas?: Respuesta[] // Relación hasMany Respuesta
  image?: Image | null // Relación morphOne Image
  created_at: string
  updated_at: string
}
