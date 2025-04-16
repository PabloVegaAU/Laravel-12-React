import type { Aula } from '../aula/aula.d.ts'
import type { AlumnoLogro } from './alumno-logro.d.ts'
import type { AlumnoTarea } from './alumno-tarea.d.ts'
import type { Level } from './level.d.ts'
import type { Logro } from './logro.d.ts'
import type { Respuesta } from './respuesta.d.ts'
import type { Tarea } from './tarea.d.ts'
import type { User } from './user/user.d.ts'

export type Alumno = {
  user_id: number
  level?: Level[]
  logros?: Logro[]
  tareas?: Tarea[]
  aula_actual?: AulaAlumno
  aulas?: AulaAlumno[]
  alumnos_tareas?: AlumnoTarea[]
  alumnos_logros?: AlumnoLogro[]
  respuestas?: Respuesta[]
  created_at: string
  updated_at: string
  user?: User
}

export type AulaAlumno = {
  id: number
  aula_id: number
  alumno_id: number
  es_actual: boolean
  estado: string
  created_at: string
  updated_at: string
  deleted_at: string
  aula?: Aula
}
