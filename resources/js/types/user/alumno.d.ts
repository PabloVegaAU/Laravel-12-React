import type { AlumnoLogro } from './alumno-logro.d.ts'
import type { AlumnoTarea } from './alumno-tarea.d.ts'
import type { Level } from './level.d.ts'
import type { Logro } from './logro.d.ts'
import type { Respuesta } from './respuesta.d.ts'
import type { Seccion } from './seccion.d.ts'
import type { Tarea } from './tarea.d.ts'
import type { User } from './user/user.d.ts'

export interface Alumno {
  user_id: number
  seccion_id?: number
  seccion?: Seccion
  level?: Level[]
  logros?: Logro[]
  tareas?: Tarea[]
  aulas?: Aula[]
  alumnos_tareas?: AlumnoTarea[]
  alumnos_logros?: AlumnoLogro[]
  respuestas?: Respuesta[]
  created_at: string
  updated_at: string
  user?: User
}
