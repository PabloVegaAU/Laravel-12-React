import type { Alumno } from '../user/alumno'
import type { Actividad } from './actividad'

export type Respuesta = {
  id: number
  actividad_id: number
  alumno_id: number
  descripcion: string
  puntaje?: number | null
  es_correcta?: boolean | null
  intentos?: number | null
  actividad?: Actividad
  alumno?: Alumno
  image?: string | null
  created_at: string
  updated_at: string
}
