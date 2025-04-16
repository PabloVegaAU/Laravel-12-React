import type { Image } from '../core/image'
import type { Alumno } from '../user/alumno'
import type { Actividad } from './actividad' // Usamos import type para evitar problemas de dependencia circular

export interface Respuesta {
  id: number
  actividad_id: number
  alumno_id: number // Referencia a alumnos.user_id
  descripcion: string
  puntaje?: number | null
  es_correcta?: boolean | null // De la migración
  intentos?: number | null // De la migración
  actividad?: Actividad
  alumno?: Alumno
  image?: Image | null // Una respuesta puede tener una imagen
  created_at: string
  updated_at: string
}
