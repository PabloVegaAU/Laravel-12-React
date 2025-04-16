import type { Actividad } from './actividad.d.ts'
import type { Alumno } from './alumno.d.ts'
import type { Carpeta } from './carpeta.d.ts'

export type TaskType = 'TAREA' | 'RETO'
export type TaskStatus = 'INACTIVO' | 'ACTIVO'

export type Tarea = {
  id: number
  titulo: string
  descripcion: string
  tipo: TaskType
  estado: TaskStatus
  carpeta_id: number
  alumnos?: Alumno[]
  actividades?: Actividad[]
  carpeta?: Carpeta
  created_at: string
  updated_at: string
  nota_final?: number
  estado_tarea?: string
  hora_inicio?: string
  hora_final?: string
  tiempo_transcurrido?: number
}
